import React, { useState, useEffect } from "react";

const SelectEspais = ({ id, onChange }) => {
    const [espais, setEspais] = useState([]);

    useEffect(() => {
        fetch('http://balearc.aurorakachau.com/public/api/espais')
            .then(response => response.json())
            .then(data => setEspais(data.data))
            .catch(error => console.error('Error:', error));
    }, []);

    return (
        <select id={id} onChange={onChange} className="form-select">
            <option value="-1">Selecciona un espai</option>
            {espais.map(espai => (
                <option key={espai.id} value={espai.id}>{espai.nom}</option>
            ))}
        </select>
    );
};

export default SelectEspais;
