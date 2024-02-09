import React, { useState } from "react";
import { Form, Button, Alert } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { storage } from '../../utils/storage';

export default function ServeisAfegeix(props) {
    const [nom_serveis, setNomServeis] = useState("");
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const token = props.api_token;

    const guardaServei = () => {
        if (nom_serveis.trim() === '') {
            setError("El nom del servei és obligatori.");
            return;
        }

        fetch('http://balearc.aurorakachau.com/public/api/serveis', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom_serveis: nom_serveis
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error al guardar el servei.");
                } else {
                    setError('');
                    navigate('/serveis');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error al guardar el servei.");
            });
    }

    return (
        <div>
            <hr />
            <h1>Afegir Servei</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Nom del Servei</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom del servei"
                        name="servei"
                        value={nom_serveis}
                        onChange={(e) => setNomServeis(e.target.value)}
                    />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaServei}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/serveis")}>
                    Cancel·la
                </Button>
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
