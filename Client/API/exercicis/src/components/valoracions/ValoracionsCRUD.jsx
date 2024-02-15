import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";
import { storage } from '../../utils/storage';
import SelectEspais from "../comentaris/SelectEspais";
import SelectUsuaris from "./SelectUsuaris";

export default function ValoracionsCRUD(props) {
    const [puntuacio, setPuntuacio] = useState("");
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    const [edita, setEdita] = useState(false);
    const navigate = useNavigate();
    const { id } = useParams();
    const token = props.api_token;
    const [usuari_id, setUsuari_id] = useState("");
    const [espai_id, setEspai_id] = useState("");
    const [espai_actual, setEspai_actual] = useState("");
    const [usuari_actual, setUsuari_actual] = useState("");

    useEffect(() => {
        if (id !== "-1") {
            descarregaValoracio();
        } else {
            setEdita(false);
        }
    }, [id, token]); // Añade token a las dependencias

    const descarregaValoracio = async () => {
        setLoading(true);
        try {
            const resposta = await fetch(`http://balearc.aurorakachau.com/public/api/valoracions/${id}`, {
                headers: {
                    'Authorization': `Bearer ${token}` // Incluye el token en los encabezados
                }
            });
            const jsonresposta = await resposta.json();
            setPuntuacio(jsonresposta.data.puntuacio);
            setUsuari_id(jsonresposta.data.usuari_id);
            setEspai_id(jsonresposta.data.espai_id);

            // Obtener el nombre del usuario actual
            const respostaUsuari = await fetch(`http://balearc.aurorakachau.com/public/api/usuaris/${jsonresposta.data.usuari_id}`, {
                headers: {
                    'Authorization': `Bearer ${token}` // Incluye el token en los encabezados
                }
            });
            const jsonrespostaUsuari = await respostaUsuari.json();
            setUsuari_actual(jsonrespostaUsuari.data.nom);

            const respostaEspais = await fetch(`http://balearc.aurorakachau.com/public/api/espais/${jsonresposta.data.espai_id}`, {
                headers: {
                    'Authorization': `Bearer ${token}` // Incluye el token en los encabezados
                }
            });
            const jsonrespostaEspais = await respostaEspais.json();
            setEspai_actual(jsonrespostaEspais.data.nom);
            setEdita(true);
        } catch (error) {
            console.error(error);
            setError("Error en la descàrrega de la valoració.");
        }
        setLoading(false);
    };

    const guardaValoracio = () => {
        const puntuacioString = String(puntuacio); // Convertir a cadena de texto
        if (puntuacioString.trim() === '' || espai_id.trim() === '' || espai_id === "-1" || usuari_id.trim() === '' || usuari_id === "-1") {
            setError("Tots els camps són obligatoris.");
            return;
        }
    
        if (edita) {
            modificaValoracio();
        } else {
            creaValoracio();
        }
    }

    const creaValoracio = () => {
        fetch('http://balearc.aurorakachau.com/public/api/valoracions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                puntuacio: puntuacio,
                usuari_id: usuari_id,
                espai_id: espai_id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError("Error al guardar la valoració."); 
            } else {
                navigate('/valoracions');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al guardar la valoració.");
        });
    }

    const modificaValoracio = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/valoracions/${id}`, {    
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                puntuacio: puntuacio,
                usuari_id: usuari_id,
                espai_id: espai_id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError("Error al modificar la valoració.");
            } else {
                navigate('/valoracions');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al modificar la valoració.");
        });
    }

    if (loading) {
        return <Spinner animation="border" />;
    }

    return (
        <div>
            <hr />
            <h1>{edita ? "Editar" : "Crear"} Valoració</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Puntuació</Form.Label>
                    <Form.Control
                        type="number"
                        placeholder="Puntuació"
                        name="puntuacio"
                        value={puntuacio}
                        onChange={(e) => setPuntuacio(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Espai actual: <strong>{espai_actual}</strong></Form.Label>
                    <SelectEspais id={espai_id} onChange={(e) => { setEspai_id(e.target.value) }} />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Usuari actual: <strong>{usuari_actual}</strong></Form.Label>
                    <SelectUsuaris id={usuari_id} api_token={token} onChange={(e) => { setUsuari_id(e.target.value) }} />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaValoracio}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/valoracions")}>
                    Cancel·la
                </Button>
            </Form>
            <br/>
            {error!=='' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
