import React from 'react';
import { storage } from '../utils/storage';

export default function Usuari() {
  const usuari = storage.get('usuari_nom');

  return (
    <div>
      <h1>Benvingut, {usuari}!</h1>
      <p>Gràcies per visitar la nostra pàgina d'inici.</p>
      <h3>API GRUP - E</h3>
    </div>
  );
}