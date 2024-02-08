import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";
import { storage } from '../../utils/storage';
import SelectEspais from "./SelectEspais";

export default function ComentarisCRUD() {
    const [comentari, setComentari] = useState("");
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    const [edita, setEdita] = useState(false);
    const navigate = useNavigate();
    const { id } = useParams();
    const token = storage.get('api_token'); 
    const [espai_id, setEspai_id] = useState("");
    const [espai_actual, setEspai_actual] = useState("");

    useEffect(() => {
        if (id !== "-1") {
            descarregaComentari();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarregaComentari = async () => {
        setLoading(true);
        try {
            const resposta = await fetch(`http://balearc.aurorakachau.com/public/api/comentaris/${id}`);
            const jsonresposta = await resposta.json();
            setComentari(jsonresposta.data.comentari);
            setEspai_id(jsonresposta.data.espai_id);

            const respostaEspais = await fetch(`http://balearc.aurorakachau.com/public/api/espais/${jsonresposta.data.espai_id}`);
            const jsonrespostaEspais = await respostaEspais.json();
            setEspai_actual(jsonrespostaEspais.data.nom);
            setEdita(true);
        } catch (error) {
            console.error(error);
            setError("Error en la descàrrega del comentari.");
        }
        setLoading(false);
    };

    const guardaComentari = () => {
        if(espai_id === "-1"){
            setError("No has seleccionat un espai.");
            return;
        }

        if (edita) {
            modificaComentari();
        } else {
            creaComentari();
        }
    }

    const creaComentari = () => {
         fetch('http://balearc.aurorakachau.com/public/api/comentaris', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                comentari: comentari,
                espai_id: espai_id,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError("Error al crear el comentari."); 
            } else {
                navigate('/comentaris');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al crear el comentari.");
        });
    }

    const modificaComentari = () => {
         fetch(`http://balearc.aurorakachau.com/public/api/comentaris/${id}`, {    
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                comentari: comentari,
                espai_id: espai_id,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError("Error al modificar el comentari.");
            } else {
                navigate('/comentaris');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al modificar el comentari.");
        });
    }

    const esborraComentari = () => {
         fetch(`http://balearc.aurorakachau.com/public/api/comentaris/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => {
            if (response.error === 200) {
                setError("Error al esborrar el comentari.");
                console.log(response.error);
            } else {
                navigate('/comentaris');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al esborrar el comentari.");
        });
    }

    if (loading) {
        return <Spinner animation="border" />;
    }
    return (
        <div>
            <hr />
            <h1>Editar Comentari</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Comentari</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Comentari"
                        name="comentari"
                        value={comentari}
                        onChange={(e) => setComentari(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Espai actual: <strong>{espai_actual}</strong></Form.Label>
                    <SelectEspais id={espai_id} onChange={(e) => { setEspai_id(e.target.value) }} />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaComentari}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/comentaris")}>
                    Cancel·la
                </Button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {edita &&
                    <Button variant="danger" type="button" onClick={esborraComentari}>
                        Esborra
                    </Button>
                }
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}