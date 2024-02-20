import React, { useState, useEffect } from "react";

const SelectEspais = ({ id, onChange, api_token }) => {
    const [espais, setEspais] = useState([]);
    const [espaiSeleccionatId, setEspaiSeleccionatId] = useState(null);
    const token = api_token;

    useEffect(() => {
        fetch('http://balearc.aurorakachau.com/public/api/espais',{
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
            .then(response => response.json())
            .then(data => setEspais(data.data))
            .catch(error => console.error('Error:', error));
    }, []);

    const handleEspaiChange = (event) => {
        const selectedEspaiId = event.target.value;
        setEspaiSeleccionatId(selectedEspaiId);
        onChange(selectedEspaiId); // Si cal notificar el canvi de l'espai seleccionat
    };

    return (
        <>
            <select id={id} onChange={handleEspaiChange} className="form-select">
                <option value="-1">Selecciona un espai</option>
                {espais && espais.map(espai => (
                    <option key={espai.id} value={espai.id}>{espai.nom}</option>
                ))}
            </select>
            <br />
            
            <SelectPuntsInteres idEspai={espaiSeleccionatId} onChange={onChange} espais={espais} />
        </>
    );
};


const SelectPuntsInteres = ({ idEspai, onChange, espais }) => {
    const [puntsInteres, setPuntsInteres] = useState([]);

    useEffect(() => {
        if (espais && espais.length > 0) {
            const espaiSeleccionat = espais.find(espai => espai.id === idEspai);
            if (espaiSeleccionat && espaiSeleccionat.puntsinteres) {
                setPuntsInteres(espaiSeleccionat.puntsinteres);
            } else {
                setPuntsInteres([]); 
            }
        }
    }, [idEspai, espais]);

    return (
        <select id="puntsInteres" onChange={onChange} className="form-select">
            <option value="-1">Selecciona un punt d'interès</option>
            {puntsInteres && puntsInteres.map(puntInteres => (
                <option key={puntInteres.id} value={puntInteres.id}>{puntInteres.titol}</option>
            ))}
        </select>
    );
};



export { SelectEspais, SelectPuntsInteres };
