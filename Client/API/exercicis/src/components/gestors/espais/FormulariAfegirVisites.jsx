import React, { useState } from 'react';
import { Form, Button, Alert } from 'react-bootstrap';

function FormulariAfegirVisites({ api_token, espai_id, onCancel }) {
    const [titol, setTitol] = useState('');
    const [descripcio, setDescripcio] = useState('');
    const [inscripcioPrevia, setInscripcioPrevia] = useState('');
    const [nPlaces, setNPlaces] = useState('');
    const [dataInici, setDataInici] = useState('');
    const [dataFi, setDataFi] = useState('');
    const [horari, setHorari] = useState('');
    const [error, setError] = useState('');
    const [confirmationMessage, setConfirmationMessage] = useState('');
    const idespai = espai_id;
    const token = api_token;

    const handleAfegir = async () => {
        try {
            const response = await fetch('http://balearc.aurorakachau.com/public/api/visites', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    titol,
                    descripcio,
                    inscripcio_previa: parseInt(inscripcioPrevia),
                    n_places: parseInt(nPlaces),
                    data_inici: dataInici,
                    data_fi: dataFi,
                    horari: horari,
                    espai_id: idespai
                })
            });
            const data = await response.json();
            if (response.ok) {
                setConfirmationMessage('Visita afegida correctament.');
                setTitol('');
                setDescripcio('');
                setInscripcioPrevia('');
                setNPlaces('');
                setDataInici('');
                setDataFi('');
                setHorari('');
            } else {
                setError(data.message || 'Hi ha hagut un error en afegir la visita.');
            }
        } catch (error) {
            console.error('Error al afegir visita:', error);
            setError('Hi ha hagut un error en afegir la visita.');
        }
    };

    return (
        <Form>
            <Form.Group className="mb-3">
                <Form.Label>Títol:</Form.Label>
                <Form.Control
                    type="text"
                    placeholder="Títol de la visita"
                    value={titol}
                    onChange={(e) => setTitol(e.target.value)}
                />
            </Form.Group>
            <Form.Group className="mb-3">
                <Form.Label>Descripció:</Form.Label>
                <Form.Control
                    as="textarea"
                    rows={3}
                    placeholder="Descripció de la visita"
                    value={descripcio}
                    onChange={(e) => setDescripcio(e.target.value)}
                />
            </Form.Group>
            <Form.Group className="mb-3">
                <Form.Label>Inscripció Prèvia:</Form.Label>
                <Form.Select
                    value={inscripcioPrevia}
                    onChange={(e) => setInscripcioPrevia(e.target.value)}
                >
                    <option value="">Selecciona...</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </Form.Select>
            </Form.Group>
            <Form.Group className="mb-3">
                <Form.Label>Nombre de Places:</Form.Label>
                <Form.Control
                    type="number"
                    placeholder="Nombre de places"
                    value={nPlaces}
                    onChange={(e) => setNPlaces(e.target.value)}
                />
            </Form.Group>
            <Form.Group className="mb-3">
                <Form.Label>Data d'Inici:</Form.Label>
                <Form.Control
                    type="date"
                    value={dataInici}
                    onChange={(e) => setDataInici(e.target.value)}
                />
            </Form.Group>
            <Form.Group className="mb-3">
                <Form.Label>Data de Fi:</Form.Label>
                <Form.Control
                    type="date"
                    value={dataFi}
                    onChange={(e) => setDataFi(e.target.value)}
                />
            </Form.Group>
            <Form.Group className="mb-3">
                <Form.Label>Horari:</Form.Label>
                <Form.Control
                    type="text"
                    placeholder="Horari"
                    value={horari}
                    onChange={(e) => setHorari(e.target.value)}
                />
            </Form.Group>
            <Button variant="primary" onClick={handleAfegir}>
                Afegir
            </Button>
            <Button variant="danger" onClick={onCancel}>
                Cancel·lar
            </Button>
            <br />
            {confirmationMessage && (
                <div className="alert alert-success" role="alert">
                    <p>{confirmationMessage}</p>
                </div>
            )}
            {error && <Alert variant="danger">{error}</Alert>}
        </Form>
    );
}

export default FormulariAfegirVisites;
