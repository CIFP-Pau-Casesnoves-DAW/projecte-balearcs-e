import React, { useState, useEffect } from "react";
import { ListGroup, Row, Col, Spinner, Button } from 'react-bootstrap';
import { useNavigate } from "react-router-dom";
import { AgGridReact } from 'ag-grid-react';
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-quartz.css";

export default function PuntsInteres() {
    const [puntsInteres, setPuntsInteres] = useState([]);
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();
    const [columnes, setColumnes] = useState([
        {field: "id", headerName: "Codi", width: 100},
        {field: "titol", headerName: "Títol", width: 200, sortable: true, filter: true},
        {field: "descripcio", headerName: "Descripció", width: 600, sortable: true, filter: true},
        { field: "espai_id", headerName: "Espai ID", width: 150 }, 
        { field: "data_baixa", headerName: "Data de baixa", width: 150 },
        { field: "created_at", headerName: "Data de creació", width: 150 },
    ]);

    useEffect(() => {
        descarregaPuntsInteres();
    }, []);

    const descarregaPuntsInteres = async () => {
        try {
             const response = await fetch('http://balearc.aurorakachau.com/public/api/punts_interes');
            const data = await response.json();
            setPuntsInteres(data.data);
        } catch (error) {
            console.error('Error en descarregar els punts d\'interès:', error);
        }
        setLoading(false);
    };

    if (loading) {
        return (
            <div>
                <h1>Punts d'interès</h1>
                <Spinner animation="border" variant="primary" />
            </div>
        );
    } else {
        return (
            <>
                <hr />
                <Row md={9}>
                    <Col>
                        <h2>Llista de <b>Punts d'interès</b></h2>
                    </Col>
                    <Col style={{textAlign:"right"}}>
                        <Button
                        variant="success"
                            type="button"
                            onClick={() => {
                                navigate("/puntsinteres/afegir");
                            }}
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-fill-add" viewBox="0 0 16 16">
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1"/>
                        <path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12 12 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7m6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.55 4.55 0 0 1 .23-2.002m-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-1.3-1.905"/>
                        </svg> Afegir punt d'interès
                        </Button>
                    </Col>
                </Row>
                <br />
                <div className="ag-theme-quartz" style={{ height: 550, width: '100%' }}>
                    <AgGridReact
                        rowData={puntsInteres}
                        columnDefs={columnes}
                        pagination={true}
                        paginationPageSize={9}
                        onRowClicked={(row) => {
                            navigate(`/puntsinteres/${row.data.id}`);
                        }}
                    >
                    </AgGridReact>
                </div>
            </>
        );
    }
}
