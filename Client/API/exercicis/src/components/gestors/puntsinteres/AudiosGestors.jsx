import React, { useState, useEffect } from 'react';
import { Spinner, Alert } from 'react-bootstrap';

export default function AudiosGestors(props) {
    const idesp = props.idespai;
    const idpnt = props.idpunt;
    const token = props.api_token;

    const [audios, setAudios] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        fetchAudios();
    }, []);
    
    const fetchAudios = async () => {
        try {
            const response = await fetch('http://balearc.aurorakachau.com/public/api/audios', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const data = await response.json();
            if (response.ok) {
                // Filtra els audios pel punt d'interès i l'espai
                const audiosFiltrats = data.data.filter(audio => audio.punt_interes_id === idpnt && audio.espai_id === idesp);
                setAudios(audiosFiltrats);
            } else {
                setError(data.message || 'Error en obtenir els audios');
            }
            setLoading(false);
        } catch (error) {
            console.error('Error en obtenir els audios:', error);
            setError('Hi ha hagut un error en obtenir els audios');
            setLoading(false);
        }
    };
    

    if (loading) {
        return <Spinner animation="border" variant="primary" />;
    }

    if (error) {
        return <Alert variant="danger">{error}</Alert>;
    }

    if (audios.length === 0) {
        return <Alert variant="info">El punt d'interès no conté audios</Alert>;
    }

    return (
        <div>
            <table className="table">
                <thead>
                    <tr>
                        <th>Audio</th>
                    </tr>
                </thead>
                <tbody>
                    {audios.map((audio, index) => (
                        <tr key={index}>
                            <td>
                                <audio controls>
                                    <source src={`http://balearc.aurorakachau.com/public/storage/${audio.audio}`} type="audio/mpeg" />
                                    Your browser does not support the audio element.
                                </audio>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}
