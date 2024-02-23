import SelectIlles from "./SelectIlles";
import { Form, Button, Alert, Toast} from "react-bootstrap";
import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { storage } from '../../utils/storage';

export default function MunicipisAfegeix(props) {
    const [nom, setNom] = useState("");
    const [illa_id, setIlla_id] = useState("");
    const [error, setError] = useState('');
    const navigate=useNavigate();
    const token = props.api_token;

    const guardaMunicipi=()=>{
        if(nom.trim() === '' || illa_id.trim() === '' || illa_id === "-1"){
            setError("Tots els camps són obligatoris.");
            return;
        }

        fetch('http://balearc.aurorakachau.com/public/api/municipis',{
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'Authorization': `Bearer ${token}`
            },
            body:JSON.stringify({
                nom:nom,
                illa_id:illa_id
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                setError("Error al guardar el municipi.");
            } else {
                setError('');
                navigate('/municipis');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setError("Error al guardar el comentari.");
        });
    }
    console.log(nom);
console.log(illa_id);
    return (
        <div>
            <hr />
            <h1>Afegir Municipi</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Municipi</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom del municipi"
                        name="municipi"
                        value={nom}
                        onChange={(e) => setNom(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Illa:</Form.Label>
                    <SelectIlles id={illa_id} onChange={(e) => { setIlla_id(e.target.value) }} />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaMunicipi}>
                    Guarda
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/municipis")}>
                    Cancel·la
                </Button>
            </Form>
            <br/>
            {error!=='' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
    }