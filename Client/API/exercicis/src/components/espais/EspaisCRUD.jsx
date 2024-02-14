import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { Form, Button, Spinner } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import { Alert } from 'react-bootstrap';
import ModalitatsSelect from "./ModalitatsSelect";

export default function EspaisCRUD(props){
    const [nom, setNom] = useState('');
    const [descripcio, setDescripcio] = useState('');
    const [anyCons, setAnyCons] = useState('');
    const [web, setWeb] = useState('');
    const [mail, setMail] = useState('');
    const [arquitecteId, setArquitecteId] = useState(''); 
    const [gestorId, setGestorId] = useState(''); 
    const [arquitectes, setArquitectes] = useState([]);
    const [gestors, setGestors] = useState([]);
    const [carrer, setCarrer] = useState('');
    const [pis_porta, setPisPorta] = useState('');
    const [numero, setNumero] = useState('');
    const [grauAcc, setGrauAcc] = useState('');
    const [tipusId, setTipusId] = useState('');
    const [municipiId, setMunicipiId] = useState('');
    const [tipus, setTipus] = useState([]);
    const [municipis, setMunicipis] = useState([]);
    const [destacat, setDestacat] = useState('');
    const [selectedTipusId, setSelectedTipusId] = useState('');
    const [error, setError] = useState('');
    const navigate = useNavigate();
    const [edita, setEdita] = useState(false);
    const { id } = useParams();
    const [descarregant, setDescarregant] = useState(false);
    const token = props.api_token;

    useEffect(() => {
        if (id !== "-1") {
            descarregaEspai();
        } else {
            setEdita(false);
        }
    }, [id]);

    const descarregaEspai = async () => {
        setDescarregant(true);
        setEdita(true);
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/espais/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            setNom(responseData.data.nom);
            setDescripcio(responseData.data.descripcio);
            setAnyCons(responseData.data.any_cons);
            setWeb(responseData.data.web);
            setMail(responseData.data.mail);
            setArquitecteId(responseData.data.arquitecte_id);
            setGestorId(responseData.data.gestor_id);
            setCarrer(responseData.data.carrer);
            setPisPorta(responseData.data.pis_porta);
            setNumero(responseData.data.numero);
            setGrauAcc(responseData.data.grau_acc);
            setTipusId(responseData.data.tipus_id);
            setMunicipiId(responseData.data.municipi_id);
            setDestacat(responseData.data.destacat);
        } catch (error) {
            console.log(error);
        }
        setDescarregant(false);
    }

    const guardaEspai = () => {
        if (edita) {
            modificaEspai();
        } else {
            setError("Error amb la edició.");
        }
    }

    const modificaEspai = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/espais/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify({
                nom: nom,
                descripcio: descripcio,
                any_cons: anyCons,
                web: web,
                mail: mail,
                arquitecte_id: arquitecteId,
                gestor_id: gestorId,
                carrer: carrer,
                pis_porta: pis_porta,
                numero: numero,
                grauAcc: grauAcc,
                tipus_id: selectedTipusId,
                municipi_id: municipiId,
                destacat: destacat
            })
        }).then(response => response.json())
            .then((data) => {
                if (data.error) {
                    setError("Error al modificar l'espai.");
                } else {
                    setError('');
                    navigate('/espais');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error al modificar l'espai.");
            });
    }

    const esborraEspai = () => {
        fetch(`http://balearc.aurorakachau.com/public/api/espais/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        }).then(response => response.json())
            .then(data => {
                if (data.error) {
                    setError("Error al eliminar l'espai.");
                } else {
                    navigate('/espais');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                setError("Error al eliminar l'espai.");
            });
    }

    useEffect(() => {
        descarregaArquitectes();
        descarregaGestors();
        descarregaMunicipis();
        descarregaTipus();
        descarregatipusActual();
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
    }

    const descarregaGestors = async () => {
        try {
            const response = await fetch('http://balearc.aurorakachau.com/public/api/usuaris', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            setGestors(responseData.data);
        } catch (error) {
            console.log(error);
        }
    }

    const descarregaMunicipis = async () => {
        try {
            const response = await fetch('http://balearc.aurorakachau.com/public/api/municipis', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            setMunicipis(responseData.data);
        } catch (error) {
            console.log(error);
        }
    }

    const descarregaTipus = async () => {
        try {
            const response = await fetch('http://balearc.aurorakachau.com/public/api/tipus', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            setTipus(responseData.data);
        } catch (error) {
            console.log(error);
        }
    }

    const descarregatipusActual = async () => {
        try {
            const response = await fetch(`http://balearc.aurorakachau.com/public/api/espais/${id}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
            const responseData = await response.json();
            setSelectedTipusId(responseData.data.tipus_id);
        } catch (error) {
            console.log(error);
        }
        
    }

    if (descarregant) {
        return <Spinner />
    }

    return (
        <div>
            <hr />
            <h1>Editar Espai</h1>
            <hr />
            <Form>
                <Form.Group className="mb-3">
                    <Form.Label>Nom:</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Nom de l'espai"
                        name="nom"
                        value={nom}
                        onChange={(e) => setNom(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Descripció:</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Descripció de l'espai"
                        name="descripcio"
                        value={descripcio}
                        onChange={(e) => setDescripcio(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Any de construcció:</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Any de construcció de l'espai"
                        name="anyCons"
                        value={anyCons}
                        onChange={(e) => setAnyCons(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Web:</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Web de l'espai"
                        name="web"
                        value={web}
                        onChange={(e) => setWeb(e.target.value)}
                    />
                </Form.Group>
                <Form.Group className="mb-3">
                    <Form.Label>Mail:</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Mail de l'espai"
                        name="mail"
                        value={mail}
                        onChange={(e) => setMail(e.target.value)}
                    />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Carrer:</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Carrer de l'espai"
                        name="carrer"
                        value={carrer}
                        onChange={(e) => setCarrer(e.target.value)}
                    />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Pis/Porta:</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Pis/Porta de l'espai"
                        name="pis_porta"
                        value={pis_porta}
                        onChange={(e) => setPisPorta(e.target.value)}
                    />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Número:</Form.Label>
                    <Form.Control
                        type="text"
                        placeholder="Número de l'espai"
                        name="numero"
                        value={numero}
                        onChange={(e) => setNumero(e.target.value)}
                    />
                </Form.Group>


                <Form.Group className="mb-3">
                    <Form.Label>Grau d'accessibilitat:</Form.Label>
                    <Form.Control
                        as="select"
                        name="grauAcc"
                        value={grauAcc}
                        onChange={(e) => setGrauAcc(e.target.value)}
                    >
                        <option value="-1">Selecciona un grau d'accessibilitat</option>
                        <option value="alt">Alt</option>
                        <option value="mig">Mitja</option>
                        <option value="baix">Baix</option>
                    </Form.Control>
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Municipi:</Form.Label>
                    <Form.Control
                        as="select"
                        name="municipi"
                        value={municipiId}
                        onChange={(e) => setMunicipiId(e.target.value)}
                    >
                        <option value="-1">Selecciona un municipi</option>
                        {municipis && municipis.map((municipi) => (
                            <option key={municipi.id} value={municipi.id}>
                                {municipi.nom}
                            </option>
                        ))}
                    </Form.Control>
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Tipus:</Form.Label>
                    <Form.Control
                        as="select"
                        name="tipus"
                        value={selectedTipusId}
                        onChange={(e) => setSelectedTipusId(e.target.value)}
                    >
                        <option value="-1">Selecciona un tipus</option>
                        {tipus && tipus.map((tipusItem) => (
                            <option key={tipusItem.id} value={tipusItem.id}>
                                {tipusItem.nom_tipus}
                            </option>
                        ))}
                    </Form.Control>
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Arquitecte:</Form.Label>
                    <Form.Control
                        as="select"
                        name="arquitecte"
                        value={arquitecteId}
                        onChange={(e) => setArquitecteId(e.target.value)}
                    >
                        <option value="-1">Selecciona un arquitecte</option>
                        {arquitectes && arquitectes.map((arquitecte) => (
                            <option key={arquitecte.id} value={arquitecte.id}>
                                {arquitecte.nom}
                            </option>
                        ))}
                    </Form.Control>
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Gestor:</Form.Label>
                    <Form.Control
                        as="select"
                        name="gestor"
                        value={gestorId}
                        onChange={(e) => setGestorId(e.target.value)}
                    >
                        <option value="-1">Selecciona un gestor:</option>
                        {gestors && gestors.map((gestor) => (
                            <option key={gestor.id} value={gestor.id}>
                                {gestor.nom}
                            </option>
                        ))}
                    </Form.Control>
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Destacat:</Form.Label>
                    <Form.Check
                        type="checkbox"
                        label="Espai destacat"
                        name="destacat"
                        checked={destacat}
                        onChange={(e) => setDestacat(e.target.checked)}
                    />
                </Form.Group>

                <Form.Group className="mb-3">
                    <Form.Label>Modalitat:</Form.Label>
                    <ModalitatsSelect api_token = {token}></ModalitatsSelect>
                </Form.Group>
            <Button variant="primary" type="button" onClick={guardaEspai}>
                Guarda
            </Button>
            <Button variant="warning" onClick={() => navigate("/espais")}>
                Cancel·la
            </Button>
            <Button variant="danger" type="button" onClick={esborraEspai}>
                Esborra
            </Button>
            <br />
        </Form>
        <br />
        {error !== '' && <Alert variant="danger">{error}</Alert>}
    </div>
    );
}