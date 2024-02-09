import React, { useState, useEffect } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { storage } from "../utils/storage.js"; 

export default function ComentarisUsuari({ userId }) {
  const [comentaris, setComentaris] = useState([]);
  const token = storage.get('api_token');

  useEffect(() => {
    const fetchComentaris = async () => {
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
        console.log(data);
      } catch (error) {
        console.error('Error al obtenir els comentaris:', error);
      }
    };
    fetchComentaris(); 
  }, [userId]); 

  return (
    <div>
      <table className="table">
        <thead>
          <tr>
            <th>Comentari</th>
            <th>Validat</th>
          </tr>
        </thead>
        <tbody>
          {comentaris.map((comentari) => (
            <tr key={comentari.id}>
              <td>{comentari.comentari}</td>
              <td>{comentari.validat ? <span style={{ color: 'green' }}>Sí</span> : <span style={{ color: 'red' }}>No</span>}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
