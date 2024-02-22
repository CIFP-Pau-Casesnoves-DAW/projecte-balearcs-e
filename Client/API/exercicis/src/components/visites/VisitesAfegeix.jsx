import React, { useState } from 'react';
import { Form, Button, Alert } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import SelectEspais from '../puntsinteres/SelectEspais'; 

export default function VisitesAfegeix(props) {
    const [titol, setTitol] = useState('');
    const [descripcio, setDescripcio] = useState('');
    const [inscripcioPrevia, setInscripcioPrevia] = useState('');
    const [nPlaces, setNPlaces] = useState('');
    const [dataInici, setDataInici] = useState('');
    const [dataFi, setDataFi] = useState('');
    const [horari, setHorari] = useState('');
    const [espai_id, setEspai_id] = useState("");
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const token = props.api_token;

    const guardaVisita = () => {
        if (
            titol.trim() === '' || descripcio.trim() === '' || inscripcioPrevia.trim() === '' ||
            nPlaces.trim() === '' || dataInici.trim() === '' || dataFi.trim() === '' || horari.trim() === '' ||
            espai_id.trim() === ''
        ) {
            setError('Tots els camps són obligatoris.');
            return;
        }

        fetch('http://balearc.aurorakachau.com/public/api/visites', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                titol: titol,
                descripcio: descripcio,
                inscripcio_previa: inscripcioPrevia,
                n_places: nPlaces,
                data_inici: dataInici,
                data_fi: dataFi,
                horari: horari,
                espai_id: espai_id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError('Error en guardar la visita.');
            } else {
                setError('');
                navigate('/visites');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError('Error en guardar la visita.');
        });
    };

    return (
        <div>
            <hr />
            <h1>Afegir Visita</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Títol de la Visita</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Títol de la visita"
                        name="titol"
                        value={titol}
                        onChange={(e) => setTitol(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Descripció de la Visita</Form.Label>
                    <Form.Control
                        as="textarea"
                        rows={3}
                        placeholder="Descripció de la visita"
                        name="descripcio"
                        value={descripcio}
                        onChange={(e) => setDescripcio(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Inscripció Prèvia</Form.Label>
                    <Form.Select
                        value={inscripcioPrevia}
                        onChange={(e) => setInscripcioPrevia(e.target.value)}
                    >
                        <option value="">Selecciona una opció</option>
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </Form.Select>
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Nombre de Places</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nombre de places"
                        name="nPlaces"
                        value={nPlaces}
                        onChange={(e) => setNPlaces(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Data d'Inici</Form.Label>
                    <Form.Control
                        type="date"
                        name="dataInici"
                        value={dataInici}
                        onChange={(e) => setDataInici(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Data de Fi</Form.Label>
                    <Form.Control
                        type="date"
                        name="dataFi"
                        value={dataFi}
                        onChange={(e) => setDataFi(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Horari</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Horari"
                        name="horari"
                        value={horari}
                        onChange={(e) => setHorari(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Espai:</Form.Label>
                    <SelectEspais id={espai_id} onChange={(e) => { setEspai_id(e.target.value) }} />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaVisita}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate('/visites')}>
                    Cancel·la
                </Button>
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
