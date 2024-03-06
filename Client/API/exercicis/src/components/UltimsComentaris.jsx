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
            <hr />
            <h1 style={{ textAlign: 'center', padding: '20px' }}>Últims Comentaris</h1>
            <hr />
        <Carousel prevIcon={<span aria-hidden="true" className="carousel-control-prev-icon" />}
                    nextIcon={<span aria-hidden="true" className="carousel-control-next-icon" />}>            
                {comentaris.map((comentari) => (
                <Carousel.Item key={comentari.id} interval={4000}> {/* Ajusta a 3 segons */}
                        <Card className="mb-3" style={{borderRadius: '15px'}} id='comentaris'>
                            <Card.Body style={{ textAlign: 'center', backgroundColor: '#F3F9E3', border: '1px solid black', color: 'black', borderRadius: '15px' }}>
                            <Card.Title>Espai: {comentari.nomEspai}</Card.Title>
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