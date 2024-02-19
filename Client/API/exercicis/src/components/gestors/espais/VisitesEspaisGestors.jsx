import React, { useState, useEffect } from "react";
import { Spinner } from 'react-bootstrap';
import { useNavigate } from "react-router-dom";
import { AgGridReact } from 'ag-grid-react';
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-quartz.css";

export default function VisitesEspaisGestors(props) {
    const [visites, setVisites] = useState([]);
    const [visitesEspai, setVisitesEspai] = useState([]);
    const [loading, setLoading] = useState(true);
    const espaiId = props.espai_id;
    const token = props.api_token;
    const navigate = useNavigate();
    const [columns, setColumns] = useState([
        { field: "titol", headerName: "Títol", width: 200, sortable: true, filter: true },
        { field: "descripcio", headerName: "Descripció", width: 600, sortable: true, filter: true },
        { field: "data_inici", headerName: "Data d'inici", width: 150 },
        { field: "data_fi", headerName: "Data de fi", width: 150 },
    ]);

    useEffect(() => {
        descarregaVisites();
    }, []);

    const descarregaVisites = async () => {
        try {
            const response = await fetch('http://balearc.aurorakachau.com/public/api/visites',{
                method: 'GET',
                headers: {
                    'Content-Type': 'application',
                    'Authorization': `Bearer ${token}`
                }
            });
            const data = await response.json();
            setVisites(data.data);
        } catch (error) {
            console.error('Error en descarregar les visites:', error);
        }
        setLoading(false);
    };

    useEffect(() => {
        if (visites.length > 0) {
            const filteredVisites = visites.filter(visita => visita.espai_id === parseInt(espaiId));
            setVisitesEspai(filteredVisites);
        }
    }, [visites, espaiId]);

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
                        rowData={visitesEspai}
                        columnDefs={columns}
                        pagination={true}
                        paginationPageSize={9}
                        onRowClicked={(row) => {
                            navigate(`/espaisgestors/${espaiId}/visitesgestors/${row.data.id}`);
                        }}
                    />
                </div>
                <br />
            </>
        );
    }
}
