import React, { useState, useEffect } from "react";

const SelectPuntsInteres = ({ idEspai, onChange, api_token }) => {
    const [puntsInteres, setPuntsInteres] = useState([]);
    const [selectedPuntInteresId, setSelectedPuntInteresId] = useState(null);
    const token = api_token;
    const espaiId = idEspai;

    useEffect(() => {
        fetch(`http://balearc.aurorakachau.com/public/api/espais/${espaiId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
            .then(response => response.json())
            .then(data => {
                setPuntsInteres(data.data.puntsinteres);

            })
            .catch(error => console.error('Error:', error));
    }, [espaiId]); // Ensure useEffect runs when idEspai or token changes

    const handlePuntInteresChange = (event) => {
        const selectedPuntInteresId = event.target.value;
        setSelectedPuntInteresId(selectedPuntInteresId); // Update the selected puntInteresId
        onChange(selectedPuntInteresId); // Pass the selected value to the parent component
    };

    return (
        <div>
            <select id="puntsInteres" onChange={handlePuntInteresChange} className="form-select" value={selectedPuntInteresId}>
                <option value="-1">Selecciona un punt d'interès</option>
                {puntsInteres && puntsInteres.map(puntInteres => (
                    <option key={puntInteres.id} value={puntInteres.id}>{puntInteres.titol}</option>
                ))}
            </select>
        </div>
    );
};

export { SelectPuntsInteres };