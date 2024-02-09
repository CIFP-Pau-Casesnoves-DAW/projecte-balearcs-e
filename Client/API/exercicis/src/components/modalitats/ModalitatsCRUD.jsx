import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";

export default function ModalitatsCRUD(props) {
    const [modalitat, setModalitat] = useState("");
    const [error, setError] = useState('');
    const [edita, setEdita] = useState(false);
    const [descarregant, setDescarregant] = useState(false);
    const { id } = useParams();
    const navigate = useNavigate();
    const token = props.api_token;

    useEffect(() => {
        if (id !== "-1") {
            descarregaModalitat();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarregaModalitat = async () => {
        setDescarregant(true);
        setEdita(true);
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/modalitats/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            setModalitat(responseData.data.nom_modalitat);
        } catch (error) {
            console.log(error);
        }
        setDescarregant(false);
    }

    const guardaModalitat = () => {
        if (edita) {
            modificaModalitat();
        } else {
            creaModalitat();
        }
    }

    const creaModalitat = () => {
        fetch('http://balearc.aurorakachau.com/public/api/modalitats', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom_modalitat: modalitat
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                    setError("Error al crear la modalitat.");
                } else {
                    setError('');
                    navigate('/modalitats');
                }
            })
    }

    const modificaModalitat = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/modalitats/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom_modalitat: modalitat
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                    setError("Error al modificar la modalitat.");
                } else {
                    setError('');
                    navigate('/modalitats');
                }
            })
    }

    const esborraModalitat = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/modalitats/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        }).then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error al eliminar la modalitat.");
                } else {
                    navigate('/modalitats');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error al eliminar la modalitat.");
            });
    }

    if (descarregant) {
        return <Spinner />
    }

    return (
        <div>
            <Form>
                {edita &&
                    <Form.Group className="mb-3">
                        <Form.Label>Id</Form.Label>
                        <Form.Control type="text" name="id" value={id} disabled />
                    </Form.Group>
                }
                <Form.Group className="mb-3">
                    <Form.Label>Nom de la Modalitat</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom de la modalitat"
                        value={modalitat}
                        onChange={(e) => setModalitat(e.target.value)}
                    />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaModalitat}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/modalitats")}>
                    Cancel·la
                </Button>
                {edita &&
                    <Button variant="danger" type="button" onClick={esborraModalitat}>
                        Esborra
                    </Button>
                }
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
