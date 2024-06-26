import React, { useState, useEffect } from 'react';
import axios from 'axios';

const LlistaServeis = ({ api_token }) => {
    const [serveis, setServeis] = useState([]);
    const API_URL = 'http://balearc.aurorakachau.com/public/api/serveis';

    useEffect(() => {
        const fetchServeis = async () => {
            try {
                const response = await axios.get(API_URL, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${api_token}`
                    }
                });
                setServeis(response.data.data);
            } catch (error) {
                console.error('Error al obtenir els serveis:', error);
            }
        };

        fetchServeis();
    }, [api_token]);

    return (
        <div>
            {serveis.map((servei) => (
                <p key={servei.id}>{servei.nom_serveis}</p>
            ))}
        </div>
    );
};

export default LlistaServeis;