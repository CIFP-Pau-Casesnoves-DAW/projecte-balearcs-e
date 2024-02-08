import React, { useState, useEffect, Fragment } from "react";
import { ListGroup, Row, Col, Spinner, Button } from 'react-bootstrap';
import { useNavigate } from "react-router-dom";
import { AgGridReact } from 'ag-grid-react'; // React Grid Logic
import "ag-grid-community/styles/ag-grid.css"; // Core CSS
import "ag-grid-community/styles/ag-theme-quartz.css"; // Theme
import { storage } from '../../utils/storage';

export default function MunicipisTable() {
    const [municipis, setMunicipis] = useState([]);
    const [descarregant, setDescarregant] = useState(true);
    const navigate = useNavigate();
    const token = storage.get('api_token');
    const [columnes, setColumnes] = useState([
        {field: "id", headerName: "Codi", width: 100},
        {field: "nom", headerName: "Municipi", width: 200, sortable: true, filter: true},
    ]);

    useEffect(() => { descarrega() }, []);
    // Exemple de ftech amb async/await
    const descarrega = async () => {
        try {
            const resposta = await fetch('http://balearc.aurorakachau.com/public/api/municipis', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });            const jsonresposta = await resposta.json();
            setMunicipis(jsonresposta.data);
        } catch (error) {
            console.log(error);
        }
        setDescarregant(false);
    }

    if (descarregant) {
        return (
            <div>
                <h1>Municipis</h1>
                <Spinner />
            </div>
        );
    }
    else {
        return (
            <>
                <hr />
                <Row md={4}>
                    <Col>
                        <h4>Llista de Municipis</h4>
                    </Col>
                    <Col>
                        <Button
                            variant="warning"
                            type="button"
                            onClick={() => {
                                navigate("/municipis/afegir");
                            }}
                        >
                            +
                        </Button>
                    </Col>
                </Row>
                <br />
                <div className="ag-theme-quartz" style={{ height: 550, width: '100%' }}>
                    <AgGridReact
                        rowData={municipis}
                        columnDefs={columnes}
                        pagination={true}
                        paginationPageSize={9}
                        onRowClicked={(e) => {
                            navigate("/municipis/" + e.data.id);
                        }}
                    />  
                </div>
            </>
        );
    }

}    