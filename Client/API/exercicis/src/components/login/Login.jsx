import React, { useState } from 'react';
import { Alert, Spinner, Form, Button, Container } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import '../../style/Style.css'; // Importa l'arxiu CSS

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
                let api_token = respostajson.data.api_token;
                let usuari_id = respostajson.data.id;
                let usuari_rol = respostajson.data.rol;
                let usuari_nom = respostajson.data.nom;
                
                props.guardaapi_token(api_token);
                props.guardausuari_id(usuari_id);
                props.guardausuari_rol(usuari_rol);
                props.guardausuari_nom(usuari_nom);
                setError(false);
                navigate("/inici");
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
        <div className='contingut'>
            <Container className="login-container">
                <h2 className="login-title">Login</h2>
                <Form onSubmit={onSubmit} method='post'>
                    <Form.Group controlId="formBasicEmail">
                        <Form.Label><i className="bi bi-envelope-fill"></i> Correu electrònic:</Form.Label>
                        <Form.Control type="email" placeholder="correu@exemple.com" value={mail} onChange={(e) => setMail(e.target.value)} />
                    </Form.Group>

                    <Form.Group controlId="formBasiccontrasenya">
                        <Form.Label><i className="bi bi-lock-fill"></i> Contrasenya:</Form.Label>
                        <Form.Control type="password" placeholder="Contrasenya" value={contrasenya} onChange={(e) => setContrasenya(e.target.value)} name="contrasenya" required autoComplete="current-contrasenya" />
                    </Form.Group>
                    <Button variant="primary" type="submit" className="login-button col-12" disabled={loading}>
                        {loading ? <Spinner animation="border" size="sm" /> : 'Login'}
                    </Button>
                </Form>
                {error && <Alert variant="danger">Usuari o contrasenya incorrectes.</Alert>}
                {loading && <Alert variant="info">Autenticant...</Alert>}
                {/* Proves */}
                <hr />
                <div>
                    <h4>Usuari normal</h4>
                    <p>juanperez@gmail.com</p>
                    <p>JuanPerez123</p>
                </div>
                <div>
                    <h4>Usuari gestor</h4>
                    <p>gregoriomartorell@gmail.com</p>
                    <p>GregorioMartorell123</p>
                </div>
            </Container>
        </div>
    );
}
