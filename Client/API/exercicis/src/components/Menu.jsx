import {Link, Outlet} from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Navbar, Nav, Container, NavDropdown } from 'react-bootstrap';
import logo from '../images/logoBalearcs.jpeg'; // Import the image

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
                        </NavDropdown>
                    </>}
                    {!api_token && <Link className="nav-link" to="/login">Login</Link>}
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
        </>
    );
}

