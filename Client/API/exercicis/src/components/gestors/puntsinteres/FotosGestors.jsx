import React, { useState, useEffect } from 'react';
import { Spinner, Alert } from 'react-bootstrap';

export default function FotosGestors(props) {
    const idesp = props.idespai;
    const idpnt = props.idpunt;
    const token = props.api_token;

    const [fotos, setFotos] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        fetchFotos();
    }, []);
    
    const fetchFotos = async () => {
        try {
            const response = await fetch('http://balearc.aurorakachau.com/public/api/fotos', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const data = await response.json();
            if (response.ok) {
                // Filtra les fotos pel punt d'interès i l'espai
                const fotosFiltrades = data.data.filter(foto => foto.punt_interes_id === idpnt && foto.espai_id === idesp);
                setFotos(fotosFiltrades);
            } else {
                setError(data.message || 'Error en obtenir les fotos');
            }
            setLoading(false);
        } catch (error) {
            console.error('Error en obtenir les fotos:', error);
            setError('Hi ha hagut un error en obtenir les fotos');
            setLoading(false);
        }
    };
    

    if (loading) {
        return <Spinner animation="border" variant="primary" />;
    }

    if (error) {
        return <Alert variant="danger">{error}</Alert>;
    }

    if (fotos.length === 0) {
        return <Alert variant="info">El punt d'interès no conté fotos</Alert>;
    }

    return (
        <div>
            <table className="table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Comentari</th>
                    </tr>
                </thead>
                <tbody>
                    {fotos.map((foto, index) => (
                        <tr key={index}>
                            <td><img src={`http://balearc.aurorakachau.com/public/storage/${foto.foto}`} alt={`Foto ${index + 1}`} style={{ maxWidth: '100px', maxHeight: '100px' }} /></td>
                            <td>{foto.comentari}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
