import React, { useState, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import { Form, Button, Spinner, Row, Col } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import { Alert } from 'react-bootstrap';
import ModalitatsSelect from "./ModalitatsSelect";
import FotosEspai from "./FotosEspai";
import ModalitatsEspai from "./ModalitatsEspai";

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
    const [mostraFormulari, setMostraFormulari] = useState(false);
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
            // Filtra els usuaris que tenen el rol de "gestor"
            const gestorsFiltrats = responseData.data.filter(user => user.rol === 'gestor');
            setGestors(gestorsFiltrats);
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
                <hr />
                <Row md={9}>
                    <Col>
                        <h2>Llista de modalitats</h2>
                    </Col>
                    <Col style={{textAlign:"right"}}>
                        <Button
                            variant="success"
                            type="button"
                            onClick={() => {
                                setMostraFormulari(true)
                            }}
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-fill-add" viewBox="0 0 16 16">
                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0M8 1c-1.573 0-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4s.875 1.755 1.904 2.223C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777C13.125 5.755 14 5.007 14 4s-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1"/>
                                <path d="M2 7v-.839c.457.432 1.004.751 1.49.972C4.722 7.693 6.318 8 8 8s3.278-.307 4.51-.867c.486-.22 1.033-.54 1.49-.972V7c0 .424-.155.802-.411 1.133a4.51 4.51 0 0 0-4.815 1.843A12 12 0 0 1 8 10c-1.573 0-3.022-.289-4.096-.777C2.875 8.755 2 8.007 2 7m6.257 3.998L8 11c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V10c0 1.007.875 1.755 1.904 2.223C4.978 12.711 6.427 13 8 13h.027a4.55 4.55 0 0 1 .23-2.002m-.002 3L8 14c-1.682 0-3.278-.307-4.51-.867-.486-.22-1.033-.54-1.49-.972V13c0 1.007.875 1.755 1.904 2.223C4.978 15.711 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.5 4.5 0 0 1-1.3-1.905"/>
                            </svg> Afegir modalitat
                        </Button>
                    </Col>
                </Row>
                {/*Si pulsam el botó mostram el formulari  */}
                {mostraFormulari && (
                <ModalitatsSelect
                    api_token={token}
                    codiespai={id}
                    onCancel={() => setMostraFormulari(false)}
                />
                )}
                <hr />
                <ModalitatsEspai  api_token={token} id={id} />
                <hr />
                <br />
                <Form.Group className="mb-3">
                    <h2>Fotografies:</h2>
                    <hr />
                    <FotosEspai id={id}/>
                </Form.Group>
                <hr />

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