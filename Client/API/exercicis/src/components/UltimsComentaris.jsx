import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Card, Carousel } from 'react-bootstrap';

const UltimsComentaris = ({ api_token }) => {
    const [comentaris, setComentaris] = useState([]);
    const API_URL = 'http://balearc.aurorakachau.com/public/api';

    useEffect(() => {
        const fetchDades = async () => {
            try {
                const headersConfig = {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${api_token}`
                    }
                };

                const responseComentaris = await axios.get(`${API_URL}/comentaris`, headersConfig);
                let dadesComentaris = responseComentaris.data.data.slice(0, 5);

                for (let comentari of dadesComentaris) {
                    const responseEspai = await axios.get(`${API_URL}/espais/${comentari.espai_id}`, headersConfig);
                   // const responseUsuari = await axios.get(`${API_URL}/usuaris/${comentari.usuari_id}`, headersConfig);
                    comentari.nomEspai = responseEspai.data.data.nom;
                    //comentari.nomUsuari = responseUsuari.data.data.nom;
                }

                setComentaris(dadesComentaris);
            } catch (error) {
                console.error('Error al obtenir les dades', error);
            }
        };

        fetchDades();
    }, [api_token]);

    return (
        <>
            <h2 style={{ textAlign: 'center', padding: '20px' }}>Últims Comentaris</h2>
            <Carousel>
            {comentaris.map((comentari) => (
                <Carousel.Item key={comentari.id} interval={3000}> {/* Ajusta a 3 segons */}
                    <Card className="mb-3">
                        <Card.Body style={{ textAlign: 'center' }}>
                            <Card.Title>Nom de l'Espai: {comentari.nomEspai}</Card.Title>
                        {/*   <Card.Subtitle className="mb-2">Usuari: {comentari.nomUsuari}</Card.Subtitle>  */}
                            <Card.Text>Comentari: {comentari.comentari}</Card.Text>
                            <Card.Text>Data: {comentari.data}</Card.Text>
                        </Card.Body>
                    </Card>
                </Carousel.Item>
            ))}
        </Carousel>

        </>
    );
};

export default UltimsComentaris;