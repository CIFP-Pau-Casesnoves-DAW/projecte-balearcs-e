import React, { useState } from "react";
import { Form, Button, Alert } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { storage } from '../../utils/storage';
import SelectEspais from "./SelectEspais";

export default function ComentarisAfegeix() {
    const [comentari, setComentari] = useState("");
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const token = storage.get('api_token'); 
    const id = storage.get('usuari_id');
    const [espai_id, setEspai_id] = useState("");

    const guardaComentari = () => {
        if (comentari.trim() === '' || espai_id.trim() === '' || espai_id === "-1") {
            setError("Tots els camps són obligatoris.");
            return;
        }
    // const guardaComentari = () => {
         fetch('http://balearc.aurorakachau.com/public/api/comentaris', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                comentari: comentari,
                usuari_id: id,
                espai_id: espai_id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError("Error al guardar el comentari.");
            } else {
                setError('');
                navigate('/comentaris');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al guardar el comentari.");
        });
    }

    return (
        <div>
            <hr />
            <h1>Afegir Comentari</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Comentari</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Comentari"
                        name="comentari"
                        value={comentari}
                        onChange={(e) => setComentari(e.target.value)}                        
                    />
                </Form.Group>
                {/* Importam el component selectespais */}
                <Form.Group className="mb-3">
                    <Form.Label>Espai:</Form.Label>
                    <SelectEspais id={espai_id} onChange={(e) => { setEspai_id(e.target.value) }} />
                </Form.Group>
                {/*  */}
                <Button variant="primary" type="button" onClick={guardaComentari}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/comentaris")}>
                    Cancel·la
                </Button>
            </Form>
            <br/>
            {error!=='' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
