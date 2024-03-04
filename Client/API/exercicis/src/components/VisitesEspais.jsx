import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Card } from 'react-bootstrap';

const VisitesEspais = ({ api_token }) => {
    const [espais, setEspais] = useState([]);
    const [visites, setVisites] = useState([]);

    useEffect(() => {
        const headersConfig = {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${api_token}`
            }
        };
        
        const fetchEspaisVisites = async () => {
            try {
                const responseEspais = await axios.get('http://balearc.aurorakachau.com/public/api/espais', headersConfig);
                setEspais(responseEspais.data.data);
                
                const responseVisites = await axios.get('http://balearc.aurorakachau.com/public/api/visites', headersConfig);
                setVisites(responseVisites.data.data);
            } catch (error) {
                console.error('Error al obtenir les dades', error);
            }
        };

        fetchEspaisVisites();
    }, [api_token]);

    return (
        <div className="container mt-4">
            <h1 className="mb-4 text-center">Visites dels Espais</h1>
            <div className="d-flex flex-wrap justify-content-around">
                {espais.map((espai) => {
                    const visitesEspai = visites.filter((visita) => visita.espai_id === espai.id);
                    return (
                        <Card key={espai.id} style={{ width: 'calc(25% - 1rem)', minHeight: '300px', margin: '0.5rem' }}>
                            <Card.Body>
                                <Card.Title><strong>Espai:</strong> {espai.nom}</Card.Title>
                                {visitesEspai.length > 0 ? visitesEspai.map((visita, index) => (
                                    <div key={index}>
                                        <hr />
                                        <Card.Subtitle className="mb-2 text-muted"><strong>Títol:</strong> {visita.titol}</Card.Subtitle>
                                        <Card.Text>
                                            <strong>Descripció:</strong> {visita.descripcio}<br/>
                                            <hr />
                                            <strong>Núm. Places:</strong> {visita.n_places}<br/>
                                            <strong>Total Visitants:</strong> {visita.total_visitants}<br/>
                                            <hr />
                                            <strong>Data Inici:</strong> {visita.data_inici}<br/>
                                            <strong>Data Fi:</strong> {visita.data_fi}<br/>
                                            <hr />
                                            <strong>Horari:</strong> {visita.horari}
                                        </Card.Text>
                                    </div>
                                )) : (
                                    <Card.Text>Aquest espai no té visites programades.</Card.Text>
                                )}
                            </Card.Body>
                        </Card>
                    );
                })}
            </div>
        </div>
    );
};

export default VisitesEspais;