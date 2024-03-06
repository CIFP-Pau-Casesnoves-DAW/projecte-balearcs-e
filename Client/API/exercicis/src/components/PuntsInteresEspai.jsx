import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Card } from 'react-bootstrap';

const PuntsInteresEspai = ({ api_token }) => {
    const [espais, setEspais] = useState([]);
    const [puntsInteres, setPuntsInteres] = useState([]);

    useEffect(() => {
        // Definim la configuració de les capçaleres per a les crides a l'API
        const headersConfig = {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${api_token}`
            }
        };
        
        // Funció per carregar tots els espais i punts d'interès
        const fetchEspaisPuntsInteres = async () => {
            try {
                // Obtenim tots els espais
                const responseEspais = await axios.get('http://balearc.aurorakachau.com/public/api/espais', headersConfig);
                setEspais(responseEspais.data.data);
                
                // Obtenim tots els punts d'interès
                const responsePuntsInteres = await axios.get('http://balearc.aurorakachau.com/public/api/punts_interes', headersConfig);
                setPuntsInteres(responsePuntsInteres.data.data);
            } catch (error) {
                console.error('Error al obtenir les dades', error);
            }
        };

        fetchEspaisPuntsInteres();
    }, [api_token]);

    return (
        <div className="container mt-4">
            <hr />
            <h1 className="mb-4 text-center">Punts d'Interès dels Espais</h1>
            <hr />
            <div className="d-flex flex-wrap justify-content-around">
                {espais.map((espai) => {
                    const punts = puntsInteres.filter((punt) => punt.espai_id === espai.id);
                    if (espai.data_baixa === null) {
                    return (
                        <Card key={espai.id} style={{ width: 'calc(25% - 1rem)', minHeight: '300px', margin: '0.5rem' }}>  
                        <Card.Body>
                            <Card.Title><strong>Espai:</strong> {espai.nom}</Card.Title>
                            <hr />
                            {punts.length > 0 ? (
                                punts.filter((punt) => punt.data_baixa === null).map((punt) => (
                                    <div key={punt.id} id='puntsinteres'>
                                        <Card.Subtitle className="mb-2 text-muted"><strong>Títol:</strong> {punt.titol}</Card.Subtitle>
                                        <Card.Text><strong>Descripció:</strong> {punt.descripcio}</Card.Text>
                                    </div>
                                ))
                            ) : (
                                <Card.Text>Aquest espai no té punts d'interès disponibles.</Card.Text>
                            )}
                        </Card.Body>
                    </Card>
                    );
                } else{
                    return null;
                }})}
            </div>
        </div>
    );
};

export default PuntsInteresEspai;
