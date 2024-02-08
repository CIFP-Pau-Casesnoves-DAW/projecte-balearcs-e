import {Link, Outlet} from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import {Navbar, Nav, Container} from 'react-bootstrap';
export default function Menu({api_token, usuari_nom}) {
    return (
        <>
            <Navbar bg="dark" className="color-nav" variant="dark" expand="sm" sticky="top">
                <Nav className="mr-auto">
                    {api_token && <>
                    <Link className="nav-link" to="/inici">Inici</Link>
                    <Link className="nav-link" to="/municipis">Municipis</Link>
                    <Link className="nav-link" to="/municipistable">Municipis Table</Link>
                    <Link className="nav-link" to="/comentaris">Comentaris</Link>
                    <Link className="nav-link" to="/comentaristable">Comentaris Table</Link>
                    <Link className="nav-link" to="/logout">Logout</Link>
                    </>}
                    <Link className="nav-link" to="/ajuda">Ajuda</Link>
                    {!api_token && <Link className="nav-link" to="/login">Login</Link>}
                </Nav>
                <Navbar.Collapse className="justify-content-end">
                    <Navbar.Text>
                        {usuari_nom && <>Usuari: {usuari_nom}&nbsp;&nbsp;</>}
                    </Navbar.Text>
                </Navbar.Collapse>
            </Navbar>
            <Container>
                <Outlet />
            </Container>
        </>
    );
}