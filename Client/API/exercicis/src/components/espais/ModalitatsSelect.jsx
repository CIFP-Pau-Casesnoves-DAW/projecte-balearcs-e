import React, { useEffect, useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { useParams } from 'react-router-dom';

export default function ModalitatsSelect(props) {
    const [modalitats, setModalitats] = useState([]);
    const [modalitatsEspai, setModalitatsEspai] = useState([]);
    const token = props.api_token;
    const codi_espai = props.codiespai;
    const [selectedOption, setSelectedOption] = useState('');
    const { id } = useParams();
    const [error, setError] = useState('');

    useEffect(() => {
        if(id !== "-1"){
            getModalitats();
            getModalitatsEspai();
        }
        else{
            setError("No s'ha pogut carregar la llista de modalitats.");
        }
    }, [id]);

    const getModalitats = () => {
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
            console.log(modalitats);
        });
    }

    const getModalitatsEspai = () => {
        fetch('http://balearc.aurorakachau.com/public/api/espais_modalitats', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
        })
        .then(response => response.json())
        .then(data => {
            setModalitatsEspai(data.data);
            console.log(modalitatsEspai);
        });
    }

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
