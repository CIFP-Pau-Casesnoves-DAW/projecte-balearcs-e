import React, { useState } from "react";
import { Form, Button, Alert } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import SelectEspais from "../comentaris/SelectEspais";
import SelectUsuaris from "./SelectUsuaris";

export default function ValoracionsAfegeix(props) {
    const [puntuacio, setPuntuacio] = useState("");
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const token = props.api_token;
    const [usuari_id, setUsuari_id] = useState("");
    const [espai_id, setEspai_id] = useState("");

    const guardaValoracio = () => {
        if (puntuacio.trim() === '' || espai_id.trim() === '' || espai_id === "-1" || usuari_id.trim() === '' || usuari_id === "-1") {
            setError("Tots els camps són obligatoris.");
            return;
        }
         fetch('http://balearc.aurorakachau.com/public/api/valoracions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                puntuacio: puntuacio,
                usuari_id: usuari_id,
                espai_id: espai_id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError("Error al guardar la valoració.");
            } else {
                setError('');
                navigate('/valoracions');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al guardar la valoració.");
        });
    }

    return (
        <div>
            <hr />
            <h1>Afegir Valoració</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Puntuació</Form.Label>
                    <Form.Control
                        type="number"
                        placeholder="Puntuació"
                        name="puntuacio"
                        value={puntuacio}
                        onChange={(e) => setPuntuacio(e.target.value)}                        
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Espai:</Form.Label>
                    <SelectEspais id={espai_id} onChange={(e) => { setEspai_id(e.target.value) }} />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Usuari:</Form.Label>
                    <SelectUsuaris id={usuari_id} api_token={token} onChange={(e) => { setUsuari_id(e.target.value) }} />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaValoracio}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/valoracions")}>
                    Cancel·la
                </Button>
            </Form>
            <br/>
            {error!=='' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
