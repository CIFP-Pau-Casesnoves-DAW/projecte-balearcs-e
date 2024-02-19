import React, { useState } from 'react';
import { Form, Button, Alert } from 'react-bootstrap';

function FormulariAfegirPuntInteres({ api_token, espai_id, onCancel }) {
    const [titol, setTitol] = useState('');
    const [descripcio, setDescripcio] = useState('');
    const [error, setError] = useState('');
    const [confirmationMessage, setConfirmationMessage] = useState('');
    const idespai = espai_id;
    const token = api_token;

    const handleAfegir = async () => {
        try {
            const response = await fetch('http://balearc.aurorakachau.com/public/api/punts_interes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    titol: titol,
                    descripcio: descripcio,
                    espai_id: idespai
                })
            });
            const data = await response.json();
            if (response.ok) {
                setConfirmationMessage('Punt d\'interès afegit correctament.');
                setTitol('');
                setDescripcio('');
            } else {
                setError(data.message || 'Hi ha hagut un error en afegir el punt d\'interès.');
            }
        } catch (error) {
            console.error('Error al afegir punt d\'interès:', error);
            setError('Hi ha hagut un error en afegir el punt d\'interès.');
        }
    };

    return (
        <Form>
            <Form.Group className="mb-3">
                <Form.Label>Títol:</Form.Label>
                <Form.Control
                    type="text"
                    placeholder="Títol del punt d'interès"
                    value={titol}
                    onChange={(e) => setTitol(e.target.value)}
                />
            </Form.Group>
            <Form.Group className="mb-3">
                <Form.Label>Descripció:</Form.Label>
                <Form.Control
                    as="textarea"
                    rows={3}
                    placeholder="Descripció del punt d'interès"
                    value={descripcio}
                    onChange={(e) => setDescripcio(e.target.value)}
                />
            </Form.Group>
            <Button variant="primary" onClick={handleAfegir}>
                Afegir
            </Button>
            <Button variant="danger" onClick={onCancel}>
                Cancel·lar
            </Button>
            <br />
            {confirmationMessage && (
                <div className="alert alert-success" role="alert">
                    <p>{confirmationMessage}</p>
                </div>
            )}
            {error && <Alert variant="danger">{error}</Alert>}
        </Form>
    );
}

export default FormulariAfegirPuntInteres;
