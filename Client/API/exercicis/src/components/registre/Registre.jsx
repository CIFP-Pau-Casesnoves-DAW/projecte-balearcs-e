import React, { useState } from 'react';
import { Form, Button, Alert } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';

export default function Registre() {
    const [nom, setNom] = useState('');
    const [llinatges, setLlinatges] = useState('');
    const [dni, setDni] = useState('');
    const [email, setEmail] = useState('');
    const [contrasenya, setContrasenya] = useState('');
    const [confirmarContrasenya, setConfirmarContrasenya] = useState('');
    const [error, setError] = useState('');
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (contrasenya !== confirmarContrasenya) {
            setError("Les contrasenyes no coincideixen");
            return;
        }

        try {
            const response = await fetch('http://balearc.aurorakachau.com/public/api/usuaris', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    // Aquí no necessitem l'autorització si estem registrant un nou usuari
                },
                body: JSON.stringify({
                    nom: nom,
                    llinatges: llinatges,
                    dni: dni,
                    mail: email,
                    contrasenya: contrasenya
                })
            });
            const data = await response.json();
            console.log(data);
            console.log(response);
            if (data.status === "success") {
                // L'usuari s'ha creat amb èxit, ara farem el registre
                console.log(data);
                const idNouUsuari = data.data.id; 
                const registreResponse = await fetch(`http://balearc.aurorakachau.com/public/api/usuaris/registre/${idNouUsuari}`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        // Aquí podríem afegir l'autorització si és necessari
                    },
                    body: JSON.stringify({
                    })
                });

                if (registreResponse.ok) {
                    // Registre amb èxit, redirigeix a la pàgina de login
                    navigate('/login');
                } else {
                    setError('Error en el registre');
                }
            } else {
                setError(data.error || 'Error en el registre');
            }
        } catch (error) {
            console.error('Error en el registre:', error);
            setError('Error en el registre');
        }
    };

    return (
        <div className="container">
            <hr />
            <h1>Registre</h1>
            <hr />
            <Form onSubmit={handleSubmit}>
                <Form.Group className="mb-3">
                    <Form.Label>Nom:</Form.Label>
                    <Form.Control type="text" value={nom} onChange={(e) => setNom(e.target.value)} />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Llinatges:</Form.Label>
                    <Form.Control type="text" value={llinatges} onChange={(e) => setLlinatges(e.target.value)} />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>DNI:</Form.Label>
                    <Form.Control type="text" value={dni} onChange={(e) => setDni(e.target.value)} />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Email:</Form.Label>
                    <Form.Control type="email" value={email} onChange={(e) => setEmail(e.target.value)} />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Contrasenya:</Form.Label>
                    <Form.Control type="password" value={contrasenya} onChange={(e) => setContrasenya(e.target.value)} />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Confirmar Contrasenya:</Form.Label>
                    <Form.Control type="password" value={confirmarContrasenya} onChange={(e) => setConfirmarContrasenya(e.target.value)} />
                </Form.Group>
                {error && <Alert variant="danger">{error}</Alert>}
                <Button variant="primary" type="submit">
                    Registrar
                </Button>
            </Form>
        </div>
    );
}
