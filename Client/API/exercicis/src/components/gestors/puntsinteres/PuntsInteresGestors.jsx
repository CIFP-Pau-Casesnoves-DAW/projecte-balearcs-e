import React, { useState, useEffect } from "react";
import { ListGroup, Row, Col, Spinner, Button } from 'react-bootstrap';
import { useNavigate } from "react-router-dom";
import { AgGridReact } from 'ag-grid-react';
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-quartz.css";

export default function PuntsInteresGestors(props) {
    const [puntsInteres, setPuntsInteres] = useState([]);
    const [puntsInteresEspai, setPuntsInteresEspai] = useState([]);
    const [loading, setLoading] = useState(true);
    const espaiid = props.espai_id;
    const navigate = useNavigate();
    const [columnes, setColumnes] = useState([
        {field: "titol", headerName: "Títol", width: 200, sortable: true, filter: true},
        {field: "descripcio", headerName: "Descripció", width: 600, sortable: true, filter: true},
        { field: "data_baixa", headerName: "Data de baixa", width: 150 },
        { field: "created_at", headerName: "Data de creació", width: 150 },
    ]);

    useEffect(() => {
        descarregaPuntsInteres();
    }, []);

    //Descarregam tots els punts d'interes
    const descarregaPuntsInteres = async () => {
        try {
             const response = await fetch('http://balearc.aurorakachau.com/public/api/punts_interes');
            const data = await response.json();
            // Tenim TOTS els punts d'interes dins puntsinteres
            setPuntsInteres(data.data);
        } catch (error) {
            console.error('Error en descarregar els punts d\'interès:', error);
        }
        setLoading(false);
    };

    useEffect(() => {
        if (puntsInteres.length > 0) {
            const filteredPuntsInteres = puntsInteres.filter(punt => punt.espai_id === parseInt(espaiid));
            setPuntsInteresEspai(filteredPuntsInteres);
        }
    }, [puntsInteres, espaiid]);

    if (loading) {
        return (
            <div>
                <Spinner animation="border" variant="primary" />
            </div>
        );
    } else {
        return (
            <>
                <br />
                <div className="ag-theme-quartz" style={{ height: 550, width: '100%' }}>
                    <AgGridReact
                        rowData={puntsInteresEspai}
                        columnDefs={columnes}
                        pagination={true}
                        paginationPageSize={9}
                        onRowClicked={(row) => {
                            navigate(`/espaisgestors/${espaiid}/puntsinteresgestors/${row.data.id}`);
                        }}
                    >
                    </AgGridReact>
                </div>
                <br />
            </>
        );
    }
}