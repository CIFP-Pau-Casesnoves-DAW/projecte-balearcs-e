import React, { useState, useEffect, Fragment } from "react";
import { ListGroup, Row, Col, Spinner, Button } from 'react-bootstrap';
import { useNavigate } from "react-router-dom";

export default function Comentaris() {
    const [comentaris, setComentaris] = useState([]);
    const [descarregant, setDescarregant] = useState(true);
    const navigate = useNavigate();

    useEffect(() => { 
        descarrega();
    }, []);

    // Funció per carregar els comentaris des de l'API
    const descarrega = async () => {
        try {
             const resposta = await fetch('http://balearc.aurorakachau.com/public/api/comentaris');
            const jsonresposta = await resposta.json();
            setComentaris(jsonresposta.data);
        } catch (error) {
            console.log(error);
        }
        setDescarregant(false);
    }

    if (descarregant) {
        return (
            <div>
                <h1>Comentaris</h1>
                <Spinner />
            </div>
        );
    } else {
        return (
            <>
                <hr />
                <Row md={4}>
                    <Col>
                        <h4>Llista de Comentaris</h4>
                    </Col>
                    <Col>
                        <Button
                            variant="warning"
                            type="button"
                            onClick={() => {
                                navigate("/Comentaris/afegir");
                            }}
                        >
                            Afegir comentari
                        </Button>
                    </Col>
                </Row>
                <br />
                <ListGroup>
                    <ListGroup.Item variant="info">
                        <Row md={4}>
                            <Col><strong>Id</strong></Col>
                            <Col><strong>Comentari</strong></Col>
                            <Col><strong>Data</strong></Col>
                            <Col><strong>Accions</strong></Col>
                        </Row>
                    </ListGroup.Item>
                    {comentaris.map(function (comentari, index) {
                        return (
                            <Fragment key={index}>
                                <ListGroup.Item variant="primary" >
                                    <Row md={4}>
                                        <Col>{comentari.id}</Col>
                                        <Col>{comentari.comentari}</Col>
                                        <Col>{comentari.data}</Col>
                                        <Col>
                                            <Button variant="info" onClick={() => { navigate("/Comentaris/" + comentari.id) }}>Editar</Button>
                                        </Col>
                                    </Row>
                                </ListGroup.Item>
                            </Fragment>
                        );
                    })}
                </ListGroup>
            </>
        );
    }
}