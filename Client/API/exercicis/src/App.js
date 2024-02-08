import Ajuda from "./components/Ajuda.jsx";
import Menu from "./components/Menu.jsx";
import Municipis from "./components/municipis/Municipis.jsx";
import MunicipisEdita from "./components/municipis/MunicipisEdita.jsx";
import MunicipisCRUD from "./components/municipis/MunicipisCRUD.jsx";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { useEffect, useState } from "react";
import MunicipisTable from "./components/municipis/MunicipisTable.jsx";
import Comentaris from "./components/api/Comentaris.jsx";
import ComentarisAfegeix from "./components/api/ComentarisAfegeix.jsx";
import ComentarisCRUD from "./components/api/ComentarisCRUD.jsx";
import ComentarisTable from "./components/api/ComentarisTable.jsx";
import Login from "./components/login/Login.jsx";
import Logout from "./components/login/Logout.jsx";
import Inici from "./components/Inici.jsx";
import { storage } from "./utils/storage.js"; 
/**
 * Component principal de l'aplicació.
 * Aquest component és responsable de renderitzar les rutes de l'aplicació utilitzant React Router.
 * Conté una ruta principal ("/") que mostra el component Menu i altres rutes com "/feines" i "/ajuda"
 * que mostren els components Feines i Ajuda respectivament. Si cap ruta coincideix, es mostra un missatge d'error 404.
 *
 * @returns {JSX.Element} El component principal de l'aplicació.
 */
function App() {
  const  [api_token, setapi_token] = useState(null);
  const [usuari_id, setusuari_id] = useState(null);
  const [usuari_rol, setusuari_rol] = useState(null);
  const [usuari_nom, setusuari_nom] = useState(null);

  // Validation
  useEffect(() => {
    const tk = storage.get("api_token");  // llegint el api_token del localStorage
    const us = storage.get("usuari_id"); // llegint l'user_id del localStorage
    const rol = storage.get("usuari_rol"); // llegint el rol del localStorage
    const nom = storage.get("usuari_nom"); // llegint el nom del localStorage
    
    if (nom) {
      setusuari_nom(nom);
    }
    if (rol) {
      setusuari_rol(rol);
    }
    if (us) {
      setusuari_id(us);
    }
    if (tk) {
      setapi_token(tk);
    }
  }, []);

  // Guardam el token i l'usuari al localStorage
  const ferGuardaapi_token = (api_token) => {
    storage.set("api_token",api_token);  // guardant el api_token al localStorage
    setapi_token(api_token);
  }
  const ferGuardausuari_id = (usuari_id) => {
    storage.set("usuari_id",usuari_id);  // guardant el user_id al localStorage
    setusuari_id(usuari_id);
  }
  const ferGuardausuari_rol = (usuari_rol) => {
    storage.set("usuari_rol",usuari_rol);  // guardant el usuari_rol al localStorage
    setusuari_rol(usuari_rol);
  }
  const ferGuardausuari_nom = (usuari_nom) => {
    storage.set("usuari_nom",usuari_nom);  // guardant el usuari_nom al localStorage
    setusuari_nom(usuari_nom);
  }



  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Menu api_token={api_token} usuari_id={usuari_id} usuari_rol={usuari_rol} usuari_nom={usuari_nom}/>} >
        {/* Routes sols per a usuaris logats*/}
        {api_token && <>
            <Route path="/inici" element={<Inici/>} />
            {/* MUNICIPIS */}
            <Route path="/municipis" element={<Municipis/>} />
            <Route path="/municipistable" element={<MunicipisTable/>} />
            <Route path="/municipis/afegir" element={<MunicipisEdita />} />
            <Route path="/municipis/:id" element={<MunicipisCRUD api_token={api_token}/>}/>
            {/* LOGOUT */}
            <Route path="/logout" element={<Logout/>}/>
            {/* COMENTARIS API */}
            <Route path="/comentaris" element={<Comentaris />} />
            <Route path="/comentaris/afegir" element={<ComentarisAfegeix />} />
            <Route path="/comentaris/:id" element={<ComentarisCRUD />}/>
            <Route path="/comentaristable" element={<ComentarisTable/>} />
        </>} 
        {/* Routes sols per a usuaris NO logats*/}
        {!api_token && <Route path="/login" element={<Login guardausuari_id={ferGuardausuari_id} guardaapi_token={ferGuardaapi_token} guardausuari_rol={ferGuardausuari_rol} guardausuari_nom={ferGuardausuari_nom}/>} /> } 
        {/* Routes per a tots els usuaris*/}
          <Route path="/ajuda" element={<Ajuda />} />
          <Route path="*" element={<h1>Opció incorrecta</h1>} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
