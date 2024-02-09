import React, { useState } from "react";
import { Form, Button, Alert } from "react-bootstrap";
import { useNavigate } from "react-router-dom";

export default function ModalitatsAfegeix(props) {
    const [modalitat, setModalitat] = useState("");
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const token = props.api_token;

    const guardaModalitat = () => {
        if (modalitat.trim() === '') {
            setError("El nom de la modalitat és obligatori.");
            return;
        }

        fetch('http://balearc.aurorakachau.com/public/api/modalitats', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom_modalitat: modalitat
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error en guardar la modalitat.");
                } else {
                    setError('');
                    navigate('/modalitats');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error en guardar la modalitat.");
            });
    }

    return (
        <div>
            <hr />
            <h1>Afegir Modalitat</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Nom de la Modalitat</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom de la modalitat"
                        name="modalitat"
                        value={modalitat}
                        onChange={(e) => setModalitat(e.target.value)}
                    />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaModalitat}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/modalitats")}>
                    Cancel·la
                </Button>
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
