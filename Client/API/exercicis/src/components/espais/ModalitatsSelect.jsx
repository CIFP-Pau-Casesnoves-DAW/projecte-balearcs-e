import React, { useEffect, useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { useParams } from 'react-router-dom';
import { Form, Button, Alert } from 'react-bootstrap';

export default function ModalitatsSelect({ api_token, codiespai, onCancel}) {
    const [modalitats, setModalitats] = useState([]);
    const [selectedModalitat, setSelectedModalitat] = useState('');
    const [confirmationMessage, setConfirmationMessage] = useState('');
    const [error, setError] = useState('');
    const { id } = useParams();

    useEffect(() => {
        if (id !== "-1") {
            getModalitats();
        } else {
            setError("No s'ha pogut carregar la llista de modalitats.");
        }
    }, [id]);

    const getModalitats = () => {
        fetch('http://balearc.aurorakachau.com/public/api/modalitats', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${api_token}`
            },
        })
            .then(response => response.json())
            .then(data => {
                setModalitats(data.data);
            })
            .catch(error => {
                console.error('Error:', error);
                setError("No s'ha pogut carregar la llista de modalitats.");
            });
    }

    const handleAfegir = () => {
        if (!selectedModalitat) {
            setError("Selecciona una modalitat abans d'afegir.");
            return;
        }

        fetch('http://balearc.aurorakachau.com/public/api/espais_modalitats', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${api_token}`
            },
            body: JSON.stringify({
                espai_id: codiespai,
                modalitat_id: parseInt(selectedModalitat)
            })
        })
            .then(response => {
                if (response.ok) {
                    setConfirmationMessage("Modalitat afegida amb èxit a l\'espai.");
                } else {
                    throw new Error('Error en afegir la modalitat a l\'espai.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError(error.message);
            });
    }

    return (
        <>
        <hr />
            <Form>
                <Form.Group>
                    <Form.Label>Afegir modalitat</Form.Label>
                    <Form.Control
                        as="select"
                        value={selectedModalitat}
                        onChange={(e) => setSelectedModalitat(e.target.value)}
                    >
                        <option value="">Selecciona una modalitat</option>
                        {modalitats && modalitats.map((modalitat) => (
                            <option key={modalitat.id} value={modalitat.id}>
                                {modalitat.nom_modalitat}
                            </option>
                        ))}
                    </Form.Control>
                </Form.Group>
                <br />
                <Button variant="primary" onClick={handleAfegir}>
                    Afegir
                </Button>
                &nbsp;&nbsp;
                <Button variant="danger" onClick={onCancel}>
                    Cancel·lar
                </Button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </Form>
            {confirmationMessage && (
                    <div className="alert alert-success" role="alert">
                        <p>{confirmationMessage}</p>
                    </div>
                )}
            {error && <Alert variant="danger">{error}</Alert>}
        </>
    );
}
