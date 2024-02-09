import React, { useState, useEffect } from 'react';
import { storage } from '../utils/storage';
import ComentarisUsuari from './ComentarisUsuari'; 

export default function Usuari(props) {
  const usuari = props.usuari_nom;
  const usuari_id = props.usuari_id;
  const token = props.api_token;
  const [showForm, setShowForm] = useState(false);
  const [llinatges, setllinatges] = useState('');
  const [nom, setNom] = useState('');
  const [dni, setDni] = useState('');

  const handleFormSubmit = (e) => {
    e.preventDefault();
  };

  const handleCancel = () => {
    setShowForm(false);
  };

  useEffect(() => {
      fetchDadesusuari();
  }, []);

  const fetchDadesusuari = async () => {
    try {
      const response = await fetch(`http://balearc.aurorakachau.com/public/api/usuaris/${usuari_id}`,
      {
        method: 'GET',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`
        }
      });
      const data = await response.json();
      setllinatges(data.data.llinatges);
      setDni(data.data.dni);
    } catch (error) {
      console.error('Error en descarregar els llinatges:', error);
    }
  };

  return (
    <div>
      <hr />
      <h1>Benvingut, {usuari}</h1>
      <p>Aquí podreu:</p>
      <ul>
        <li>Modificar les vostres dades personals</li>
        <li>Veure els comentaris que heu fet</li>
      </ul>
      <hr />
      <h3>Dades personals</h3>
      <br />
      {showForm ? (
        <form onSubmit={handleFormSubmit}>
          <div className="form-group">
            <label htmlFor="nom">Nom:</label>
            <input
              type="text"
              className="form-control"
              id="nom"
              value={usuari}
              onChange={(e) => setNom(e.target.value)}
            />
          </div>
          <div className="form-group">
            <label htmlFor="llinatges">Llinatges:</label>
            <input
              type="text"
              className="form-control"
              id="llinatges"
              value={llinatges}
              onChange={(e) => setllinatges(e.target.value)}
            />
          </div>
          <div className="form-group">
            <label htmlFor="dni">DNI:</label> 
            <input
              type="text"
              className="form-control"
              id="dni"
              value={dni}
              onChange={(e) => setDni(e.target.value)}
            />
          </div>
          <br />
          <button type="submit" className="btn btn-primary">Guardar</button>
          <button onClick={handleCancel} className="btn btn-secondary">Cancelar</button>
        </form>
      ) : (
        <button onClick={() => setShowForm(true)} className="btn btn-primary">Modificar dades personals</button>
      )}
      <hr />
      <div>
        <h3>Comentaris publicats</h3>
        <ComentarisUsuari userId={usuari_id} />
      </div>
    </div>
  );
}
