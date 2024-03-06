import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner, Row, Col } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";
import FotosGestors from "./FotosGestors";
import FormulariAfegirFotos from "./FormulariAfegirFotos";
import FormulariAfegirAudios from "./FormulariAfegirAudios";
import AudiosGestors from "./AudiosGestors";

export default function PuntsInteresGestorsCRUD(props) {
    const [puntInteres, setPuntInteres] = useState("");
    const [descripcio, setDescripcio] = useState("");
    const [puntId, setPuntId] = useState("");
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    const [edita, setEdita] = useState(false);
    const navigate = useNavigate();
    const { id } = useParams();
    const token = props.api_token;
    const [espai_id, setEspai_id] = useState("");
    const [espai_actual, setEspai_actual] = useState("");
    const [mostraFormulari, setMostraFormulari] = useState(false)
    const [mostraFormulariAudios, setMostraFormulariAudios] = useState(false);

    useEffect(() => {
        if (id !== "-1") {
            descarregaPuntInteres();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarregaPuntInteres = async () => {
        setLoading(true);
        try {
            const resposta = await fetch(`http://balearc.aurorakachau.com/public/api/punts_interes/${id}`,{
                method: 'GET',
                headers: {
                    'Content-Type': 'application',
                    'Authorization': `Bearer ${token}`
                }
            });
            const jsonresposta = await resposta.json();
            setPuntId(jsonresposta.data.id); 
            setPuntInteres(jsonresposta.data.titol);
            setDescripcio(jsonresposta.data.descripcio);
            setEspai_id(jsonresposta.data.espai_id);

            const respostaEspais = await fetch(`http://balearc.aurorakachau.com/public/api/espais/${jsonresposta.data.espai_id}`,{
                method: 'GET',
                headers: {
                    'Content-Type': 'application',
                    'Authorization': `Bearer ${token}`
                }
            });
            const jsonrespostaEspais = await respostaEspais.json();
            setEspai_actual(jsonrespostaEspais.data.nom);
            setEdita(true);
        } catch (error) {
            console.error(error);
            setError("Error en la descàrrega del punt d'interès.");
        }
        setLoading(false);
    };

    const guardaPuntInteres = () => {
        if(espai_id === "-1"){
            setError("No has seleccionat un espai.");
            return;
        }

        if (edita) {
            modificaPuntInteres();
        } 
    }

    const modificaPuntInteres = () => {
         fetch(`http://balearc.aurorakachau.com/public/api/punts_interes/${id}`, {    
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                titol: puntInteres,
                descripcio: descripcio,
                espai_id: espai_id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError("Error al modificar el punt d'interès.");
            } else {
                navigate(`/espaisgestors/${espai_id}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al modificar el punt d'interès.");
        });
    }

    if (loading) {
        return <Spinner animation="border" />;
    }
    return (
        <div>
            <hr />
            <h1>{edita ? "Editar" : "Afegir"} Punt d'Interès</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Nom del Punt d'Interès</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom del Punt d'Interès"
                        name="puntInteres"
                        value={puntInteres}
                        onChange={(e) => setPuntInteres(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Descripció del Punt d'Interès</Form.Label>
                    <Form.Control
                        as="textarea"
                        rows={3}
                        placeholder="Descripció del Punt d'Interès"
                        name="descripcio"
                        value={descripcio}
                        onChange={(e) => setDescripcio(e.target.value)}
                    />
                </Form.Group>
                <hr />
                <Row md={9}>
                <Col>
                    <h2>Llista de fotos</h2>
                </Col>
                <Col style={{textAlign:"right"}}>
                    <Button
                        variant="success"
                        type="button"
                        onClick={() => {
                            setMostraFormulari(true)
                        }}
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-fill-add" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1"/>
                            <path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12 12 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7m6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.55 4.55 0 0 1 .23-2.002m-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-1.3-1.905"/>
                        </svg> Afegir fotos
                    </Button>
                </Col>
                </Row>

                {mostraFormulari && (
                    <FormulariAfegirFotos
                        api_token={token}
                        punt_interes_id={puntId}
                        espai_id={espai_id}
                        onCancel={() => setMostraFormulari(false)}
                    />
                )}
                <hr />
                <FotosGestors idpunt={puntId} idespai={espai_id} api_token={token}/>
                <hr />
                    
                <Row md={9}>
                <Col>
                    <h2>Llista d'audios</h2>
                </Col>
                <Col style={{textAlign:"right"}}>
                    <Button
                        variant="success"
                        type="button"
                        onClick={() => {
                            setMostraFormulariAudios(true)
                        }}
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-fill-add" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1"/>
                            <path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12 12 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7m6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.55 4.55 0 0 1 .23-2.002m-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-1.3-1.905"/>
                        </svg> Afegir audios
                    </Button>
                </Col>
                </Row>

                {mostraFormulariAudios && (
                    <FormulariAfegirAudios
                        api_token={token}
                        punt_interes_id={puntId}
                        espai_id={espai_id}
                        onCancel={() => setMostraFormulariAudios(false)}
                    />
                )}    
                <hr />
                <AudiosGestors idpunt={puntId} idespai={espai_id} api_token={token}/>
                <hr />   

                <Button variant="primary" type="button" onClick={guardaPuntInteres}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate(`/espaisgestors/${espai_id}`)}>
                    Cancel·la
                </Button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
