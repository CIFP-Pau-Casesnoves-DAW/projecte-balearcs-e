import React, { useState, useEffect } from 'react';
import { Row, Col, Spinner, Button } from 'react-bootstrap';
import { AgGridReact } from 'ag-grid-react';
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-quartz.css';
import { useNavigate } from 'react-router-dom';

export default function Arquitectes(props) {
    const [arquitectes, setArquitectes] = useState([]);
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();
    const token = props.api_token;
    const [columnes, setColumnes] = useState([
        { field: 'id', headerName: 'Codi', width: 100 },
        { field: 'nom', headerName: 'Nom', width: 200, sortable: true, filter: true },
        { field: 'created_at', headerName: 'Creat a', width: 200, sortable: true, filter: true },
        { field: 'updated_at', headerName: 'Actualitzat a', width: 200, sortable: true, filter: true },
    ]);

    useEffect(() => {
        descarregaArquitectes();
    }, []);

    const descarregaArquitectes = async () => {
        try {
            const response = await fetch('http://balearc.aurorakachau.com/public/api/arquitectes', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            setArquitectes(responseData.data);
        } catch (error) {
            console.log(error);
        }
        setLoading(false);
    };

    if (loading) {
        return (
            <div>
                <h1>Arquitectes</h1>
                <Spinner />
            </div>
        );
    } else {
        return (
            <>
                <hr />
                <Row md={9}>
                    <Col>
                        <h2>Llista d' <b>Arquitectes</b></h2>
                    </Col>
                    <Col style={{textAlign:"right"}}>
                        <Button
                            variant="success"
                            type="button"
                            onClick={() => {
                                navigate("/arquitectes/afegir");
                            }}
                        >
                            Afegir arquitecte
                        </Button>
                    </Col>
                </Row>
                <br />
                <div className="ag-theme-quartz" style={{ height: 550, width: '100%' }}>
                    <AgGridReact
                        rowData={arquitectes}
                        columnDefs={columnes}
                        pagination={true}
                        paginationPageSize={9}
                        onRowClicked={(e) => {
                            navigate("/arquitectes/" + e.data.id);
                        }}
                    />  
                </div>
            </>
        );
    }
}
