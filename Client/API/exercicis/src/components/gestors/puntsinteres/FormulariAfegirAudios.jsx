import React, { useState } from "react";
import { Form, Button, Alert } from "react-bootstrap";
import axios from 'axios';

export default function FormulariAfegirAudios(props) {
    const { espai_id, punt_interes_id, api_token, onCancel } = props;

    const [audio, setAudio] = useState(null);
    const [error, setError] = useState('');
    const [successMessage, setSuccessMessage] = useState('');

    const handleFileChange = (event) => {
        setAudio(event.target.files[0]);
    }

    const guardaAudio = async () => {
        if (!audio || !punt_interes_id || !espai_id) {
            setError("Tots els camps són obligatoris.");
            return;
        }

        const formData = new FormData();
        formData.append('audio', audio);
        formData.append('espai_id', espai_id);
        formData.append('punt_interes_id', punt_interes_id);

        try {
            const response = await axios.post('http://balearc.aurorakachau.com/public/api/audios', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${api_token}`
                }
            });

            console.log(response.data);
            setSuccessMessage('Àudio afegit correctament.');
            setError('');
            // Aquí pots gestionar la redirecció o altres accions després d'afegir l'àudio amb èxit
        } catch (error) {
            console.error('Error:', error);
            setError("Error en guardar l'àudio.");
        }
    }

    return (
        <div>
            <hr />
            <h1>Afegir Àudio</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Àudio</Form.Label>
                    <Form.Control
                        type="file"
                        name="audio"
                        onChange={handleFileChange}
                    />
                </Form.Group>

                <Button variant="primary" type="button" onClick={guardaAudio}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={onCancel}>
                    Cancel·la
                </Button>
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
            {successMessage !== '' && <Alert variant="success">{successMessage}</Alert>}
        </div>
    );
}
