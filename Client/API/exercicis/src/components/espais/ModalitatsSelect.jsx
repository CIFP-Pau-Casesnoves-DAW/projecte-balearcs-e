import React, { useEffect, useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';

export default function ModalitatsSelect(props) {
    const [modalitats, setModalitats] = useState([]);
    const token = props.api_token;

    useEffect(() => {
        fetch('http://balearc.aurorakachau.com/public/api/modalitats', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
        })
        .then(response => response.json())
        .then(data => setModalitats(data.data));
    }, []);

    return (
        <select className="form-control">
            {modalitats && modalitats.map((modalitat) => (
                <option key={modalitat.id} value={modalitat.nom_modalitat}>
                    {modalitat.nom_modalitat}
                </option>
            ))}
        </select>
    );
};
