import React, { useState, useEffect } from 'react';

const LlistaMunicipis = ({ api_token }) => {
  const [municipis, setMunicipis] = useState([]);
  const [espais, setEspais] = useState([]);
  const [carregant, setCarregant] = useState(true);

  useEffect(() => {
    const headersConfig = {
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${api_token}`
      }
    };

    async function obtenirMunicipis() {
      try {
        const respostaMunicipis = await fetch('http://balearc.aurorakachau.com/public/api/municipis', headersConfig);
        if (!respostaMunicipis.ok) throw new Error('Error en la resposta de la API de municipis');
        const dadesMunicipis = await respostaMunicipis.json();
        setMunicipis(dadesMunicipis.data);
        setCarregant(false);
      } catch (error) {
        console.error('Error en obtenir municipis:', error);
        setCarregant(false);
      }
    }

    obtenirMunicipis();
  }, [api_token]);

  if (carregant) {
    return <div>Carregant dades...</div>;
  }

  if (carregant) {
    return <div>Carregant dades...</div>;
  }

  return (
    <div>
      {municipis.map(municipi => (
        <div key={municipi.id}>
          <p>{municipi.nom}</p>
        </div>
      ))}
    </div>
  );
};

export default LlistaMunicipis;