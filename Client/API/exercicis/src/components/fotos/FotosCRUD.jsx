import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";
import {SelectEspais, SelectPuntsInteres} from "./SelectEspaisPunts";

export default function FotosCRUD(props) {
    const [foto, setFoto] = useState("");
    const [puntInteresId, setPuntInteresId] = useState("");
    const [espaiId, setEspaiId] = useState("");
    const [comentari, setComentari] = useState("");
    const [espai_actual, setEspai_actual] = useState("");
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    const [edita, setEdita] = useState(false);
    const navigate = useNavigate();
    const { id } = useParams();
    const token = props.api_token;

    useEffect(() => {
        if (id !== "-1") {
            descarregaFoto();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarregaFoto = async () => {
        setLoading(true);
        setEdita(true);
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/fotos/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            const data = responseData.data;
            setFoto(data.foto);
            setPuntInteresId(data.punt_interes_id);
            setEspaiId(data.espai_id);
            setComentari(data.comentari);
        } catch (error) {
            console.log(error);
        }
        setLoading(false);
    }

    const guardaFoto = () => {
        if(espaiId === "-1"){
            setError("No has seleccionat un espai.");
            return;
        }

        if (edita) {
            modificaFoto();
        } else {
            setError('Error en l\'edició');
        }
    }

    const modificaFoto = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/fotos/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                punt_interes_id: puntInteresId,
                espai_id: espaiId,
                comentari: comentari
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                    setError("Error al modificar la foto.");
                } else {
                    setError('');
                    navigate('/fotos'); // Redirecció després d'èxit
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error en modificar la foto.");
            });
    }
    

    const esborraFoto = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/fotos/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        }).then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error en esborrar la foto.");
                } else {
                    navigate('/fotos');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error en esborrar la foto.");
            });
    }

    if (loading) {
        return <Spinner animation="border" />;
    }

    return (
        <div>
            <Form>
                {edita &&
                    <Form.Group className="mb-3">
                        <Form.Label>Id: </Form.Label>
                        <Form.Control type="text" name="id" value={id} disabled />
                    </Form.Group>
                }
                <Form.Group className="mb-3">
                    <Form.Label>Foto:</Form.Label>
                    <hr />
                    {foto && (
                        <img src={`http://balearc.aurorakachau.com/public/storage/${foto}`} alt="Vista prèvia de la foto" style={{ maxWidth: '300px' }} />
                    )}
                    <hr />
                    <Form.Label>Url:</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="URL de la foto"
                        value={foto} disabled
                        onChange={(e) => setFoto(e.target.value)}
                    />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Espai actual: <strong>{espaiId}</strong></Form.Label>
                    <SelectEspais id={espaiId} api_token={token} onChange={(e) => { setEspaiId(e.target.value) }} />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Comentari:</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Comentari"
                        value={comentari}
                        onChange={(e) => setComentari(e.target.value)}
                    />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaFoto}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/fotos")}>
                    Cancel·la
                </Button>
                &nbsp;&nbsp;
                {edita &&
                    <Button variant="danger" type="button" onClick={esborraFoto}>
                        Esborra
                    </Button>
                }
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
