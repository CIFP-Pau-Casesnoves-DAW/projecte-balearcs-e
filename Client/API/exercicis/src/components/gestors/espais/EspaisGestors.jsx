import React, { useState, useEffect } from "react";
import { Row, Col, Spinner, Button } from 'react-bootstrap';
import { useNavigate } from "react-router-dom";
import { AgGridReact } from 'ag-grid-react';
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-quartz.css";

export default function EspaisGestors(props){
    const [espais, setEspais] = useState([]);
    const [espaisgestor, setEspaisGestor] = useState([]);
    const gestorid = props.usuari_id;
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();
    const [columnes, setColumnes] = useState([
        {field: "nom", headerName: "Nom", width: 200, sortable: true, filter: true},
        {field: "descripcio", headerName: "Descripció", width: 300},
        {field: "carrer", headerName: "Carrer", width: 150},
        {field: "numero", headerName: "Número", width: 100},
        {field: "pis_porta", headerName: "Pis / Porta", width: 100},
        {field: "web", headerName: "Web", width: 200},
        {field: "mail", headerName: "Mail", width: 200},
        {field: "grau_acc", headerName: "Grau d'accessibilitat", width: 150},
        {field: "created_at", headerName: "Data creació", width: 150},
    ]);

    useEffect(() => {
        descarregaEspais();
    }, []);
    //Descarregam tots els espais dins espai
    const descarregaEspais = async () => {
        try {
            const response = await fetch('http://balearc.aurorakachau.com/public/api/espais');
            const data = await response.json();
            // TOTS els espais els tenim dins variable espais
            setEspais(data.data);
        } catch (error) {
            console.error('Error en descarregar els espais:', error);
        }
        setLoading(false);
    }

    //Posam dins la variable espaisgestor aquells espais que tenguin com a gestor_id l'id del usuari actual
    useEffect(() => {
        if (espais.length > 0) {
            setEspaisGestor(espais.filter(espai => espai.gestor_id === gestorid));
        }
    }, [espais]);
    if (loading) {
        return (
            <div>
                <hr />
                <h2>Llista dels vostres <b>Espais</b></h2>
                <Spinner animation="border" variant="primary" />
                <hr />
            </div>
        );
    } else {
        return (
            <>
                <hr />
                <Row md={9}>
                    <Col>
                        <h2>Llista dels vostres <b>Espais</b></h2>
                    </Col>
                </Row>
                <hr />
                <div className="ag-theme-quartz" style={{ height: 400, width: '100%' }}>
                    <AgGridReact
                        rowData={espaisgestor}
                        columnDefs={columnes}
                        pagination={true}
                        paginationPageSize={10}
                        onRowClicked={(row) => {
                            navigate(`/espaisgestors/${row.data.id}`);
                        }}
                    />
                </div>
            </>
        );
    }
}