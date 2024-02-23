import {Link, Outlet} from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Navbar, Nav, Container, NavDropdown } from 'react-bootstrap';
import logo from '../images/logoBalearcs.jpeg'; // Import the image
import '../style/Style.css'; // Importa l'arxiu CSS

export default function Menu({ api_token, usuari_nom, usuari_rol }) {
    return (
        <>
            <Navbar bg="dark" className="color-nav" variant="dark" expand="sm" sticky="top">
                <Nav className="mr-auto align-items-center">
                    <Link className='nav-link' to="/inici">
                        <img style={{ width: '80px', height: '80px', borderRadius: '30px', border: '2px solid black' }}
                            src={logo} alt="Foto del header"
                        />
                    </Link>
                    <Link className="nav-link" to="/inici">Inici</Link>
                    <Link className="nav-link" to="/ajuda">Ajuda</Link>
                    <Link className="nav-link" to="/contacte">Contacte</Link>
                    <Link className="nav-link" to="/mesespais">Més Espais</Link>
                    {api_token && <>
                        <Link className="nav-link" to="/usuari">Usuari</Link>
                        <Link className="nav-link" to="/logout">Logout</Link>
                    </>}
                    {api_token && usuari_rol=='administrador'&& <>
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
                    {api_token && usuari_rol=='gestor'&& <>
                        {/* <NavDropdown title="Gestió" id="basic-nav-dropdown"> */}
                            <Link className="nav-link" to="/espaisgestors">Gestió d'espais</Link>
                        {/* </NavDropdown> */}
                    </>}
                    {!api_token && <>
                        <Link className="nav-link" to="/login">Login</Link>
                    </>}
                </Nav>
                <Navbar.Collapse className="justify-content-end">
                    <Navbar.Text>
                        {usuari_nom && <>Hola, {usuari_nom}&nbsp;&nbsp;</>}
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

