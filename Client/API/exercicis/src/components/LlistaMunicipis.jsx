import React, { useState, useEffect } from 'react';

const LlistaMunicipis = ({ api_token }) => {
  const [municipis, setMunicipis] = useState([]);
  const [espais, setEspais] = useState([]);

  useEffect(() => {
    const headersConfig = {
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${api_token}`
      }
    };

    const obtenirEspais = async () => {
      try {
        const respostaEspais = await fetch('http://balearc.aurorakachau.com/public/api/espais', headersConfig);
        if (!respostaEspais.ok) throw new Error('Error en la resposta de la API d\'espais');
        const dadesEspais = await respostaEspais.json();
        setEspais(dadesEspais);
      } catch (error) {
        console.error('Error en obtenir espais:', error);
      }
    };

    const obtenirMunicipis = async () => {
      try {
        const respostaMunicipis = await fetch('http://balearc.aurorakachau.com/public/api/municipis', headersConfig);
        if (!respostaMunicipis.ok) throw new Error('Error en la resposta de la API de municipis');
        const dadesMunicipis = await respostaMunicipis.json();
        setMunicipis(dadesMunicipis);
      } catch (error) {
        console.error('Error en obtenir municipis:', error);
      }
    };

    obtenirEspais();
    obtenirMunicipis();
  }, [api_token]); // Dependència d'`useEffect`

  // Funció per combinar la informació d'espais i municipis
  const informacioCombinada = municipis.map(municipi => ({
    ...municipi,
    espais: espais.filter(espai => espai.municipiId === municipi.id),
  }));

  return (
    <div>
      {informacioCombinada.map(municipi => (
        <div key={municipi.id}>
          <h3>{municipi.nom}</h3>
          <ul>
            {municipi.espais.map(espai => (
              <li key={espai.id}>{espai.nom}</li>
            ))}
          </ul>
        </div>
      ))}
    </div>
  );
};

export default LlistaMunicipis;
