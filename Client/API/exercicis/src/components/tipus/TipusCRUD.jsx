import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";
import { storage } from '../../utils/storage';

export default function TipusCRUD(props) {
    const [nomTipus, setNomTipus] = useState("");
    const [error, setError] = useState('');
    const [edita, setEdita] = useState(false);
    const [descarregant, setDescarregant] = useState(false);
    const { id } = useParams();
    const navigate = useNavigate();
    const token = props.api_token;

    useEffect(() => {
        if (id !== "-1") {
            descarregaTipus();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarregaTipus = async () => {
        setDescarregant(true);
        setEdita(true);
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/tipus/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            setNomTipus(responseData.data.nom_tipus);
        } catch (error) {
            console.log(error);
        }
        setDescarregant(false);
    }

    const guardaTipus = () => {
        if (edita) {
            modificaTipus();
        } else {
            creaTipus();
        }
    }

    const creaTipus = () => {
        fetch('http://balearc.aurorakachau.com/public/api/tipus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom_tipus: nomTipus
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                    setError("Error al crear el tipus.");
                } else {
                    setError('');
                    navigate('/tipus');
                }
            })
    }

    const modificaTipus = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/tipus/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom_tipus: nomTipus
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                    setError("Error al modificar el tipus.");
                } else {
                    setError('');
                    navigate('/tipus');
                }
            })
    }

    const esborraTipus = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/tipus/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        }).then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error al esborrar el tipus.");
                } else {
                    navigate('/tipus');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error al esborrar el tipus.");
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
                    <Form.Label>Nom del Tipus</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom del tipus"
                        value={nomTipus}
                        onChange={(e) => setNomTipus(e.target.value)}
                    />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaTipus}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/tipus")}>
                    Cancel·la
                </Button>
                {edita &&
                    <Button variant="danger" type="button" onClick={esborraTipus}>
                        Esborra
                    </Button>
                }
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
