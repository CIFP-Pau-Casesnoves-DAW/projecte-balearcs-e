import React, { useEffect, useState } from 'react';
import axios from 'axios';

const BarraCerca = () => {
    const [resultats, setResultats] = useState([]);
    const [searchText, setSearchText] = useState('');

    // Endpoint per cercar espais (ajustat per incloure cerca)
    const endpointEspais = `http://balearc.aurorakachau.com/public/api/espais?cerca=${searchText}`;

    useEffect(() => {
        // Funció per a cercar espais basat en el text de cerca
        const fetchData = async () => {
            if (!searchText.trim()) {
                setResultats([]);
                return; // Evita la cerca si el text està buit
            }

            try {
                const response = await axios.get(endpointEspais);
                setResultats(response.data.data); 
            } catch (error) {
                console.error('Error al obtenir els espais', error);
            }
        };

        // Retard de 500ms per a millorar l'experiència d'usuari i reduir peticions innecessàries
        const timeoutId = setTimeout(() => {
            fetchData();
        }, 500);

        return () => clearTimeout(timeoutId); // Neteja el timeout quan el component es desmonti o actualitzi

    }, [searchText]); // Dependència de l'`useEffect`: searchText

    const handleSearchInputChange = (e) => {
        setSearchText(e.target.value);
    };

    return (
        <>
            <div>
                <input
                    type="text"
                    className="form-control"
                    placeholder="Cerca espais per nom, municipi, serveis..."
                    value={searchText}
                    onChange={handleSearchInputChange}
                    style={{
                        height: '38px',
                        fontSize: '16px',
                        minWidth: '400px',
                        margin: '0 auto 10px auto', // Centra l'input horitzontalment i afegeix un marge inferior
                        display: 'block', // Asegura que l'input es mostri en la seva pròpia línia
                    }}
                />
            </div>
            <div id='resultatscerca'>
                {resultats.length > 0 ? (
                    <table className="table">
                        <thead>
                            <tr>
                                <th>RESULTATS</th>
                                {/* Afegeix més capçaleres de columnes segons les dades que vols mostrar */}
                            </tr>
                        </thead>
                        <tbody>
                            {resultats.map((resultat) => (
                                <tr key={resultat.id}>
                                    <td>{resultat.nom}</td>
                                   
                                </tr>
                            ))}
                        </tbody>
                    </table>
                ) : (
                    <p></p>
                )}
            </div>
        </>
    );
};

export default BarraCerca;