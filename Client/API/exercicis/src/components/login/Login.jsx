import React, { useState } from 'react';
import { Alert, Spinner, Form, Button } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';

export default function Login(props) {
    const [mail, setMail] = useState('pepepepito@gmail.com');   // Usuari admin de la API
    const [contrasenya, setContrasenya] = useState('PepePepito123');
    const [error, setError] = useState(false);
    const [loading, setLoading] = useState(false);
    const navigate = useNavigate();

    const ferLogin = () => {
        let data = { mail: mail, contrasenya: contrasenya };
        setLoading(true);
        fetch('http://balearc.aurorakachau.com/public/api/login', {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la petició');
            }
            return response.json();
        })
        .then(respostajson => {
            console.log(respostajson.data);
    
            if (respostajson.status === "success" && respostajson.data && respostajson.data.api_token) {
                // Guardam api_token del usuari
                let api_token = respostajson.data.api_token;
                // Guardam id del usuari
                let usuari_id = respostajson.data.id;
                // Guardam rol del usuari
                let usuari_rol = respostajson.data.rol;
                // Guardam nom del usuari
                let usuari_nom = respostajson.data.nom;
                // 
                props.guardaapi_token(api_token);  // executa la funció guardaapi_token que li passam per props
                props.guardausuari_id(usuari_id); // executa la funció guardausuari_id que li passam per props
                props.guardausuari_rol(usuari_rol); // executa la funció guardausuari_rol que li passam per props
                props.guardausuari_nom(usuari_nom); // executa la funció guardausuari_nom que li pass
                setError(false);
                navigate("/inici");    // redirigeix a la pàgina de comentaris
            } else {
                setError(true);
            }
            setLoading(false);
        })
        .catch(function (error) {
            console.log(error);
            setError(true);
            setLoading(false);
        });
    };

    const onSubmit = (e) => {
        e.preventDefault();
        ferLogin();
    };

    return (
        <>
            <h2>Login API - Grup E</h2>
            <hr />
            <Form onSubmit={onSubmit} method='post'>
                <Form.Group className="mb-3" controlId="formBasicEmail">
                    <Form.Label>Correu electrònic:</Form.Label>
                    <Form.Control type="email" placeholder="correu@exemple.com" value={mail} onChange={(e) => setMail(e.target.value)} />
                </Form.Group>

                <Form.Group className="mb-3" controlId="formBasiccontrasenya">
                    <Form.Label>Contrasenya:</Form.Label>
                    <Form.Control type="password" placeholder="Contrasenya" value={contrasenya} onChange={(e) => setContrasenya(e.target.value)} name="contrasenya" required autoComplete="current-contrasenya" />
                </Form.Group>
                <Button variant="primary" type="submit">Login</Button>
            </Form>
            {error && <Alert variant="danger">Usuari o contrasenya incorrectes.</Alert>}
            {loading && <Alert variant="info"><Spinner animation="border" /></Alert>}
            {/* Proves */}
            <h4>Usuari normal</h4>
            <p>juanperez@gmail.com</p>
            <p>JuanPerez123</p>
            <h4>Usuari gestor</h4>
            
        </>
    );
}
