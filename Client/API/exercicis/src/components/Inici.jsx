// Importem els Hooks necessaris de React, així com axios per fer peticions HTTP
// i Carousel de 'react-bootstrap' per a la presentació dels espais destacats.
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Carousel } from 'react-bootstrap';

// Establim estils per al modal 
const modalStyle = {
    backgroundColor: '#f5f5f5',
    color: 'black',
    borderRadius: '15px'
};


const HomePage = () => {
    // Definim l'estat per als espais destacats i les fotos associades.
    const [espaisDestacats, setEspaisDestacats] = useState([]);
    const [fotos, setFotos] = useState([]);

    // useEffect s'executa després de la primera renderització i cada vegada que l'estat canvia.
    useEffect(() => {
        
        const fetchEspais = async () => {
            try {
                const responseEspais = await axios.get('http://balearc.aurorakachau.com/public/api/espais');
                // Filtra els espais per a obtenir només els destacats.
                const espaisDestacats = responseEspais.data.data.filter((espai) => espai.destacat === 1);
                // Actualitzem l'estat amb els espais destacats.
                setEspaisDestacats(espaisDestacats);
            } catch (error) {
                // En cas d'error, l'imprimim a la consola.
                console.error('Error al obtenir els espais destacats', error);
            }
        };

        // Definim una funció asíncrona per a obtenir les fotos des de l'API.
        const fetchFotos = async () => {
            try {
                const responseFotos = await axios.get('http://balearc.aurorakachau.com/public/api/fotos');
                // Actualitzem l'estat amb les fotos obtingudes.
                setFotos(responseFotos.data.data);
            } catch (error) {
                // En cas d'error, l'imprimim a la consola.
                console.error('Error al obtenir les fotos', error);
            }
        };

        // Executem les funcions de fetch al montar el component.
        fetchEspais();
        fetchFotos();
    }, []);

    // Funció per a obtenir l'URL de la foto d'un espai donat el seu ID.
    const getFotoEspai = (espaiId) => {
        // Busquem la foto que correspon a l'ID de l'espai.
        const foto = fotos.find((foto) => foto.espai_id === espaiId);
        // Si la foto existeix, retornem l'URL, sinó retornem una cadena buida.
        return foto ? `http://balearc.aurorakachau.com/public/storage/${foto.foto}` : '';
    };

    // Renderitzem els espais destacats.
    return (
        <>
            <h1 style={{ color: 'Darkgreen', textAlign: 'center', padding: '30px'}}>BaleArts</h1>
            <p style={{ fontStyle: 'italic', textAlign: 'center' , paddingBottom: '30px'}}>Benvingut a la pàgina web de BaleArts</p>        <hr />
            <Carousel prevIcon={<span aria-hidden="true" className="carousel-control-prev-icon" />}
                nextIcon={<span aria-hidden="true" className="carousel-control-next-icon" />}>

                {/* Mapegem sobre els espais destacats per a crear un item del Carousel per a cada un. */}
                {espaisDestacats.map((espai) => (
                    espai.data_baixa === null ? ( // Afegim una condició per a filtrar espais amb data_baixa no nula
                        <Carousel.Item key={espai.id}>
                            <img
                                className="d-block w-100"
                                src={getFotoEspai(espai.id)}
                                alt={`Imatge de l'espai ${espai.nom}`}
                                style={{ width: '100%', height: '700px', objectFit: 'cover', borderRadius: '15px' }}
                            />
                            <Carousel.Caption style={modalStyle}>
                                <h3>{espai.nom}</h3>
                                <p>{espai.descripcio}</p>
                            </Carousel.Caption>
                        </Carousel.Item>
                    ) : null
                ))}
            </Carousel>
        </>
    );
};

export default HomePage;

