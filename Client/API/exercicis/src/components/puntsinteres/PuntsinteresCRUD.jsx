import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";
import SelectEspais from "./SelectEspais";

export default function PuntsinteresCRUD(props) {
    const [puntInteres, setPuntInteres] = useState("");
    const [descripcio, setDescripcio] = useState("");
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    const [edita, setEdita] = useState(false);
    const navigate = useNavigate();
    const { id } = useParams();
    const token = props.api_token;
    const [espai_id, setEspai_id] = useState("");
    const [espai_actual, setEspai_actual] = useState("");

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
            const resposta = await fetch(`http://balearc.aurorakachau.com/public/api/punts_interes/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const jsonresposta = await resposta.json();
            setPuntInteres(jsonresposta.data.titol);
            setDescripcio(jsonresposta.data.descripcio);
            setEspai_id(jsonresposta.data.espai_id);

            const respostaEspais = await fetch(`http://balearc.aurorakachau.com/public/api/espais/${jsonresposta.data.espai_id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
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
                navigate('/puntsinteres');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al modificar el punt d'interès.");
        });
    }

    const esborraPuntInteres = () => {
         fetch(`http://balearc.aurorakachau.com/public/api/punts_interes/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => {
            if (response.error === 200) {
                setError("Error al esborrar el punt d'interès.");
                console.log(response.error);
            } else {
                navigate('/puntsinteres');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al esborrar el punt d'interès.");
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
                <Form.Group className="mb-3">
                    <Form.Label>Espai actual: <strong>{espai_actual}</strong></Form.Label>
                    <SelectEspais id={espai_id} onChange={(e) => { setEspai_id(e.target.value) }} />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaPuntInteres}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/puntsinteres")}>
                    Cancel·la
                </Button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {edita &&
                    <Button variant="danger" type="button" onClick={esborraPuntInteres}>
                        Esborra
                    </Button>
                }
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
