import React, { useState, useEffect } from 'react';
import { Form, Button, Alert, Spinner } from 'react-bootstrap';

export default function UsuariDades(props) {
    const [llinatges, setLlinatges] = useState('');
    const [nom, setNom] = useState('');
    const [dni, setDni] = useState('');
    const [email, setEmail] = useState('');
    const [contrasenya, setContrasenya] = useState('');
    const [confirmationMessage, setConfirmationMessage] = useState('');
    const [error, setError] = useState('');
    const [showForm, setShowForm] = useState(false);
    const [loading, setLoading] = useState(false);
    const id = props.usuari_id;
    const token = props.api_token;

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
            if(contrasenya==='' || contrasenya===null){
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
                    })
                });
                const responseData = await response.json();
                if (response.ok) {
                    setConfirmationMessage('Dades personals actualitzades! La propera vegada que inicieu sessió veureu les dades actualitzades.');
                } else {
                    setError(responseData.message || 'Error al actualitzar les dades personals');
                }
            }
            else{
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
                        contrasenya: contrasenya
                    })
                });
                const responseData = await response.json();
                if (response.ok) {
                    setConfirmationMessage('Dades personals actualitzades! La propera vegada que inicieu sessió veureu les dades actualitzades.');
                } else {
                    setError(responseData.message || 'Error al actualitzar les dades personals');
                }
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
                        readOnly
                        disabled
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Correu:</Form.Label>
                    <Form.Control
                        type="text"
                        value={email}
                        readOnly
                        disabled
                    />
                </Form.Group>
                <Form.Group className='mb-3'>
                    <Form.Label>Cambiar Contrasenya:</Form.Label>
                        <Form.Control
                            type="text"
                            placeholder='Contrasenya'
                            onChange={(e) => setContrasenya(e.target.value)}
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
