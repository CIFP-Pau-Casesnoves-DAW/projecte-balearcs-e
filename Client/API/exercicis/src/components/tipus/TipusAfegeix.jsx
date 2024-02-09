import React, { useState } from "react";
import { Form, Button, Alert } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { storage } from '../../utils/storage';

export default function TipusAfegeix(props) {
    const [nomTipus, setNomTipus] = useState("");
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const token = props.api_token;

    const guardaTipus = () => {
        if (nomTipus.trim() === '') {
            setError("El nom del tipus és obligatori.");
            return;
        }

        fetch('http://balearc.aurorakachau.com/public/api/tipus', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom_tipus: nomTipus
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error al guardar el tipus.");
                } else {
                    setError('');
                    navigate('/tipus');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error al guardar el tipus.");
            });
    }

    return (
        <div>
            <hr />
            <h1>Afegir Tipus</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Nom del Tipus</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom del tipus"
                        name="tipus"
                        value={nomTipus}
                        onChange={(e) => setNomTipus(e.target.value)}
                    />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaTipus}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/tipus")}>
                    Cancel·la
                </Button>
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
