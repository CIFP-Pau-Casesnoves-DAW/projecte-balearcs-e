import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Modal, Button } from 'react-bootstrap';

const LlistaEspais = ({ api_token, showModal, handleClose }) => {
  const [espais, setEspais] = useState([]);
  const token = api_token;

  useEffect(() => {
    const fetchEspais = async () => {
        const headersConfig = {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        };
        
      try {
        const response = await axios.get('http://balearc.aurorakachau.com/public/api/espais', headersConfig);
        setEspais(response.data.data);
      } catch (error) {
        console.error('Error al obtenir la llista d\'espais:', error);
        // Aquí pots gestionar l'error, com per exemple mostrar un missatge a l'usuari
      }
    };

    if (api_token) {
      fetchEspais();
    }
  }, [api_token]);

  return (
    <Modal show={showModal} onHide={handleClose}>
      <Modal.Header closeButton>
        <Modal.Title>Llista d'Espais</Modal.Title>
      </Modal.Header>
      <Modal.Body>
        <ul>
          {espais.map((espai) => (
            <li key={espai.id}>{espai.nom}</li>
          ))}
        </ul>
      </Modal.Body>
      <Modal.Footer>
        <Button variant="secondary" onClick={handleClose}>
          Tancar
        </Button>
      </Modal.Footer>
    </Modal>
  );
};

export default LlistaEspais;
