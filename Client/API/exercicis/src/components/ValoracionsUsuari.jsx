import React, { useState, useEffect } from 'react';
import { Spinner } from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

export default function ValoracionsUsuari(props) {
  const [valoracions, setValoracions] = useState([]);
  const [loading, setLoading] = useState(false);
  const [espais, setEspais] = useState({});
  const token = props.api_token;
  const usrid = props.userId;

  useEffect(() => {
    const fetchValoracions = async () => {
      setLoading(true);
      try {
        const responseValoracions = await fetch(`http://balearc.aurorakachau.com/public/api/usuaris/${usrid}`, {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });
        const dataValoracions = await responseValoracions.json();
        // Dins valoracions tenim un array de valoracions del usuari
        setValoracions(dataValoracions.data.valoracions);

        const responseEspais = await fetch('http://balearc.aurorakachau.com/public/api/espais', {
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });
        const dataEspais = await responseEspais.json();
        const espaisMap = {};
        dataEspais.data.forEach(espai => {
          espaisMap[espai.id] = espai;
        });
        // Tenim un mapa de tots els espais
        setEspais(espaisMap);

      } catch (error) {
        console.error('Error al obtenir les valoracions:', error);
      }
      setLoading(false);
    };

    fetchValoracions();

  }, [props.userId, token]);

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
          {valoracions && valoracions.map((valoracio) => (
            <tr key={valoracio.id}>
              <td>{espais[valoracio.espai_id]?.nom}</td>
              <td>{valoracio.puntuacio}</td>
            </tr>
          ))}
        </tbody>
      </table>
      {loading && <Spinner animation="border" />}
    </div>
  );
}
