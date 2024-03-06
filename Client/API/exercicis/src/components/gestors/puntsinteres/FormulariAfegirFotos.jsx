import React, { useState } from "react";
import { Form, Button, Alert } from "react-bootstrap";
import axios from 'axios';

export default function FormulariAfegirFotos(props) {
    const { espai_id, punt_interes_id, api_token, onCancel } = props;

    const [foto, setFoto] = useState(null);
    const [comentari, setComentari] = useState("");
    const [error, setError] = useState('');
    const [successMessage, setSuccessMessage] = useState('');

    const handleFileChange = (event) => {
        setFoto(event.target.files[0]);
    }

    const guardaFoto = async () => {
        if (!foto || !punt_interes_id || !espai_id) {
            setError("Tots els camps són obligatoris.");
            return;
        }

        const formData = new FormData();
        formData.append('foto', foto);
        formData.append('espai_id', espai_id);
        formData.append('punt_interes_id', punt_interes_id);
        formData.append('comentari', comentari);

        try {
            const response = await axios.post('http://balearc.aurorakachau.com/public/api/fotos', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Authorization': `Bearer ${api_token}`
                }
            });

            console.log(response.data);
            setSuccessMessage('Foto afegida correctament.');
            setError('');
            // Aquí pots gestionar la redirecció o altres accions després d'afegir la foto amb èxit
        } catch (error) {
            console.error('Error:', error);
            setError("Error en guardar la foto.");
        }
    }

    return (
        <div>
            <hr />
            <h1>Afegir Foto</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Foto</Form.Label>
                    <Form.Control
                        type="file"
                        name="foto"
                        onChange={handleFileChange}
                    />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Comentari</Form.Label>
                    <Form.Control
                        type="text"
                        name="comentari"
                        onChange={(event) => setComentari(event.target.value)}
                    />
                </Form.Group>

                <Button variant="primary" type="button" onClick={guardaFoto}>
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
