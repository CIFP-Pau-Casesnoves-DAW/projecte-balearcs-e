import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Form, Button, Card, Alert, CardSubtitle } from 'react-bootstrap';
import { storage } from '../utils/storage'; // Assegura't que aquesta línia és correcta

const ValoracionsComentaris = () => {
    const [espais, setEspais] = useState([]);
    const [selectedEspai, setSelectedEspai] = useState('');
    const [comentari, setComentari] = useState('');
    const [valoracio, setValoracio] = useState('');
    const [missatge, setMissatge] = useState({ text: '', tipus: '' });
    const [usuariNom, setUsuariNom] = useState('');
    const [usuariRol, setUsuariRol] = useState('');

    const usuari_id = storage.get('usuari_id'); // Obtenir usuari_id des de storage
    const api_token = storage.get('api_token'); // Obtenir api_token des de storage

    useEffect(() => {
        const fetchEspais = async () => {
            try {
                const response = await axios.get('http://balearc.aurorakachau.com/public/api/espais', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${api_token}`
                    }
                });
                setEspais(response.data.data);
            } catch (error) {
                console.error('Error al obtenir els espais', error);
            }
        };

        fetchEspais();
    }, [api_token]);

    useEffect(() => {
        if (usuari_id && api_token) {
            const fetchDadesUsuari = async () => {
                try {
                    const response = await axios.get(`http://balearc.aurorakachau.com/public/api/usuaris/${usuari_id}`, {
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${api_token}`
                        }
                    });
                    setUsuariNom(response.data.nom);
                    setUsuariRol(response.data.rol); // Asumim que la resposta inclou 'rol'
                } catch (error) {
                    console.error('Error al obtenir les dades de l\'usuari', error);
                }
            };
    
            fetchDadesUsuari();
        }
    }, [api_token, usuari_id]);

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const headersConfig = {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${api_token}`
                }
            };
            
            if (comentari.trim() !== '') {
                await axios.post('http://balearc.aurorakachau.com/public/api/comentaris', {
                    espai_id: selectedEspai,
                    comentari
                }, headersConfig);
            }

            if (valoracio.trim() !== '') {
                await axios.post('http://balearc.aurorakachau.com/public/api/valoracions', {
                    espai_id: selectedEspai,
                    puntuacio: valoracio
                }, headersConfig);
            }

            setMissatge({ text: 'Comentari i valoració enviats correctament.', tipus: 'success' });
            setSelectedEspai('');
            setComentari('');
            setValoracio('');
        } catch (error) {
            setMissatge({ text: 'Error al enviar el comentari i la valoració.', tipus: 'danger' });
            console.error('Error al enviar el comentari i la valoració', error);
        }
    };

    return (
        <div>
             <Card style={{ width: '60%', marginTop: '20px', margin: 'auto', textAlign: 'center', backgroundColor: '#f5f5f5', color: 'black', borderRadius: '20px' }}>
                <Card.Body>
                    <Card.Title>Valoracions & Comentaris</Card.Title>
                    <br />
                    {missatge.text && <Alert variant={missatge.tipus}>{missatge.text}</Alert>}
                    <Form onSubmit={handleSubmit}>
                        <Form.Group controlId="formEspaiSelect">
                            <Form.Control as="select" value={selectedEspai} onChange={e => setSelectedEspai(e.target.value)}>
                                <option value="">Selecciona l'espai a valorar i comentar</option>
                                {espais.map(espai => (
                                    <option key={espai.id} value={espai.id}>{espai.nom}</option>
                                ))}
                            </Form.Control>
                            <br />
                        </Form.Group>
                        <Form.Group controlId="formComentari">
                            <Form.Label>Comentari</Form.Label>
                            <Form.Control as="textarea" rows={3} value={comentari} onChange={e => setComentari(e.target.value)} placeholder="Escriu aquí el teu comentari... " />
                        </Form.Group>
                        <br />
                        <Form.Group controlId="formValoracio">
                            <Form.Label>Valoració (0-10)</Form.Label>
                            <Form.Control type="number" min="0" max="10" value={valoracio} onChange={e => setValoracio(e.target.value)} />
                        </Form.Group>
                        <br />
                        <Button variant="primary" type="submit">Enviar</Button>
                    </Form>
                </Card.Body>
            </Card>
        </div>
    );
};

export default ValoracionsComentaris;

