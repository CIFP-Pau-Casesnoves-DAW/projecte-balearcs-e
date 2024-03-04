import React, { useState, useEffect } from 'react';
import Card from 'react-bootstrap/Card';
import Button from 'react-bootstrap/Button';
import axios from 'axios';
import { Pagination, Modal } from 'react-bootstrap';
import BarraCerca from './BarraCerca';

const MesEspais = (props) => {
    const [espais, setEspais] = useState([]);
    const [fotos, setFotos] = useState([]);
    const [paginaActual, setPaginaActual] = useState(1);
    const elementsPerPagina = 8;
    const [espaiSeleccionat, setEspaiSeleccionat] = useState(null);
    const [modalObert, setModalObert] = useState(false);
    const API_URL = 'http://balearc.aurorakachau.com/public/api';
    const token = props.api_token;


    const fetchEspaisFotos = async () => {
        const headersConfig = {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        };
        try {
            // Obtenir espais i valoracions simultàniament
            const [responseEspais, responseValoracions] = await Promise.all([
                axios.get(`${API_URL}/espais`, headersConfig),
                axios.get(`${API_URL}/valoracions`, headersConfig)
            ]);

            // Crear un mapa de valoracions per espai
            const valoracionsPerEspai = responseValoracions.data.data.reduce((acc, valoracio) => {
                if (!acc[valoracio.espai_id]) {
                    acc[valoracio.espai_id] = [];
                }
                acc[valoracio.espai_id].push(valoracio.puntuacio);
                return acc;
            }, {});

            // Afegeix la mitjana de valoracions a cada espai
            const espaisAmbValoracions = responseEspais.data.data.map(espai => {
                const valoracions = valoracionsPerEspai[espai.id] || [];
                let valoracioMitjana;
                if (valoracions.length > 0) {
                    const mitjanaValoracions = valoracions.reduce((acc, puntuacio) => acc + puntuacio, 0) / valoracions.length;
                    valoracioMitjana = mitjanaValoracions.toFixed(2); // Fixem la mitjana a dos decimals
                } else {
                    valoracioMitjana = "No té valoracions"; // Missatge quan no hi ha valoracions
                }
                return { ...espai, valoracioMitjana };
            });
            

            setEspais(espaisAmbValoracions);

            // Obtenir fotos
            const responseFotos = await axios.get(`${API_URL}/fotos`, headersConfig);
            setFotos(responseFotos.data.data);
        } catch (error) {
            console.error('Error al obtenir els espais o les fotos', error);
        }
    };

    useEffect(() => {
        fetchEspaisFotos();
    }, []);

    const fetchAdditionalInfo = async (espai) => {
        try {
            const headersConfig = {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            };
            const [arquitecteRes, municipiRes, tipusRes] = await Promise.all([
                axios.get(`${API_URL}/arquitectes/${espai.arquitecte_id}`, headersConfig),
                axios.get(`${API_URL}/municipis/${espai.municipi_id}`, headersConfig),
                axios.get(`${API_URL}/tipus/${espai.tipus_id}`, headersConfig)
            ]);
            return {
                ...espai,
                nomArquitecte: arquitecteRes.data.data.nom || "No disponible",
                nomMunicipi: municipiRes.data.data.nom || "No disponible",
                nomTipus: tipusRes.data.data.nom_tipus || "No disponible"
            };
            
        } catch (error) {
            console.error('Error al obtenir informació addicional', error);
            return null; // Canviat per retornar null en cas d'error
        }
    };
    

    const getFotoEspai = (espaiId) => {
        const foto = fotos.find(f => f.espai_id === espaiId);
        return foto ? `http://balearc.aurorakachau.com/public/storage/${foto.foto}` : '';
    };

    const mostraInformacioEspai = async (espai) => {
        // Obtenir informació addicional de l'espai
        const espaiComplet = await fetchAdditionalInfo(espai);
        if (espaiComplet) {
            // Actualitzar l'estat amb la informació completa de l'espai
            setEspaiSeleccionat(espaiComplet);
            setModalObert(true);
        } else {
            // Gestionar l'error o mostrar un missatge a l'usuari
            console.error('No es pot obtenir la informació addicional de l\'espai');
        }
    };
    

    const tancaModal = () => {
        setModalObert(false);
        setEspaiSeleccionat(null);
    };    



    const indexUltimElement = paginaActual * elementsPerPagina;
    const indexPrimerElement = indexUltimElement - elementsPerPagina;
    const elementsActuals = espais.slice(indexPrimerElement, indexUltimElement);

    const nombrePagines = Math.ceil(espais.length / elementsPerPagina);

    const renderitzaPaginacio = () => {
        let items = [];
        for (let numero = 1; numero <= nombrePagines; numero++) {
            items.push(
                <Pagination.Item key={numero} active={numero === paginaActual} onClick={() => setPaginaActual(numero)}>
                    {numero}
                </Pagination.Item>
            );
        }
        return <Pagination>{items}</Pagination>;
    };
    

    return (
        <>
            <h2 className="mb-3">Més Espais</h2>
              {/* BarraCerca */}
            <div style={{ display: 'flex', alignItems: 'center' }}>
                    <BarraCerca />
            </div> 
            <div style={{ display: 'flex', flexWrap: 'wrap', justifyContent: 'center', margin: '-0.5rem', marginTop: '0.5rem' }}>
                {elementsActuals.map((espai) => (
                    <Card key={espai.id} style={{ width: 'calc(25% - 1rem)', margin: '0.5rem' }}>
                        <Card.Img variant="top" src={getFotoEspai(espai.id)} />
                        <Card.Body>
                            <Card.Title>{espai.nom}</Card.Title>
                            <Card.Text>{espai.descripcio}</Card.Text>
                            <Button variant="primary" onClick={() => mostraInformacioEspai(espai)}>Més informació</Button>
                        </Card.Body>
                    </Card>
                ))}
                <Modal show={modalObert} onHide={tancaModal}>
                    {espaiSeleccionat ? (
                        <>
                            <Modal.Header closeButton>
                                <Modal.Title>{espaiSeleccionat.nom}</Modal.Title>
                            </Modal.Header>
                            <Modal.Body>
                                <p><strong>Descripció:</strong> {espaiSeleccionat.descripcio}</p>
                                <p><strong>Adreça:</strong> {`${espaiSeleccionat.carrer} ${espaiSeleccionat.numero}, ${espaiSeleccionat.pis_porta || ''}`}</p>
                                <p><strong>Web:</strong> <a href={espaiSeleccionat.web} target="_blank" rel="noopener noreferrer">{espaiSeleccionat.web}</a></p>
                                <p><strong>Correu electrònic:</strong> {espaiSeleccionat.mail}</p>
                                <p><strong>Grau d'accessibilitat:</strong> {espaiSeleccionat.grau_acc}</p>
                                <p><strong>Arquitecte:</strong> {espaiSeleccionat.nomArquitecte}</p>
                                <p><strong>Tipus:</strong> {espaiSeleccionat.nomTipus}</p>
                                <p><strong>Municipi:</strong> {espaiSeleccionat.nomMunicipi}</p>
                                <p><strong>Any de construcció:</strong> {espaiSeleccionat.any_cons ? espaiSeleccionat.any_cons : "No especificat"}</p>
                                <p><strong>Valoració mitjana:</strong> {espaiSeleccionat.valoracioMitjana}</p>
                                <p><strong>Comentaris:</strong></p>
                                <ul>
                                    {espaiSeleccionat.comentaris.map((comentariObj, index) => (
                                        <li key={index}>
                                            {comentariObj.comentari} - {new Date(comentariObj.data).toLocaleDateString()}
                                        </li>
                                    ))}
                                </ul>
                            </Modal.Body>
                        </>
                    ) : (
                        <Modal.Body>
                            Carregant informació...
                        </Modal.Body>
                    )}
                    <Modal.Footer>
                        <Button variant="secondary" onClick={tancaModal}>Tanca</Button>
                    </Modal.Footer>
                </Modal>
            </div>
            <div style={{ display: 'flex', justifyContent: 'center', marginTop: '1rem' }}>
                {renderitzaPaginacio()}
            </div>
        </>
    );

}

export default MesEspais;
    