import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";

export default function IdiomesCRUD(props) {
    const [idioma, setIdioma] = useState("");
    const [error, setError] = useState('');
    const [edita, setEdita] = useState(false);
    const [descarregant, setDescarregant] = useState(false);
    const { id } = useParams();
    const navigate = useNavigate();
    const token = props.api_token;

    useEffect(() => {
        if (id !== "-1") {
            descarregaIdioma();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarregaIdioma = async () => {
        setDescarregant(true);
        setEdita(true);
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/idiomes/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            setIdioma(responseData.data.idioma);
        } catch (error) {
            console.log(error);
        }
        setDescarregant(false);
    }

    const guardaIdioma = () => {
        if (edita) {
            modificaIdioma();
        } else {
            setError('Error en la edició');
        }
    }

    const modificaIdioma = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/idiomes/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                idioma: idioma
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                    setError("Error al modificar l'idioma.");
                } else {
                    setError('');
                    navigate('/idiomes');
                }
            })
    }

    const esborraIdioma = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/idiomes/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        }).then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error al eliminar l'idioma.");
                } else {
                    navigate('/idiomes');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error al eliminar l'idioma.");
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
                    <Form.Label>Nom de l'Idioma</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom de l'idioma"
                        value={idioma}
                        onChange={(e) => setIdioma(e.target.value)}
                    />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaIdioma}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/idiomes")}>
                    Cancel·la
                </Button>
                {edita &&
                    <Button variant="danger" type="button" onClick={esborraIdioma}>
                        Esborra
                    </Button>
                }
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
