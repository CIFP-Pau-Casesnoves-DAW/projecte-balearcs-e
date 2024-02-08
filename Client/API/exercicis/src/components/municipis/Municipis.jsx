import React, { useState, useEffect, Fragment } from "react";
import { ListGroup, Row, Col, Spinner, Button } from 'react-bootstrap';
import { useNavigate } from "react-router-dom";
import { storage } from '../../utils/storage';

export default function Municipis() {
    const [municipis, setMunicipis] = useState([]);
    const [descarregant, setDescarregant] = useState(true);
    const navigate = useNavigate();
    const token = storage.get('api_token'); 


    useEffect(() => { descarrega() }, []);
    // Exemple de ftech amb async/await
    const descarrega = async () => {
        try {
            const resposta = await fetch('http://balearc.aurorakachau.com/public/api/municipis', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            const jsonresposta = await resposta.json();
            setMunicipis(jsonresposta.data);
        } catch (error) {
            console.log(error);
        }
        setDescarregant(false);
    }

    if (descarregant) {
        return (
            <div>
                <h1>Municipis</h1>
                <Spinner />
            </div>
        );
    }
    else {
        return (
            <>
                <hr />
                <Row md={4}>
                    <Col>
                        <h4>Llista de Municipis</h4>
                    </Col>
                    <Col>
                        <Button
                            variant="warning"
                            type="button"
                            onClick={() => {
                                navigate("/municipis/afegir");
                            }}
                        >
                            +
                        </Button>
                    </Col>
                </Row>
                <br />
                <ListGroup>
                    {municipis && municipis.map(function (element, index) {
                        return (
                            <Fragment key={index}>   
                                <ListGroup.Item variant="primary" >
                                    <Row md={4}>
                                        <Col>{element.nom}</Col>
                                        <Col>{element.illa_id}</Col>
                                        <Col><Button variant="info" onClick={() => { navigate("/municipis/" + element.id) }}>...</Button></Col>
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