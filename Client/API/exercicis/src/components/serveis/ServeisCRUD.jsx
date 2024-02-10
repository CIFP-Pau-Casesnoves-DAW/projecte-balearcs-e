import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";

export default function ServeisCRUD(props) {
    const [nomServei, setNomServei] = useState("");
    const [error, setError] = useState('');
    const [edita, setEdita] = useState(false);
    const [descarregant, setDescarregant] = useState(false);
    const { id } = useParams();
    const navigate = useNavigate();
    const token = props.api_token;

    useEffect(() => {
        if (id !== "-1") {
            descarregaServei();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarregaServei = async () => {
        setDescarregant(true);
        setEdita(true);
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/serveis/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            setNomServei(responseData.data.nom_serveis);
        } catch (error) {
            console.log(error);
        }
        setDescarregant(false);
    }

    const guardaServei = () => {
        if (edita) {
            modificaServei();
        } else {
            creaServei();
        }
    }

    const creaServei = () => {
        fetch('http://balearc.aurorakachau.com/public/api/serveis', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom_serveis: nomServei
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                setError("Error al crear el servei.");
                } else {
                    setError('');
                    navigate('/serveis');
                }
            })
    }

    const modificaServei = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/serveis/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom_serveis: nomServei
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                    setError("Error al crear el servei.");
                } else {
                    setError('');
                    navigate('/serveis');
                }
            })
    }

    const esborraServei = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/serveis/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        }).then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error al crear el servei.");
                } else {
                    navigate('/serveis');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error al eliminar el servei.");
            });
    }

    if (descarregant) {
        return <Spinner />
    }

    return (
        <div>
            <Form>
                {edita &&
                    <Form.Group className="mb-3">
                        <Form.Label>Id</Form.Label>
                        <Form.Control type="text" name="id" value={id} disabled />
                    </Form.Group>
                }
                <Form.Group className="mb-3">
                    <Form.Label>Nom del Servei</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom del servei"
                        value={nomServei}
                        onChange={(e) => setNomServei(e.target.value)}
                    />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaServei}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/serveis")}>
                    Cancel·la
                </Button>
                {edita &&
                    <Button variant="danger" type="button" onClick={esborraServei}>
                        Esborra
                    </Button>
                }
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
