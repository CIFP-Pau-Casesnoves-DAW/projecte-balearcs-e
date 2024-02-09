import React, { useState, useEffect } from "react";
import { Row, Col, Spinner, Button } from 'react-bootstrap';
import { AgGridReact } from 'ag-grid-react'; // React Grid Logic
import "ag-grid-community/styles/ag-grid.css"; // Core CSS
import "ag-grid-community/styles/ag-theme-quartz.css"; // Theme
import { useNavigate } from "react-router-dom";

export default function Tipus(props) {
    const [tipus, setTipus] = useState([]);
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();
    const token = props.api_token;
    const [columnes, setColumnes] = useState([
        { field: "id", headerName: "Codi", width: 100 },
        { field: "nom_tipus", headerName: "Tipus", width: 200, sortable: true, filter: true },
    ]);

    useEffect(() => {
        descargaTipus();
    }, []);

    const descargaTipus = async () => {
        try {
            const resposta = await fetch('http://balearc.aurorakachau.com/public/api/tipus', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });            

            const jsonresposta = await resposta.json();
            setTipus(jsonresposta.data);
        } catch (error) {
            console.log(error);
        }
        setLoading(false);
    }

    if (loading) {
        return (
            <div>
                <h1>Tipus</h1>
                <Spinner />
            </div>
        );
    } else {
        return (
            <>
                <hr />
                <Row md={4}>
                    <Col>
                        <h4>Llista de Tipus</h4>
                    </Col>
                    <Col>
                        <Button
                            variant="warning"
                            type="button"
                            onClick={() => {
                                navigate("/tipus/afegir");
                            }}
                        >Afegir tipus
                        </Button>
                    </Col>
                </Row>
                <br />
                <div className="ag-theme-quartz" style={{ height: 550, width: '100%' }}>
                    <AgGridReact
                        rowData={tipus}
                        columnDefs={columnes}
                        pagination={true}
                        paginationPageSize={9}
                        onRowClicked={(e) => {
                            navigate("/tipus/" + e.data.id);
                        }}
                    />  
                </div>
            </>
        );
    }
}
