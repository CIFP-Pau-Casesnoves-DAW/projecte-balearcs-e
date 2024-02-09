import React, { useState, useEffect } from "react";
import { Row, Col, Spinner, Button } from 'react-bootstrap';
import { AgGridReact, AgGridColumn } from 'ag-grid-react'; // React Grid Logic
import "ag-grid-community/styles/ag-grid.css"; // Core CSS
import "ag-grid-community/styles/ag-theme-quartz.css"; // Theme
import { useNavigate } from "react-router-dom";

export default function Idiomes(props) {
    const [idiomes, setIdiomes] = useState([]);
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();
    const token = props.api_token;
    const [columnes, setColumnes] = useState([
        {field: "id", headerName: "Codi", width: 100},
        {field: "idioma", headerName: "Idioma", width: 200, sortable: true, filter: true},
    ]);

    useEffect(() => {
        descarregaIdiomes();
    }, []);

    const descarregaIdiomes = async () => {
        try {
            const response = await fetch('http://balearc.aurorakachau.com/public/api/idiomes', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });            

            const responseData = await response.json();
            setIdiomes(responseData.data);
        } catch (error) {
            console.log(error);
        }
        setLoading(false);
    }

    if (loading) {
        return (
            <div>
                <h1>Idiomes</h1>
                <Spinner />
            </div>
        );
    } else {
        return (
            <>
                <hr />
                <Row md={4}>
                    <Col>
                        <h4>Llista d'Idiomes</h4>
                    </Col>
                    <Col>
                        <Button
                            variant="warning"
                            type="button"
                            onClick={() => {
                                navigate("/idiomes/afegir");
                            }}
                        >Afegeix idioma
                        </Button>
                    </Col>
                </Row>
                <br />
                <div className="ag-theme-quartz" style={{ height: 550, width: '100%' }}>
                    <AgGridReact
                        rowData={idiomes}
                        columnDefs={columnes}
                        pagination={true}
                        paginationPageSize={9}
                        onRowClicked={(e) => {
                            navigate("/idiomes/" + e.data.id);
                        }}
                    >  
                        <AgGridColumn field="id" headerName="Codi" width={100}></AgGridColumn>
                        <AgGridColumn field="idioma" headerName="Idioma" width={200} sortable={true} filter={true}></AgGridColumn>
                    </AgGridReact>
                </div>
            </>
        );
    }
}
