import React, { useState, useEffect } from 'react';
import { Form, Button, Alert, Spinner } from 'react-bootstrap';
import { storage } from '../utils/storage.js';

export default function UsuariDades() {
    const [llinatges, setLlinatges] = useState('');
    const [nom, setNom] = useState('');
    const [dni, setDni] = useState('');
    const [email, setEmail] = useState('');
    const [contrasenya, setContrasenya] = useState('');
    const [contrasenyaactual, setContrasenyaactual] = useState('');
    const [confirmationMessage, setConfirmationMessage] = useState('');
    const [error, setError] = useState('');
    const [showForm, setShowForm] = useState(false);
    const [loading, setLoading] = useState(false);
    const id = storage.get('usuari_id');
    const token = storage.get('api_token');

    useEffect(() => {
        fetchDadesUsuari();
    }, []);

    const fetchDadesUsuari = async () => {
        setLoading(true);
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/usuaris/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const data = await response.json();
            setLlinatges(data.data.llinatges);
            setNom(data.data.nom);
            setDni(data.data.dni);
            setEmail(data.data.mail);
            setContrasenya(data.data.contrasenya);
            setContrasenyaactual(data.data.contrasenya);
        } catch (error) {
            setError('Error al descarregar les dades de l\'usuari');
            console.error('Error en descarregar les dades de l\'usuari:', error);
        }
        setLoading(false);
    };

    const handleFormSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/usuaris/${id}`, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    nom: nom,
                    llinatges: llinatges,
                    // dni: dni
                    //email: email
                })
            });
            const responseData = await response.json();
            if (response.ok) {
                setConfirmationMessage('Dades personals actualitzades! La propera vegada que inicieu sessió veureu les dades actualitzades.');
            } else {
                setError(responseData.message || 'Error al actualitzar les dades personals');
            }
        } catch (error) {
            setError('Error al actualitzar les dades personals');
            console.error('Error al actualitzar les dades personals:', error);
        }
        setLoading(false);
    };

    return (
        <div>
            <Form onSubmit={handleFormSubmit}>
                <Form.Group className="mb-3">
                    <Form.Label>Nom:</Form.Label>
                    <Form.Control
                        type="text"
                        value={nom}
                        onChange={(e) => setNom(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Llinatges:</Form.Label>
                    <Form.Control
                        type="text"
                        value={llinatges}
                        onChange={(e) => setLlinatges(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>DNI:</Form.Label>
                    <Form.Control
                        type="text"
                        value={dni}
                        // onChange={(e) => setDni(e.target.value)}
                        readOnly
                        disabled
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Correu:</Form.Label>
                    <Form.Control
                        type="text"
                        value={email}
                        // onChange={(e) => setEmail(e.target.value)}
                        readOnly
                        disabled
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Contrasenya actual:</Form.Label>
                    <Form.Control
                        type="text"
                        value={contrasenyaactual}
                        // onChange={(e) => setEmail(e.target.value)}
                        readOnly
                        disabled
                    />
                    <br />
                   <Form.Label>Nova Contrasenya:</Form.Label>
                    <Form.Control
                        type="text"
                        value={contrasenya}
                        // onChange={(e) => setEmail(e.target.value)}
                        readOnly
                        disabled
                    />
                    
                </Form.Group>
                <Button type="submit" disabled={loading}>
                    Guardar
                </Button>
                <Button variant="warning" type="button" onClick={() => { window.location.reload(); }}>
                    Cancel·la
                </Button>
                <Button variant="info" type="button" onClick={() => { window.location.reload(); }}>
                    Ocultar
                </Button>
            </Form>
            {loading && <Spinner animation="border" />}
            <br />
            {confirmationMessage && (
                <div className="alert alert-success" role="alert">
                    <p>{confirmationMessage}</p>
                </div>
            )}
            {error && <Alert variant="danger">{error}</Alert>}
            <hr />
        </div>
    );
}