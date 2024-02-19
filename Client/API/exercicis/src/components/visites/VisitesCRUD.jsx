import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";
import SelectEspais from '../puntsinteres/SelectEspais'; 

export default function VisitesCRUD(props) {
    const [titol, setTitol] = useState("");
    const [descripcio, setDescripcio] = useState("");
    const [inscripcioPrevia, setInscripcioPrevia] = useState("");
    const [nPlaces, setNPlaces] = useState("");
    const [dataInici, setDataInici] = useState("");
    const [dataFi, setDataFi] = useState("");
    const [horari, setHorari] = useState("");
    const [espaiId, setEspaiId] = useState("");
    const [espai_actual, setEspai_actual] = useState("");
    const [nomEspaiactual, setnomEspaiactual] = useState("");
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    const [edita, setEdita] = useState(false);
    const navigate = useNavigate();
    const { id } = useParams();
    const token = props.api_token;

    useEffect(() => {
        if (id !== "-1") {
            descarregaVisita();
            EspaiActual();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarregaVisita = async () => {
        setLoading(true);
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/visites/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const jsonData = await response.json();
            const visita = jsonData.data;
            setTitol(visita.titol);
            setEspai_actual(visita.espai_id);
            setDescripcio(visita.descripcio);
            setInscripcioPrevia(visita.inscripcio_previa.toString());
            setNPlaces(visita.n_places.toString());
            setDataInici(visita.data_inici);
            setDataFi(visita.data_fi);
            setHorari(visita.horari);
            setEspaiId(visita.espai_id.toString());
            setEdita(true);
        } catch (error) {
            console.error(error);
            setError("Error en la descàrrega de la visita.");
        }
        setLoading(false);
    };

    const guardaVisita = () => {
        if (edita) {
            modificaVisita();
        } else {
            setEdita(false);
        }
    }

    const modificaVisita = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/visites/${id}`, {    
            method: 'PUT',
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
                espai_id: parseInt(espaiId)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError("Error al modificar la visita.");
            } else {
                navigate('/visites');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al modificar la visita.");
        });
    }

    const EspaiActual = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/espais/${id}`,{
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application',
                'Authorization': `Bearer ${token}`
            }
        })
        .then (response => response.json())
        .then (data => {
            setnomEspaiactual(data.data.nom);
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al modificar la visita.");
        });
    }

    if (loading) {
        return <Spinner animation="border" />;
    }
    return (
        <div>
            <hr />
            <h1>{edita ? "Editar" : "Afegir"} Visita</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Títol de la Visita</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Títol de la visita"
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
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </Form.Select>
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Nombre de Places</Form.Label>
                    <Form.Control
                        type="number"
                        placeholder="Nombre de places"
                        value={nPlaces}
                        onChange={(e) => setNPlaces(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Data d'Inici</Form.Label>
                    <Form.Control
                        type="date"
                        value={dataInici}
                        onChange={(e) => setDataInici(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Data de Fi</Form.Label>
                    <Form.Control
                        type="date"
                        value={dataFi}
                        onChange={(e) => setDataFi(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Horari</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Horari"
                        value={horari}
                        onChange={(e) => setHorari(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Espai actual: <strong>{nomEspaiactual}</strong> </Form.Label>
                    <SelectEspais id={espaiId} onChange={(e) => { setEspaiId(e.target.value) }} />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaVisita}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/visites")}>
                    Cancel·la
                </Button>
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
