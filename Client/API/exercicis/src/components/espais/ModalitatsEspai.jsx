import React, { useState, useEffect } from "react";
import { Spinner, Modal, Button } from 'react-bootstrap';
import { AgGridReact } from 'ag-grid-react';
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-quartz.css";

const ModalitatsEspai = ({ id, api_token }) => {
    const [modalitatsEspai, setModalitatsEspai] = useState([]);
    const [loading, setLoading] = useState(true);
    const [showConfirmationModal, setShowConfirmationModal] = useState(false);
    const [selectedModalitat, setSelectedModalitat] = useState(null);
    const token = api_token;
    const idespai = id;

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            const espaisModalitatsResponse = await fetch('http://balearc.aurorakachau.com/public/api/espais_modalitats', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const espaisModalitatsData = await espaisModalitatsResponse.json();

            const modalitatsResponse = await fetch('http://balearc.aurorakachau.com/public/api/modalitats', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const modalitatsData = await modalitatsResponse.json();

            const modalitatsIds = espaisModalitatsData.data
                .filter(item => item.espai_id === parseInt(id))
                .map(item => item.modalitat_id);

            const modalitats = modalitatsData.data.filter(item => modalitatsIds.includes(item.id));

            setModalitatsEspai(modalitats.map((modalitat, index) => ({ id: index + 1, nom_modalitat: modalitat.nom_modalitat })));
            setLoading(false);
        } catch (error) {
            console.error('Error fetching data:', error);
            setLoading(false);
        }
    };

    const handleRowClicked = (event) => {
        setSelectedModalitat(event.data.id);
        setShowConfirmationModal(true);
    };

    const handleDeleteConfirmation = async () => {
        setShowConfirmationModal(false);
        if (selectedModalitat) {
            try {
                await fetch(`http://balearc.aurorakachau.com/public/api/espais_modalitats/${idespai}/${selectedModalitat}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });
                // Actualitzar l'estat o recarregar dades si cal
                fetchData();
                console.log(`Modalitat amb ID ${selectedModalitat} eliminada amb èxit de l'espai amb ID ${idespai}`);
            } catch (error) {
                console.error('Error al eliminar la modalitat de l\'espai:', error);
            }
        }
    };

    if (loading) {
        return (
            <div>
                <Spinner animation="border" variant="primary" />
            </div>
        );
    } else {
        const columns = [
            { field: "nom_modalitat", headerName: "Nom Modalitat", width: 200 },
        ];

        return (
            <>
                <br />
                <div className="ag-theme-quartz" style={{ height: 550, width: '100%' }}>
                    <AgGridReact
                        rowData={modalitatsEspai}
                        columnDefs={columns}
                        pagination={true}
                        paginationPageSize={9}
                        onRowClicked={handleRowClicked}
                    />
                </div>
                <Modal show={showConfirmationModal} onHide={() => setShowConfirmationModal(false)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Confirmació d'eliminació</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        Estàs segur que vols eliminar aquesta modalitat?
                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="secondary" onClick={() => setShowConfirmationModal(false)}>
                            Cancel·lar
                        </Button>
                        <Button variant="primary" onClick={handleDeleteConfirmation}>
                            Sí
                        </Button>
                    </Modal.Footer>
                </Modal>
                <br />
            </>
        );
    }
}

export default ModalitatsEspai;
