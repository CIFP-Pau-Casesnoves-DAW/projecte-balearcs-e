import React, { useState, useEffect } from 'react';
import { Modal, Button, Card } from 'react-bootstrap';

export default function ModalContacte({ isOpen, onClose }) {
    const [showModal, setShowModal] = useState(isOpen);

    useEffect(() => {
        setShowModal(isOpen);
    }, [isOpen]);

    const handleClose = () => {
        setShowModal(false);
        if(onClose) onClose();
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        console.log("Formulari enviat");
        handleClose();
    };

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
                    <Card.Title>Contacte</Card.Title>
                </Card.Header>
                <Card.Body>
                    <form onSubmit={handleSubmit} style={formStyle}>
                        <input type="text" placeholder="Nom" required style={{ padding: '10px' }} />
                        <input type="text" placeholder="Llinatges" required style={{ padding: '10px' }} />
                        <input type="email" placeholder="Correu electrònic" required style={{ padding: '10px' }} />
                        <textarea placeholder="Escriu el teu missatge aquí" required style={textAreaStyle}></textarea>
                        <Button variant="primary" type="submit" style={{ padding: '10px 20px' }}>Envia</Button>
                    </form>
                </Card.Body>
                <Card.Footer style={{ display: 'flex', justifyContent: 'flex-end' }}>
                    <Button variant="secondary" onClick={handleClose} style={{ marginLeft: 'auto' }}>Tanca</Button>
                </Card.Footer>

            </Card>
        </Modal>
    );
}
