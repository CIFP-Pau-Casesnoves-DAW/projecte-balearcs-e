import {Link, Outlet} from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import {Navbar, Nav, Container} from 'react-bootstrap';
import logo from '../images/logoBalearcs.jpeg'; // Import the image

export default function Menu({api_token, usuari_nom}) {
    return (
        <>
            <Navbar bg="dark" className="color-nav" variant="dark" expand="sm" sticky="top">
                <Nav className="mr-auto align-items-center"> 
                    <Link className='nav-link' to="/inici">
                        <img style={{ width: '80px', height: '80px', borderRadius: '30px'}} 
                            src={logo} alt="Foto del header" 
                        /> 
                    </Link>
                    <Link className="nav-link" to="/inici">Inici</Link>
                    <Link className="nav-link" to="/ajuda">Ajuda</Link>
                    {api_token && <>
                        <Link className="nav-link" to="/usuari">Usuari</Link>
                        <Link className="nav-link" to="/municipis">Municipis</Link>
                        <Link className="nav-link" to="/comentaris">Comentaris</Link>
                        <Link className="nav-link" to="/logout">Logout</Link>
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
