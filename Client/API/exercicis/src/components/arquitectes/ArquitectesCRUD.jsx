import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";

export default function ArquitectesCRUD(props) {
    const [nomArquitecte, setNomArquitecte] = useState("");
    const [error, setError] = useState('');
    const [edita, setEdita] = useState(false);
    const [descarregant, setDescarregant] = useState(false);
    const { id } = useParams();
    const navigate = useNavigate();
    const token = props.api_token;

    useEffect(() => {
        if (id !== "-1") {
            descarregaArquitecte();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarregaArquitecte = async () => {
        setDescarregant(true);
        setEdita(true);
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/arquitectes/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            setNomArquitecte(responseData.data.nom);
        } catch (error) {
            console.log(error);
        }
        setDescarregant(false);
    }

    const guardaArquitecte = () => {
        if (edita) {
            modificaArquitecte();
        } else {
            creaArquitecte();
        }
    }

    const creaArquitecte = () => {
        fetch('http://balearc.aurorakachau.com/public/api/arquitectes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom: nomArquitecte
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                    setError("Error al crear l'arquitecte.");
                } else {
                    setError('');
                    navigate('/arquitectes');
                }
            })
    }

    const modificaArquitecte = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/arquitectes/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom: nomArquitecte
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                    setError("Error al modificar l'arquitecte.");
                } else {
                    setError('');
                    navigate('/arquitectes');
                }
            })
    }

    const esborraArquitecte = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/arquitectes/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        }).then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error en esborrar l'arquitecte.");
                } else {
                    navigate('/arquitectes');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error en esborrar l'arquitecte.");
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
                    <Form.Label>Nom de l'Arquitecte</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom de l'arquitecte"
                        value={nomArquitecte}
                        onChange={(e) => setNomArquitecte(e.target.value)}
                    />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaArquitecte}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/arquitectes")}>
                    Cancel·la
                </Button>
                {edita &&
                    <Button variant="danger" type="button" onClick={esborraArquitecte}>
                        Esborra
                    </Button>
                }
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
