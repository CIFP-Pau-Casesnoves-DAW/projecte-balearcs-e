import React, { useState, useEffect } from "react";
import { Form } from "react-bootstrap";

export default function SelectUsuaris({ id, onChange, api_token }) {
    const [usuaris, setUsuaris] = useState([]);
    const token = api_token; 

    useEffect(() => {
        const fetchUsuaris = async () => {
            try {
                const response = await fetch('http://balearc.aurorakachau.com/public/api/usuaris', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                const data = await response.json();
                setUsuaris(data.data);
            } catch (error) {
                console.error('Error en obtenir els usuaris', error);
            }
        };
        fetchUsuaris();
    }, [token]);

    return (
        <Form.Control as="select" id={id} onChange={onChange}>
            <option value="-1">Tria un usuari</option>
            {usuaris.length > 0 && usuaris.map((usuari) => (
                <option key={usuari.id} value={usuari.id}>
                    {usuari.nom} {usuari.llinatges}
                </option>
            ))}
        </Form.Control>
    );
    
}
