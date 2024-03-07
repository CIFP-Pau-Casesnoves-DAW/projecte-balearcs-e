import React, { useState } from 'react';
import { Link, Outlet } from 'react-router-dom';
import { Navbar, Nav, NavDropdown, Container, } from 'react-bootstrap';
import logo from '../images/logoBalearcs.jpeg'; // Import the image
import '../style/Style.css'; // Importa l'arxiu CSS
import ModalContacte from './ModalContacte';

export default function Menu({ api_token, usuari_nom, usuari_rol }) {
    const [showMenu, setShowMenu] = useState(false);
    const [modalOpen, setModalOpen] = useState(false); // estat del modal

    const toggleMenu = () => {
        setShowMenu(!showMenu);
    };

    const toggleModal = () => {
        setModalOpen(!modalOpen); // Això commuta l'estat del modal
    };

    return (
        <>
            <Navbar bg="dark" className="color-nav" variant="dark" expand="sm" sticky="top">
                {/* Posam el logo aquí perque es vegi sempre */}
                <Link className='nav-link' to="/inici" style={{paddingLeft:'20px'}} id='imatgeheader'>
                    <img style={{width: '80px', height: '80px', borderRadius: '30px', border: '2px solid black' }}
                        src={logo} alt="Foto del header"
                    />
                </Link>
                <h2 id='textheader'>BALEARTS</h2>
                <Navbar.Brand onClick={toggleMenu} ></Navbar.Brand>
                <Navbar.Toggle aria-controls="basic-navbar-nav" />
                <Navbar.Collapse id="basic-navbar-nav" className={showMenu ? "show" : ""} >
                    <Nav className="mr-auto align-items-center">
                        {/* <Link className='nav-link' to="/inici">
                            <img style={{ width: '80px', height: '80px', borderRadius: '30px', border: '2px solid black' }}
                                src={logo} alt="Foto del header"
                            />
                        </Link> */}
                        <Link className="nav-link" to="/inici">Inici</Link>
                        <Link className="nav-link" to="/ajuda">Ajuda</Link>
                        <NavDropdown title="Espais" id="basic-nav-dropdown">
                            <NavDropdown.Item href="/mesespais">Tots els Espais</NavDropdown.Item>
                            <NavDropdown.Item href="/puntsinteresespai">Punts d'Interés</NavDropdown.Item>
                            <NavDropdown.Item href="/ultimscomentaris">Últims Comentaris</NavDropdown.Item>
                            <NavDropdown.Item href="/visitesespais">Visites dels espais</NavDropdown.Item>
                        </NavDropdown>
                        {api_token && <>
                            <Link className="nav-link" to="/usuari">Usuari</Link>
                            <Link className="nav-link" to="/logout">Logout</Link>
                            <Link className="nav-link" to="/valoracionscomentaris">Comentar i valorar un espai</Link>
                        </>}
                        {api_token && usuari_rol === 'administrador' && <>
                            <NavDropdown title="Modificar Taules" id="basic-nav-dropdown">
                                <NavDropdown.Item href="/municipis">Municipis</NavDropdown.Item>
                                <NavDropdown.Item href="/comentaris">Comentaris</NavDropdown.Item>
                                <NavDropdown.Item href="/serveis">Serveis</NavDropdown.Item>
                                <NavDropdown.Item href="/tipus">Tipus</NavDropdown.Item>
                                <NavDropdown.Item href="/idiomes">Idiomes</NavDropdown.Item>
                                <NavDropdown.Item href="/modalitats">Modalitats</NavDropdown.Item>
                                <NavDropdown.Item href="/arquitectes">Arquitectes</NavDropdown.Item>
                                <NavDropdown.Item href="/espais">Espais</NavDropdown.Item>
                                <NavDropdown.Item href="/puntsinteres">Punts d'interès</NavDropdown.Item>
                                <NavDropdown.Item href="/valoracions">Valoracions</NavDropdown.Item>
                                <NavDropdown.Item href="/fotos">Fotos</NavDropdown.Item>
                                <NavDropdown.Item href="/audios">Audios</NavDropdown.Item>
                                <NavDropdown.Item href="/usuaris">Usuaris</NavDropdown.Item>
                                <NavDropdown.Item href="/visites">Visites</NavDropdown.Item>
                            </NavDropdown>
                        </>}
                        {api_token && usuari_rol === 'gestor' && <>
                            <Link className="nav-link" to="/espaisgestors">Gestió d'espais</Link>
                        </>}
                        {!api_token && <>
                            <Link className="nav-link" to="/login">Login</Link>
                        </>}
                    </Nav>
                    <Nav>
                    <button id='contacta'
                            onClick={toggleModal}
                            style={{
                                backgroundColor: '#99C2A2', color: '#ffffff', padding: '8px 15px',
                                fontSize: '1rem', border: 'none', borderRadius: '0.65rem',
                                cursor: 'pointer', // Canvia el cursor a pointer per a indicar clicabilitat
                                boxShadow: '0px 2px 2px rgba(0, 0, 0, 0.2)', // Ombra lleugera per a profunditat
                                transition: 'all 0.2s ease-in-out', // Suavitzat de transició per interaccions
                                margin: '30px',
                            }}>
                            Contacte
                        </button>
                    </Nav>
                </Navbar.Collapse>
                <ModalContacte isOpen={modalOpen} onClose={toggleModal} />
                <Navbar.Collapse className="justify-content-end">
                    <Navbar.Text>
                        {usuari_nom && <>Hola, {usuari_nom}</>}
                    </Navbar.Text>
                </Navbar.Collapse>
            </Navbar>
            <Container>
                <Outlet />
            </Container>
            {/* Footer */}
            <footer className="footer mt-5 py-3 bg-dark text-white">
                <Container>
                    <div className="row">
                        <div className="col-md-6">
                            <p className="mb-0">&copy; {new Date().getFullYear()} BaleArts. Tots els drets reservats.</p>
                        </div>
                        <div className="col-md-6 d-flex justify-content-end align-items-center">
                            <ul className="list-inline mb-0">
                                <li className="list-inline-item"><a href="#" className="text-white"><i className="fab fa-facebook-f"></i></a></li>
                                <li className="list-inline-item"><a href="#" className="text-white"><i className="fab fa-twitter"></i></a></li>
                                <li className="list-inline-item"><a href="#" className="text-white"><i className="fab fa-instagram"></i></a></li>
                            </ul>
                            <p className="mb-0 ml-3">Contacte: info@balearts.com</p>
                        </div>
                    </div>
                </Container>
            </footer>
        </>
    );
}
