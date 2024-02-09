import React, { useState } from "react";
import { Form, Button, Alert } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { storage } from '../../utils/storage';

export default function IdiomesAfegeix(props) {
    const [idioma, setIdioma] = useState("");
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const token = props.api_token;

    const guardaIdioma = () => {
        if (idioma.trim() === '') {
            setError("El nom de l'idioma és obligatori.");
            return;
        }

        fetch('http://balearc.aurorakachau.com/public/api/idiomes', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                idioma: idioma
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error en guardar l'idioma.");
                } else {
                    setError('');
                    navigate('/idiomes');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error en guardar l'idioma.");
            });
    }

    return (
        <div>
            <hr />
            <h1>Afegir Idioma</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Nom de l'Idioma</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom de l'idioma"
                        name="idioma"
                        value={idioma}
                        onChange={(e) => setIdioma(e.target.value)}
                    />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaIdioma}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/idiomes")}>
                    Cancel·la
                </Button>
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
