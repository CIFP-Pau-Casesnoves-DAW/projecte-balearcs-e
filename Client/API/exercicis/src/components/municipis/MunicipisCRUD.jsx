import SelectIlles from "./SelectIlles";
import { Form, Button, Alert, Toast, Spinner} from "react-bootstrap";
import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { storage } from '../../utils/storage';

export default function MunicipisCRUD(props) {
    const [nom, setNom] = useState("");
    const [illa_id, setIlla_id] = useState(null);
    const [error, setError] = useState('');
    const [edita, setEdita] = useState(false);
    const navigate=useNavigate();
    const { id } = useParams();
    const [descarregant, setDescarregant] = useState(false);
    const [illa_actual, setIlla_actual] = useState("");
    const token = props.api_token;

    useEffect(() => {
        if (id !== "-1") {
            descarrega();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarrega=async ()=>{
        setDescarregant(true);
        setEdita(true);
        try {
            const resposta = await fetch(`http://balearc.aurorakachau.com/public/api/municipis/${id}`,{
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const jsonresposta = await resposta.json();
            setNom(jsonresposta.data.nom);
            setIlla_id(jsonresposta.data.illa_id);

            const respostaIlles = await fetch(`http://balearc.aurorakachau.com/public/api/illes/${jsonresposta.data.illa_id}`,{
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            })
            const jsonrespostaIlles = await respostaIlles.json();
            setIlla_actual(jsonrespostaIlles.data.nom);
        } catch (error) {
            console.log(error);
        }
        setDescarregant(false);
    }

    const guardaMunicipi=()=>{
        if (edita) {
            modificaMunicipi();
        } else {
            setError('Error en la edició');
        }
    }

    const modificaMunicipi=()=>{
        fetch(`http://balearc.aurorakachau.com/public/api/municipis/${id}`,{
            method:'PUT',
            headers:{
                'Content-Type':'application/json',
                'Authorization':`Bearer ${token}`
            },
            body:JSON.stringify({
                nom:nom,
                illa_id:illa_id
            })
        }).then(response=>response.json())
        .then((data)=>{
            if (data.error) {
                setError("Error: "+getMsgError(data.error));
            } else {
                setError('');
                navigate('/municipis');
            }
        })
    }

    const esborraMunicipi=()=>{
        fetch(`http://balearc.aurorakachau.com/public/api/municipis/${id}`,{
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        }).then(response=>{
            if (response.error===200) {
                setError("Error: "+response.status);
            } else {
                navigate('/municipis');
            }
        })
        .catch((error)=>{
            setError("Error: "+error);
        })
    }

    const getMsgError=(llistaErrors)=>{
        let msg=''
        for (let clau in llistaErrors) {
           msg=msg+llistaErrors[clau]+'. ';
        }
        return msg;
    }

    if (descarregant) { return <Spinner /> }

    return (
        <div>
            <Form>
                {edita &&
                    <Form.Group className="mb-3">
                        <Form.Label>Id</Form.Label>
                        <Form.Control type="text" name="id" value={id} disabled />
                    </Form.Group>
                }
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
                    <Form.Label>Illa actual: <strong>{illa_actual}</strong></Form.Label>
                    <SelectIlles id={illa_id} onChange={(e) => { setIlla_id(e.target.value) }} />
                </Form.Group>
                <Button variant="primary" type="button" onClick={guardaMunicipi}>
                    {edita ? "Guarda" : "Crea"}
                </Button>
                &nbsp;&nbsp;
                <Button variant="warning" type="button" onClick={() => navigate("/municipis")}>
                    Cancel·la
                </Button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                {edita &&
                    <Button variant="danger" type="button" onClick={esborraMunicipi}>
                        Esborra
                    </Button>
                }
            </Form>
            <br />
            {error !== '' && <Alert variant="danger">{error}</Alert>}
        </div>
    );
    }