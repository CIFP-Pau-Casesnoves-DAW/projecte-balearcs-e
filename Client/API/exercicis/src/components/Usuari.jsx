import React, { useState, useEffect } from 'react';
import ComentarisUsuari from './ComentarisUsuari';
import ValoracionsUsuari from './ValoracionsUsuari';
import UsuariDades from './UsuariDades';
import '../style/Style.css'; // Importa l'arxiu CSS

export default function Usuari(props) {
  const usuari = props.usuari_nom;
  const usuari_id = props.usuari_id;
  const token = props.api_token;
  const [showForm, setShowForm] = useState(false);

  return (
    <div className="user-section">
      <h1>Benvingut, {usuari}</h1>
      <p>Aquí podreu:</p>
      <ul>
        <li>Modificar les vostres dades personals</li>
        <li>Veure els comentaris que heu fet</li>
      </ul>
      <hr />
      <h3>Dades personals</h3>
      <br />
      {showForm ? (<UsuariDades usuari_id = {usuari_id} api_token={token}/>
      ) : (
        <button onClick={() => setShowForm(true)} className="btn btn-primary">Modificar dades personals</button>
      )}
      <hr />
      <div>
        <h3>Comentaris publicats</h3>
        <ComentarisUsuari userId={usuari_id} api_token={token}/>
        <hr />
        <h3>Valoracions publicades</h3>
        <ValoracionsUsuari userId={usuari_id} api_token={token}/>
      </div>
    </div>
  );
}
