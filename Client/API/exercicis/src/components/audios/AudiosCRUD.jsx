import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";
import { SelectEspais } from "./SelectEspais";
import { SelectPuntsInteres } from "./SelectPunts";

export default function AudiosCRUD(props) {
    const [audioFile, setAudioFile] = useState("");
    const [puntInteresId, setPuntInteresId] = useState("");
    const [espaiId, setEspaiId] = useState("");
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    const [edita, setEdita] = useState(false);
    const navigate = useNavigate();
    const { id } = useParams();
    const token = props.api_token;

    useEffect(() => {
        if (id !== "-1") {
            descarregaAudio();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarregaAudio = async () => {
        setLoading(true);
        setEdita(true);
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/audios/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            const data = responseData.data;
            setAudioFile(data.audio);
            setPuntInteresId(data.punt_interes_id);
            setEspaiId(data.espai_id);
        } catch (error) {
            console.log(error);
        }
        setLoading(false);
    }

    const handleFileChange = (event) => {
        setAudioFile(event.target.files[0]);
    }

    const guardaAudio = () => {
        if (!audioFile || espaiId === "-1") {
            setError("Tots els camps són obligatoris.");
            return;
        }

        if (edita) {
            modificaAudio();
        } else {
            creaAudio();
        }
    }

    const creaAudio = () => {
        const formData = new FormData();
        formData.append('audio', audioFile);
        formData.append('punt_interes_id', puntInteresId);
        formData.append('espai_id', espaiId);

        fetch('http://balearc.aurorakachau.com/public/api/audios', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                setError('');
                navigate('/audios');
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error en crear el audio.");
            });
    }

    const modificaAudio = () => {
        const formData = new FormData();
        formData.append('audio', audioFile);
        formData.append('punt_interes_id', puntInteresId);
        formData.append('espai_id', espaiId);

        fetch(`http://balearc.aurorakachau.com/public/api/audios/${id}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${token}`
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                setError('');
                navigate('/audios');
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error en modificar el audio.");
            });
    }

    const esborraAudio = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/audios/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                setError('');
                navigate('/audios');
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error en esborrar el audio.");
            });
    }

    if (loading) {
        return <Spinner animation="border" />;
    }

    return (
        <div>
            <Form>
                {edita && (
                    <Form.Group className="mb-3">
                        <Form.Label>Id: </Form.Label>
                        <Form.Control type="text" name="id" value={id} disabled />
                    </Form.Group>
                )}
                <Form.Group className="mb-3">
                    <Form.Label>Audio:</Form.Label>
                    <hr />
                    <audio controls>
                        <source src={`http://balearc.aurorakachau.com/public/storage/${audioFile}`} type="audio/mpeg" />
                        Your browser does not support the audio element.
                    </audio>
                    <hr />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Espai actual: <strong>{espaiId}</strong></Form.Label>
                    <SelectEspais id={espaiId} api_token={token} onChange={(value) => { setEspaiId(value) }} />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Punt d'Interés actual: <strong>{puntInteresId}</strong></Form.Label>
                    <SelectPuntsInteres idEspai={espaiId} api_token={token} onChange={(value) => { setPuntInteresId(value) }} />
                </Form.Group>

                <Button variant="primary" type="button" onClick={guardaAudio}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/fotos")}>
                    Cancel·la
                </Button>
                &nbsp;&nbsp;
                {edita && (
                    <Button variant="danger" type="button" onClick={esborraAudio}>
                        Esborra
                    </Button>
                )}
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
