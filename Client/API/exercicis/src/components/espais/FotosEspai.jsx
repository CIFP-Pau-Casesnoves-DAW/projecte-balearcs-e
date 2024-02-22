import React, { useState, useEffect } from 'react';
import { Spinner, Alert } from 'react-bootstrap';

function FotosEspai({ id }) {
    const [fotos, setFotos] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Funció per obtenir les fotos de l'espai
        const obtenirFotos = async () => {
            try {
                const response = await fetch(`http://balearc.aurorakachau.com/public/api/fotos`);
                const data = await response.json();
                setFotos(data.data);
                setLoading(false);
            } catch (error) {
                console.error('Error en obtenir les fotos:', error);
                setLoading(false);
            }
        };

        // Crida a la funció per obtenir les fotos quan es carrega el component
        obtenirFotos();

    }, [id]);

    // Assegura't que l'ID sigui numèric
    const espaiId = parseInt(id);

    // Filtra les fotos per l'ID de l'espai
    const fotosEspai = fotos.filter(foto => foto.espai_id === espaiId);

    return (
        <div>
            {loading ? (
                <Spinner animation="border" role="status">
                    <span className="visually-hidden">Carregant...</span>
                </Spinner>
            ) : (
                <div>
                    {fotosEspai.length > 0 ? (
                        <ul>
                            {fotosEspai.map((foto) => (
                                <li key={foto.id}>
                                    <img
                                        src={`http://balearc.aurorakachau.com/public/${foto.foto}`}
                                        alt={`Foto ${foto.id}`}
                                        style={{ maxWidth: '300px' }} // Estil per limitar l'ample a 300px
                                    />                                </li>
                            ))}
                        </ul>
                    ) : (
                        <Alert variant="info">L'espai no conté fotos</Alert>
                    )}
                </div>
            )}
        </div>
    );
}

export default FotosEspai;
