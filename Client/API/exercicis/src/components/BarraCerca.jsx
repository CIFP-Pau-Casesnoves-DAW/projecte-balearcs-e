import React, { useState } from 'react';
import { Modal, Button } from 'react-bootstrap';
import LlistaMunicipis from './LlistaMunicipis'; // Asumim que el component està en aquesta ruta
import LlistaEspais from './LlistaEspais'; // Asumim que el component està en aquesta ruta
import LlistaServeis from './LlistaServeis';


const BarraCerca = ({ api_token }) => {
    const [cercaTipus, setCercaTipus] = useState('nom');
    const [showModal, setShowModal] = useState(false);
    

    // Funció per determinar quin component mostrar dins del modal
    const renderComponentDinsModal = () => {
        switch(cercaTipus) {
            case 'municipi':
                return <LlistaMunicipis  api_token={api_token} />;
            // Altres casos per a 'nom', 'grau_acc', i 'serveis'...
            case 'nom':
                return <LlistaEspais />;
            //case 'grau_acc':
              //  return <LlistaGrausAcc api_token={api_token} />;
            case 'serveis':
                return <LlistaServeis api_token={api_token} />;

            default:
                return <p>No s'ha seleccionat cap tipus de cerca.</p>;
        }
    };

    const handleSelectChange = (e) => {
        setCercaTipus(e.target.value);
        // Depenent del tipus de cerca, podríem voler carregar la informació aquí
        // o simplement mostrar el modal que ja contindrà la informació necessària.
        setShowModal(true);
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
                    <option value="nom">Espais</option>
                    <option value="municipi">Municipis</option>
                    <option value="grau_acc">Grau d'Accessibilitat</option>
                    <option value="serveis">Serveis</option>
                </select>
            </div>
            <Modal show={showModal} onHide={() => setShowModal(false)}>
                <Modal.Header closeButton>
                    <Modal.Title>Resultats de la Cerca</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    {renderComponentDinsModal()}
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="secondary" onClick={() => setShowModal(false)}>Tanca</Button>
                </Modal.Footer>
            </Modal>
        </>
    );
};

export default BarraCerca;
