import React, { useState, useEffect } from 'react';

function EspaisOrdenats({ espais }) {
    const [espaisOrdenats, setEspaisOrdenats] = useState([]);

    useEffect(() => {
        if (espais && espais.length > 0) {
            // Filtrar espais con grado de accesibilidad
            const espaisConGrauAcc = espais.filter(espai => espai.grau_acc);

            // Ordenar espais por grado de accesibilidad (de alto a bajo)
            const espaisOrdenats = espaisConGrauAcc.sort((a, b) => {
                // Convertir grados de accesibilidad a un valor numérico para comparar
                const grauAccValor = {
                    'alt': 3,
                    'mig': 2,
                    'baix': 1
                };

                // Comparar valores numéricos de los grados de accesibilidad
                return grauAccValor[b.grau_acc] - grauAccValor[a.grau_acc];
            });

            setEspaisOrdenats(espaisOrdenats);
        }
    }, [espais]);

    return (
        <div>
            {espaisOrdenats.map((espai, index) => (
                <p key={index}>
                    {espai.nom} - {espai.grau_acc}
                </p>
            ))}
        </div>
    );
}

export default EspaisOrdenats;
