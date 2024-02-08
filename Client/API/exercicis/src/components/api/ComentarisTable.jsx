import React, { useState, useEffect } from "react";
import { ListGroup, Row, Col, Spinner, Button } from 'react-bootstrap';
import { useNavigate } from "react-router-dom";
import { AgGridReact } from 'ag-grid-react';
// import { AgGridColumn } from 'ag-grid-react';
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-quartz.css";

export default function ComentarisTable() {
    const [comentaris, setComentaris] = useState([]);
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();
    const [columnes, setColumnes] = useState([
        {field: "id", headerName: "Codi", width: 100},
        {field: "comentari", headerName: "Comentari", width: 600, sortable: true, filter: true},
        { field: "data", headerName: "Data update", width: 150 },
        { field: "validat", headerName: "Validat", width: 80 },
        { field: "created_at", headerName: "Data creació", width: 150 },
    ]);

    useEffect(() => {
        descarregaComentaris();
    }, []);

    const descarregaComentaris = async () => {
        try {
             const response = await fetch('http://balearc.aurorakachau.com/public/api/comentaris');
            const data = await response.json();
            setComentaris(data.data);
        } catch (error) {
            console.error('Error en descarregar els comentaris:', error);
        }
        setLoading(false);
    };

    if (loading) {
        return (
            <div>
                <h1>Comentaris</h1>
                <Spinner animation="border" variant="primary" />
            </div>
        );
    } else {
        return (
            <>
                <hr />
                <Row md={4}>
                    <Col>
                        <h4>Llista de Comentaris</h4>
                    </Col>
                    <Col>
                        <Button
                            variant="warning"
                            type="button"
                            onClick={() => {
                                navigate("/comentaris/afegir");
                            }}
                        >
                            +
                        </Button>
                    </Col>
                </Row>
                <br />
                <div className="ag-theme-quartz" style={{ height: 550, width: '100%' }}>
                    <AgGridReact
                        rowData={comentaris}
                        columnDefs={columnes}
                        pagination={true}
                        paginationPageSize={9}
                        onRowClicked={(row) => {
                            navigate(`/comentaris/${row.data.id}`);
                        }}
                    >
                        {/* <AgGridColumn field="id" headerName="ID" width={100} />
                        <AgGridColumn field="comentari" headerName="Comentari" width={300} />
                        <AgGridColumn field="data" headerName="Data" width={200} /> */}
                    </AgGridReact>
                </div>
            </>
        );
    }
}
