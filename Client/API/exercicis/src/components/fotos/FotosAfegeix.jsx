import React, { useState } from "react";
import { Form, Button, Alert } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { SelectEspais } from "./SelectEspais";
import { SelectPuntsInteres } from "./SelectPunts";
import axios from 'axios';

export default function FotosAfegeix(props) {
    const [foto, setFoto] = useState(null);
    const [espai_id, setEspai_id] = useState("");
    const [punt_interes_id, setPunt_interes_id] = useState("");
    const [comentari, setComentari] = useState("");
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
        formData.append('comentari', comentari);

        axios.post('http://balearc.aurorakachau.com/public/api/fotos', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'Authorization': `Bearer ${token}`
            }
        })
            .then(response => {
                console.log(response.data);
                setError('');
                navigate('/fotos');
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
                    <Form.Label>Espai: <strong>{espai_id}</strong></Form.Label>
                    <SelectEspais id={espai_id} api_token={token} onChange={(value) => { setEspai_id(value) }} />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Punt Interés: <strong>{punt_interes_id}</strong></Form.Label>
                    <SelectPuntsInteres idEspai={espai_id} api_token={token} onChange={(value) => { setPunt_interes_id(value) }} />
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
                <Button variant="warning" type="button" onClick={() => navigate("/fotos")}>
                    Cancel·la
                </Button>
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
