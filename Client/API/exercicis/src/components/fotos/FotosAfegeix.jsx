import React, { useState } from "react";
import { Form, Button, Alert } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { SelectEspais, SelectPuntsInteres } from "./SelectEspaisPunts";

export default function FotosAfegeix(props) {
    const [foto, setFoto] = useState(null);
    const [espai_id, setEspai_id] = useState("");
    const [punt_interes_id, setPunt_interes_id] = useState("");
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const token = props.api_token;

    const handleFileChange = (event) => {
        setFoto(event.target.files[0]);
    }

    const guardaFoto = () => {
        if (!foto || punt_interes_id.trim() === '' || espai_id.trim() === '' || punt_interes_id === "-1" || espai_id === "-1") {
            setError("Tots els camps són obligatoris.");
            return;
        }

        const formData = new FormData();
        formData.append('foto', foto);
        formData.append('espai_id', espai_id);
        formData.append('punt_interes_id', punt_interes_id);

        fetch('http://balearc.aurorakachau.com/public/api/fotos', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error en guardar la foto.");
                } else {
                    setError('');
                    navigate('/fotos');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error en guardar la foto.");
            });
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
                    <Form.Label>Espai:</Form.Label>
                    <SelectEspais id={espai_id} onChange={(e) => { setEspai_id(e.target.value) }} />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Punt Interés:</Form.Label>
                    <SelectPuntsInteres id={punt_interes_id} onChange={(e) => { setPunt_interes_id(e.target.value) }} />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaFoto}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/fotos")}>
                    Cancel·la
                </Button>
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
