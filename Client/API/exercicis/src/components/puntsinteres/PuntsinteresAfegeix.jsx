import React, { useState } from "react";
import { Form, Button, Alert } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { storage } from '../../utils/storage';
import SelectEspais from "./SelectEspais";

export default function PuntsInteresAfegeix(props) {
    const [titol, setTitol] = useState("");
    const [descripcio, setDescripcio] = useState("");
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const token = props.api_token;
    const id = storage.get('usuari_id');
    const [espai_id, setEspai_id] = useState("");

    const guardaPuntInteres = () => {
        if (titol.trim() === '' || descripcio.trim() === '' || espai_id.trim() === '' || espai_id === "-1") {
            setError("Tots els camps són obligatoris.");
            return;
        }
         fetch('http://balearc.aurorakachau.com/public/api/punts_interes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                titol: titol,
                descripcio: descripcio,
                espai_id: espai_id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError("Error al guardar el punt d'interès.");
            } else {
                setError('');
                navigate('/puntsinteres');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al guardar el punt d'interès.");
        });
    }

    return (
        <div>
            <hr />
            <h1>Afegir Punt d'Interès</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Títol</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Títol"
                        name="titol"
                        value={titol}
                        onChange={(e) => setTitol(e.target.value)}                        
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Descripció</Form.Label>
                    <Form.Control
                        as="textarea"
                        rows={3}
                        placeholder="Descripció"
                        name="descripcio"
                        value={descripcio}
                        onChange={(e) => setDescripcio(e.target.value)}                        
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Espai:</Form.Label>
                    <SelectEspais id={espai_id} onChange={(e) => { setEspai_id(e.target.value) }} />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaPuntInteres}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/puntsinteres")}>
                    Cancel·la
                </Button>
            </Form>
            <br/>
            {error!=='' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
