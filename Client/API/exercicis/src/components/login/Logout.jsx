import React from 'react';
import { storage } from '../../utils/storage';
import { Button, Container, Form, Alert } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import { useState } from 'react';
import '../../style/Style.css'; // Importa l'arxiu CSS

export default function Logout() {
    const id = storage.get('usuari_id');
    const [error, setError] = useState(false);
    const [loading, setLoading] = useState(false);
    const navigate = useNavigate();

    const ferLogout = (event) => {
        event.preventDefault(); // Evita el envío del formulario por defecto
        setLoading(true);
        fetch(`http://balearc.aurorakachau.com/public/api/logout/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en el logout');
                }
                return response.json();
            })
            .then(respostajson => {
                if (respostajson.status === "success") {
                    setError(false);
                    tancar(); // Cierra la sesión antes de redirigir
                    window.location.href = "/inici"; // Redirige a la página de login
                } else {
                    setError(true);
                }
                setLoading(false);
            })
            .catch(function (error) {
                console.log(error);
                setError(true);
                setLoading(false);
            });
    };

    const tancar = () => {
        storage.remove('api_token');
        storage.remove('usuari_id');
        storage.remove('usuari_rol');
        storage.remove('usuari_nom');
    }

    return (
        <div className='contingut'>
            <Container className="logout-container">

                    <h2 className="logout-title">Voleu sortir de la sessió?</h2>
                    <Form onSubmit={ferLogout} action="/inici">
                        <Button variant="primary" type="submit" className="logout-button">
                            Sortir
                        </Button>
                    </Form>
                    {error && <Alert variant="danger">No se ha pogut fer logout.</Alert>}
            </Container>
        </div>
    );
}
