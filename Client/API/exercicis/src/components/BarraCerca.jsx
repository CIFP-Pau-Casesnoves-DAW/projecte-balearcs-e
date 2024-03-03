import React, { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';
import { storage } from '../utils/storage'; 
import LlistaMunicipis from './LlistaMunicipis';

const BarraCerca = ({ api_token }) => {
    const [cercaTipus, setCercaTipus] = useState('');
    const [dades, setDades] = useState([]);
    const [mostraModal, setMostraModal] = useState(false);


    const headersConfig = {
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${api_token}`
        }
    };

    const handleSelectChange = (event) => {
        const tipus = event.target.value;
        setCercaTipus(tipus);
        // Per a 'municipis', simplement canviem l'estat per mostrar el modal sense cridar a carregaDades
        setMostraModal(true);
        if (tipus !== 'municipis') {
            carregaDades(tipus);
        }
    };
    
        

    const carregaDades = async (tipus) => {
        let url = '';
        switch (tipus) {
            case 'espais':
                url = 'http://balearc.aurorakachau.com/public/api/espais';
                break;
                
            case 'grau_acc':
                url = 'http://balearc.aurorakachau.com/public/api/espais?orderBy=grau_acc';
                break;
            case 'serveis':
                url = 'http://balearc.aurorakachau.com/public/api/serveis';
                break;
            default:
                setDades([]);
                return;
        }

        try {
            const resposta = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${api_token}` // Assegura't que api_token està disponible
                }
            });
            if (!resposta.ok) {
                throw new Error(`Error de la resposta de l'API: ${resposta.status}`);
            }
            const result = await resposta.json();
            setDades(result.data);
            setMostraModal(true);
        } catch (error) {
            console.error("Hi ha hagut un error en la crida a l'API o processant la resposta:", error);
        }
    };


    


    const renderitzarContingutModal = () => {
        if (!Array.isArray(dades)) {
            return <p>Les dades no estan disponibles</p>;
        }
        switch (cercaTipus) {
            case 'espais':
            case 'grau_acc':
            case 'serveis':
                return dades.map((item, index) => <p key={index}>{item.nom}</p>);
            case 'municipis':
                // S'ha corregit aquesta línia, ara retorna el component correctament.
                return <LlistaMunicipis api_token={api_token} />;
            default:
                return <p>Selecciona un tipus de cerca</p>;
        }
    };
    

    return (
        <>
            <h2 className="mb-3">Cerca d'Espais i Serveis</h2>
            <div>
                <select
                    value={cercaTipus}
                    onChange={handleSelectChange}
                    className="form-control mb-3"
                    style={{ width: '200px', margin: '0 auto' }}
                >
                    <option value="">Selecciona el tipus de cerca</option>
                    <option value="espais">Espais</option>
                    <option value="municipis">Municipis</option>
                    <option value="grau_acc">Grau d'Accessibilitat</option>
                    <option value="serveis">Serveis</option>
                </select>
            </div>
            <Modal show={mostraModal} onHide={() => setMostraModal(false)}>
                <Modal.Header closeButton>
                    <Modal.Title>Resultats de la cerca</Modal.Title>
                </Modal.Header>
                <Modal.Body>{renderitzarContingutModal()}</Modal.Body>
                <Modal.Footer>
                    <Button variant="secondary" onClick={() => setMostraModal(false)}>
                        Tancar
                    </Button>
                </Modal.Footer>
            </Modal>
        </>
    );
};

export default BarraCerca;
