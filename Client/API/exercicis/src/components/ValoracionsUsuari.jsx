import React, { useState, useEffect } from 'react';
import { Spinner } from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import { storage } from "../utils/storage.js"; 

export default function ValoracionsUsuari({ userId }) {
  const [valoracions, setValoracions] = useState([]);
  const [loading, setLoading] = useState(false);
  const [espais, setEspais] = useState({});
  const token = storage.get('api_token');

  useEffect(() => {
    const fetchValoracions = async () => {
      setLoading(true);
      try {
        // Fetch de les valoracions de l'usuari
        const responseValoracions = await fetch(`http://balearc.aurorakachau.com/public/api/valoracions?usuari_id=${userId}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });
        const dataValoracions = await responseValoracions.json();
        setValoracions(dataValoracions.data);

        // Recollir els noms dels espais
        const espaisIds = dataValoracions.data.map(valoracio => valoracio.espai_id);
        const fetchEspaisPromises = espaisIds.map(async espaiId => {
          const responseEspai = await fetch(`http://balearc.aurorakachau.com/public/api/espais/${espaiId}`, {
            method: 'GET',
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'Authorization': `Bearer ${token}`
            }
          });
          const dataEspai = await responseEspai.json();
          return { [espaiId]: dataEspai.data.nom };
        });
        const espaisData = await Promise.all(fetchEspaisPromises);
        const espaisObject = espaisData.reduce((acc, espai) => ({ ...acc, ...espai }), {});
        setEspais(espaisObject);

      } catch (error) {
        console.error('Error al obtenir les valoracions:', error);
      }
      setLoading(false);
    };
    fetchValoracions(); 
  }, [userId, token]); 

  return (
    <div>
      <table className="table">
        <thead>
          <tr>
            <th>Espai</th>
            <th>Valoració</th>
          </tr>
        </thead>
        <tbody>
          {valoracions.map((valoracio) => (
            <tr key={valoracio.id}>
              <td>{espais[valoracio.espai_id]}</td>
              <td>{valoracio.puntuacio}</td>
            </tr>
          ))}
        </tbody>
      </table>
      {loading && <Spinner animation="border" />}
    </div>
  );
}
