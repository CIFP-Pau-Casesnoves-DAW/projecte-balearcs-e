import React, { useState, useEffect } from 'react';
import { Modal, Button, Card } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';

export default function ModalContacte({ isOpen, onClose }) {
    const [showModal, setShowModal] = useState(isOpen);
    const [nom, setNom] = useState('');
    const [llinatges, setLlinatges] = useState('');
    const [mail, setMail] = useState('');
    const [missatge, setMissatge] = useState('');
    const [error, setError] = useState('');
    const navigate = useNavigate();

    const enviaMissatge = () => {
        if (
            nom.trim() === '' || llinatges.trim() === '' || mail.trim() === '' ||
            missatge.trim() === ''
        ) {
            setError('Tots els camps són obligatoris.');
            return;
        }        

        fetch('http://balearc.aurorakachau.com/public/api/missatges', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nom: nom,
                llinatges: llinatges,
                mail: mail,
                missatge: missatge
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError('Error en guardar la visita.');
            } else {
                setError('');
                console.log(nom, llinatges, mail, missatge);
                // navigate('/inici');
                handleClose();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError('Error en guardar la visita.');
        });
    };

    useEffect(() => {
        setShowModal(isOpen);
    }, [isOpen]);

    const handleClose = () => {
        setShowModal(false);
        if (onClose) onClose();
    };

    // const handleSubmit = (event) => {
    //     event.preventDefault();
    //     console.log("Formulari enviat");
    //     handleClose();
    // };

    const modalStyle = {
        backgroundColor: 'whitesmoke', // Fons blanc per al modal
        borderRadius: '15px', // Racons arrodonits
        padding: '20px', // Espaiat intern
        maxWidth: '500px', // Amplada màxima del modal
        width: '100%', // Ajusta la amplada al contenidor
        boxShadow: '0 4px 8px rgba(0, 0, 0, 0.1)' // Ombra lleugera per aprofunditat
    };

    const formStyle = {
        display: 'flex', // Disposa els elements del formulari en una columna
        flexDirection: 'column', // Orientació vertical
        gap: '10px' // Espai entre elements del formulari
    };

    const textAreaStyle = {
        minHeight: '150px', // Altura mínima per a l'àrea de text
        resize: 'vertical' // Permet redimensionar verticalment

    };

    return (
        <Modal show={showModal} onHide={handleClose} centered>
            <Card style={modalStyle}>
                <Card.Header style={{ textAlign: 'center', color: 'darkslategray' }}>
                    <Card.Title>Formulari de contacte</Card.Title>
                </Card.Header>
                <Card.Body>
                    <form style={formStyle}>
                        <input type="text" placeholder="Nom" required style={{ padding: '10px' }} onChange={(e) => setNom(e.target.value)} />
                        <input type="text" placeholder="Llinatges" required style={{ padding: '10px' }} onChange={(e) => setLlinatges(e.target.value)} />
                        <input type="email" placeholder="Mail" required style={{ padding: '10px' }} onChange={(e) => setMail(e.target.value)} />
                        <textarea placeholder="Escriu el teu missatge aquí" required style={textAreaStyle} onChange={(e) => setMissatge(e.target.value)}></textarea>
                        <Button variant="primary" type="button" style={{ padding: '10px 20px' }} onClick={enviaMissatge}>Envia</Button>
                    </form>
                </Card.Body>
                <Card.Footer style={{ display: 'flex', justifyContent: 'flex-end' }}>
                    <Button variant="secondary" onClick={handleClose} style={{ marginLeft: 'auto' }}>Tanca</Button>
                </Card.Footer>

            </Card>
        </Modal>
    );
}