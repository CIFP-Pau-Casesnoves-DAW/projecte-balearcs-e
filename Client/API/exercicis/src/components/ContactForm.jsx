import React, { useState } from 'react';
import { Form, Button, Alert } from 'react-bootstrap';
import Style from '../style/Style.css';

const ContactForm = () => {
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [message, setMessage] = useState('');
    const [error, setError] = useState('');
    const [successMessage, setSuccessMessage] = useState('');

    const handleFormSubmit = (event) => {
        event.preventDefault();
        // Aquí pots afegir la lògica per enviar el formulari al servidor
        // Pots fer servir la informació emmagatzemada en les variables 'name', 'email' i 'message'
        // Per ara, només mostrem un missatge d'èxit fictici
        setSuccessMessage('El teu missatge s\'ha enviat correctament. El nostre equip es posarà en contacte amb tu aviat.');
    };

    return (
        <div className="container mt-5">
            <h2>Contacta amb nosaltres</h2>
            <hr />
            {successMessage && <Alert variant="success">{successMessage}</Alert>}
            <Form onSubmit={handleFormSubmit} className="custom-form"> {/* Afegeix la classe custom-form per als estils personalitzats */}
                <Form.Group controlId="formName">
                    <Form.Label>Nom</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Escriu el teu nom"
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                        required
                    />
                </Form.Group>
                <Form.Group controlId="formEmail">
                    <Form.Label>Correu electrònic</Form.Label>
                    <Form.Control
                        type="email"
                        placeholder="Escriu el teu correu electrònic"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        required
                    />
                </Form.Group>
                <Form.Group controlId="formMessage">
                    <Form.Label>Missatge</Form.Label>
                    <Form.Control
                        as="textarea"
                        rows={4}
                        placeholder="Escriu el teu missatge"
                        value={message}
                        onChange={(e) => setMessage(e.target.value)}
                        required
                    />
                </Form.Group>
                <br />
                <div className="d-grid">
                    <Button variant="primary" type="submit">
                        Envia
                    </Button>
                </div>
            </Form>
        </div>
    );
};

export default ContactForm;
