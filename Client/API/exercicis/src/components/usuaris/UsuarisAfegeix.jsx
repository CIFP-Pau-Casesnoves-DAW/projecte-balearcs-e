import React, { useState } from 'react';
import { Form, Button, Alert } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';

export default function UsuarisAfegeix(props) {
    const [nomUsuari, setNomUsuari] = useState('');
    const [llinatgesUsuari, setLlinatgesUsuari] = useState('');
    const [dniUsuari, setDniUsuari] = useState('');
    const [mailUsuari, setMailUsuari] = useState('');
    const [contrasenyaUsuari, setContrasenyaUsuari] = useState('');
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const token = props.api_token;

    const guardaUsuari = () => {
        if (nomUsuari.trim() === '' || llinatgesUsuari.trim() === '' || dniUsuari.trim() === '' || mailUsuari.trim() === '' || contrasenyaUsuari.trim() === '') {
            setError('Tots els camps són obligatoris.');
            return;
        }

        fetch('http://balearc.aurorakachau.com/public/api/usuaris', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom: nomUsuari,
                llinatges: llinatgesUsuari,
                dni: dniUsuari,
                mail: mailUsuari,
                contrasenya: contrasenyaUsuari
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError('Error en guardar l\'usuari.');
            } else {
                setError('');
                navigate('/usuaris');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError('Error en guardar l\'usuari.');
        });
    };

    return (
        <div>
            <hr />
            <h1>Afegir Usuari</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Nom de l'Usuari</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom de l'usuari"
                        value={nomUsuari}
                        onChange={(e) => setNomUsuari(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Llinatges de l'Usuari</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Llinatges de l'usuari"
                        value={llinatgesUsuari}
                        onChange={(e) => setLlinatgesUsuari(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>DNI de l'Usuari</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="DNI de l'usuari"
                        value={dniUsuari}
                        onChange={(e) => setDniUsuari(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Email de l'Usuari</Form.Label>
                    <Form.Control
                        type="email"
                        placeholder="Email de l'usuari"
                        value={mailUsuari}
                        onChange={(e) => setMailUsuari(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Contrasenya de l'Usuari</Form.Label>
                    <Form.Control
                        type="password"
                        placeholder="Contrasenya de l'usuari"
                        value={contrasenyaUsuari}
                        onChange={(e) => setContrasenyaUsuari(e.target.value)}
                    />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaUsuari}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate('/usuaris')}>
                    Cancel·la
                </Button>
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
