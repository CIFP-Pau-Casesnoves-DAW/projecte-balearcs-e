import React, { useState, useEffect } from 'react';
import { Spinner } from 'react-bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import { storage } from "../utils/storage.js"; 

export default function ComentarisUsuari({ userId }) {
  const [comentaris, setComentaris] = useState([]);
  const [loading, setLoading] = useState(false);
  const token = storage.get('api_token');

  useEffect(() => {
    const fetchComentaris = async () => {
      setLoading(true);
      try {
        const response = await fetch(`http://balearc.aurorakachau.com/public/api/usuaris/${userId}`,{
          method: 'GET',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          }
        });
        const data = await response.json();
        setComentaris(data.data.comentaris);
      } catch (error) {
        console.error('Error al obtenir els comentaris:', error);
      }
      setLoading(false);
    };
    fetchComentaris(); 
  }, [userId]); 

  return (
    <div>
      <table className="table">
        <thead>
          <tr>
            <th>Comentari</th>
            <th>Validació</th>
          </tr>
        </thead>
        <tbody>
          {comentaris.map((comentari) => (
            <tr key={comentari.id}>
              <td>{comentari.comentari}</td>
              <td>{comentari.validat ? <span style={{ color: 'green' }}>Confirmada</span> : <span style={{ color: 'red' }}>En espera</span>}</td>
            </tr>
          ))}
        </tbody>
      </table>
      {loading && <Spinner animation="border" />}
    </div>
  );
}
