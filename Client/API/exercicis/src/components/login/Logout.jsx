import React from 'react';
import { storage } from '../../utils/storage';
import { Button, Container, Form } from 'react-bootstrap';
import '../../style/Style.css'; // Importa l'arxiu CSS

export default function Logout() {
    const handleLogout = () => {
        storage.remove('api_token');
        storage.remove('usuari_id');
        storage.remove('usuari_rol');
        storage.remove('usuari_nom');
    };

    return (
        <Container className="logout-container">
            <h2 className="logout-title">Voleu sortir de la sessió?</h2>
            <Form onSubmit={handleLogout} action="/inici">
                <Button variant="primary" type="submit" className="logout-button">
                    Sortir
                </Button>
            </Form>
        </Container>
    );
}
