import React, { useState, useEffect } from "react";
import { Form } from "react-bootstrap";

const SelectEspais = ({ id, onChange, api_token }) => {
    const [espais, setEspais] = useState([]);
    const [espaiSeleccionatId, setEspaiSeleccionatId] = useState(null);
    const token = api_token;

    useEffect(() => {
        fetch('http://balearc.aurorakachau.com/public/api/espais', {
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
        console.log(espais);
    }, []);

    const handleEspaiChange = (event) => {
        const selectedEspaiId = event.target.value;
        setEspaiSeleccionatId(selectedEspaiId); // Actualizar el estado con el nuevo valor seleccionado
        onChange(selectedEspaiId); // Pasar el valor seleccionado al componente padre
        console.log(selectedEspaiId); // Usar el valor actualizado
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
    const [selectedPuntInteresId, setSelectedPuntInteresId] = useState(null);

    useEffect(() => {
        if (espais && espais.length > 0) {
            const espaiSeleccionat = espais.find(espai => espai.id == idEspai);
            if (espaiSeleccionat && espaiSeleccionat.puntsinteres) {
                setPuntsInteres(espaiSeleccionat.puntsinteres);
            } else {
                setPuntsInteres([]);
            }
        }
    }, [idEspai, espais]);

    const handlePuntInteresChange = (event) => {
        const selectedPuntInteresId = event.target.value;
        setSelectedPuntInteresId(selectedPuntInteresId); // Update the selected puntInteresId
        onChange(selectedPuntInteresId); // Pass the selected value to the parent component
    };

    return (
        <div>
            <Form.Label>Punt d'Interés actual: <strong>{selectedPuntInteresId}</strong></Form.Label>
            <select id="puntsInteres" onChange={handlePuntInteresChange} className="form-select">
                <option value="-1">Selecciona un punt d'interès</option>
                {puntsInteres && puntsInteres.map(puntInteres => (
                    <option key={puntInteres.id} value={puntInteres.id}>{puntInteres.titol}</option>
                ))}
            </select>
        </div>
    );
};

export { SelectEspais, SelectPuntsInteres };