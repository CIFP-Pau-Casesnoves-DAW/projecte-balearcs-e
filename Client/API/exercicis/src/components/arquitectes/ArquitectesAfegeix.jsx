import React, { useState } from 'react';
import { Form, Button, Alert } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';

export default function ArquitectesAfegeix(props) {
    const [nomArquitecte, setNomArquitecte] = useState('');
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const token = props.api_token;

    const guardaArquitecte = () => {
        if (nomArquitecte.trim() === '') {
            setError('El nom de l\'arquitecte és obligatori.');
            return;
        }

        fetch('http://balearc.aurorakachau.com/public/api/arquitectes', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom: nomArquitecte
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError('Error en guardar l\'arquitecte.');
            } else {
                setError('');
                navigate('/arquitectes');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError('Error en guardar l\'arquitecte.');
        });
    };

    return (
        <div>
            <hr />
            <h1>Afegir Arquitecte</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Nom de l'Arquitecte</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom de l'arquitecte"
                        name="arquitecte"
                        value={nomArquitecte}
                        onChange={(e) => setNomArquitecte(e.target.value)}
                    />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaArquitecte}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate('/arquitectes')}>
                    Cancel·la
                </Button>
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
