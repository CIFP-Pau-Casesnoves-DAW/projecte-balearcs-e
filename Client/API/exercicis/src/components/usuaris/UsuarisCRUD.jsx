import React, { useState, useEffect } from "react";
import { Form, Button, Alert, Spinner } from "react-bootstrap";
import { useNavigate, useParams } from "react-router-dom";

export default function UsuarisCRUD(props) {
    const [nomUsuari, setNomUsuari] = useState("");
    const [llinatgesUsuari, setLlinatgesUsuari] = useState("");
    const [dniUsuari, setDniUsuari] = useState("");
    const [mailUsuari, setMailUsuari] = useState("");
    const [contrasenyaUsuari, setContrasenyaUsuari] = useState("");
    const [rolUsuari, setRolUsuari] = useState("usuari");
    const [validat, setValidat] = useState('');
    const [error, setError] = useState('');
    const [edita, setEdita] = useState(false);
    const [descarregant, setDescarregant] = useState(false);
    const { id } = useParams();
    const navigate = useNavigate();
    const token = props.api_token;

    useEffect(() => {
        if (id !== "-1") {
            descarregaUsuari();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarregaUsuari = async () => {
        setDescarregant(true);
        setEdita(true);
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/usuaris/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            const { nom, llinatges, dni, mail, rol, actiu } = responseData.data;
            setNomUsuari(nom);
            setLlinatgesUsuari(llinatges);
            setDniUsuari(dni);
            setMailUsuari(mail);
            setRolUsuari(rol);
            setValidat(actiu);
        } catch (error) {
            console.log(error);
        }
        setDescarregant(false);
    }

    const guardaUsuari = () => {
        if (edita) {
            modificaUsuari();
        } else {
            creaUsuari();
        }
    }

    const creaUsuari = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/usuaris`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom: nomUsuari,
                llinatges: llinatgesUsuari,
                dni: dniUsuari,
                mail: mailUsuari,
                contrasenya: contrasenyaUsuari,
                rol: rolUsuari,
                actiu: validat
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                    setError("Error en crear l'usuari.");
                } else {
                    setError('');
                    navigate('/usuaris');
                }
            })
    }

    const modificaUsuari = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/usuaris/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom: nomUsuari,
                llinatges: llinatgesUsuari,
                dni: dniUsuari,
                mail: mailUsuari,
                rol: rolUsuari,
                actiu: validat
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                    setError("Error al modificar l'usuari.");
                } else {
                    setError('');
                    navigate('/usuaris');
                }
            })
    }

    const esborraUsuari = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/usuaris/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        }).then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error en esborrar l'usuari.");
                } else {
                    navigate('/usuaris');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error en esborrar l'usuari.");
            });
    }

    if (descarregant) {
        return <Spinner />
    }

    return (
        <div>
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Nom de l'Usuari</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom de l'usuari"
                        value={nomUsuari}
                        onChange={(e) => setNomUsuari(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Llinatges de l'Usuari</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Llinatges de l'usuari"
                        value={llinatgesUsuari}
                        onChange={(e) => setLlinatgesUsuari(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>DNI de l'Usuari</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="DNI de l'usuari"
                        value={dniUsuari}
                        onChange={(e) => setDniUsuari(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Email de l'Usuari</Form.Label>
                    <Form.Control
                        type="email"
                        placeholder="Email de l'usuari"
                        value={mailUsuari}
                        onChange={(e) => setMailUsuari(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Contrasenya de l'Usuari</Form.Label>
                    <Form.Control
                        type="password"
                        placeholder="Contrasenya de l'usuari"
                        value={contrasenyaUsuari}
                        onChange={(e) => setContrasenyaUsuari(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Rol de l'Usuari</Form.Label>
                    <Form.Select
                        value={rolUsuari}
                        onChange={(e) => setRolUsuari(e.target.value)}
                    >
                        <option value="usuari">Usuari</option>
                        <option value="gestor">Gestor</option>
                        <option value="administrador">Administrador</option>
                    </Form.Select>
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Actiu</Form.Label>
                    <Form.Select
                        value={validat}
                        onChange={(e) => setValidat(parseInt(e.target.value))}
                    >
                        <option value={1}>Sí</option>
                        <option value={0}>No</option>
                    </Form.Select>
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaUsuari}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                <Button variant="warning" type="button" onClick={() => navigate("/usuaris")}>
                    Cancel·la
                </Button>
                {edita &&
                    <Button variant="danger" type="button" onClick={esborraUsuari}>
                        Esborra
                    </Button>
                }
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
}
