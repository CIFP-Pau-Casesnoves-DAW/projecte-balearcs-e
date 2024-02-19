import React, { useEffect, useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';

export default function ModalitatsSelect(props) {
    const [modalitats, setModalitats] = useState([]);
    const token = props.api_token;
    const codiespai = props.codiespai;
    const [selectedOption, setSelectedOption] = useState('');

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
        .then(data => {
            setModalitats(data.data);
            // Establim la opció seleccionada basada en el codi d'espai
            const modalitat = data.data.find(modalitat => modalitat.codiespai === codiespai);
            if (modalitat) {
                setSelectedOption(modalitat.nom_modalitat);
            }
        });
    }, []);

    return (
        <select className="form-control" value={selectedOption}>
            {modalitats && modalitats.map((modalitat) => (
                <option key={modalitat.id} value={modalitat.nom_modalitat}>
                    {modalitat.nom_modalitat}
                </option>
            ))}
        </select>
    );
};
