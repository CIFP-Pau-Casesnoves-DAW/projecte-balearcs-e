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




        // Segona crida a la API per obtenir els espais, que es realitza després de la primera
    //     const respostaEspais = await fetch('http://balearc.aurorakachau.com/public/api/espais', headersConfig);
    //     if (!respostaEspais.ok) throw new Error('Error en la resposta de la API d\'espais');
    //     const dadesEspais = await respostaEspais.json();
    //     setEspais(dadesEspais.data);
    //   } catch (error) {
    //     console.error('Error en obtenir les dades:', error);
    //   } finally {
    //     setCarregant(false);
    //   }
    // }

       



  // Funció per combinar la informació d'espais i municipis
  // const informacioCombinada = municipis.map(municipi => ({
  //   ...municipi,
    //espais: espais.filter(espai => espai.municipi_id === municipi.id),
  //   municipi_id: municipi.id.filter(espai => espai.municipi_id === municipi.id)
  // }));

  if (carregant) {
    return <div>Carregant dades...</div>;
  }

  return (
    <div>
      {municipis.map(municipi => (
        <div key={municipi.id}>
          <h3>{municipi.nom}</h3>
        </div>
      ))}
    </div>
  );
};

export default LlistaMunicipis;
