import React, { useState, useEffect } from "react";

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
    }, []);

    const handleEspaiChange = (event) => {
        const selectedEspaiId = event.target.value;
        setEspaiSeleccionatId(selectedEspaiId); // Actualizar el estado con el nuevo valor seleccionado
        onChange(selectedEspaiId); // Pasar el valor seleccionado al componente padre
    };

    return (
        <>
            <select id={id} onChange={handleEspaiChange} className="form-select" value={id}>
                <option value="-1">Selecciona un espai</option>
                {espais && espais.map(espai => (
                    <option key={espai.id} value={espai.id}>{espai.nom}</option>
                ))}
            </select>
            <br />
        </>
    );
};

export { SelectEspais };