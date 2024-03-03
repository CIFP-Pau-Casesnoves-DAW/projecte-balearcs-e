            
import Ajuda from "./components/Ajuda.jsx";
import Menu from "./components/Menu.jsx";
import MunicipisAfegeix from "./components/municipis/MunicipisAfegeix.jsx";
import MunicipisCRUD from "./components/municipis/MunicipisCRUD.jsx";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { useEffect, useState } from "react";
import Municipis from "./components/municipis/Municipis.jsx";
import ComentarisAfegeix from "./components/comentaris/ComentarisAfegeix.jsx";
import ComentarisCRUD from "./components/comentaris/ComentarisCRUD.jsx";
import Comentaris from "./components/comentaris/Comentaris.jsx";
import Login from "./components/login/Login.jsx";
import Logout from "./components/login/Logout.jsx";
import Usuari from "./components/Usuari.jsx";
import Inici from "./components/Inici.jsx";
import { storage } from "./utils/storage.js"; 
import Serveis from "./components/serveis/Serveis.jsx";
import ServeisAfegeix from "./components/serveis/ServeisAfegeix.jsx";
import ServeisCRUD from "./components/serveis/ServeisCRUD.jsx";
import Tipus from "./components/tipus/Tipus.jsx";
import TipusCRUD from "./components/tipus/TipusCRUD.jsx";
import TipusAfegeix from "./components/tipus/TipusAfegeix.jsx";
import Idiomes from "./components/idiomes/Idiomes.jsx";
import IdiomesCRUD from "./components/idiomes/IdiomesCRUD.jsx";
import IdiomesAfegeix from "./components/idiomes/IdiomesAfegeix.jsx";
import Modalitats from "./components/modalitats/Modalitats.jsx";
import ModalitatsAfegeix from "./components/modalitats/ModalitatsAfegeix.jsx";
import ModalitatsCRUD from "./components/modalitats/ModalitatsCRUD.jsx";
import Arquitectes from "./components/arquitectes/Arquitectes.jsx";
import ArquitectesCRUD from "./components/arquitectes/ArquitectesCRUD.jsx";
import ArquitectesAfegeix from "./components/arquitectes/ArquitectesAfegeix.jsx";
import Espais from "./components/espais/Espais.jsx";
import EspaisAfegir from "./components/espais/EspaisAfegir.jsx";
import EspaisCRUD from "./components/espais/EspaisCRUD.jsx";
import Puntsinteres from "./components/puntsinteres/Puntsinteres.jsx";
import PuntsinteresAfegeix from "./components/puntsinteres/PuntsinteresAfegeix.jsx";
import PuntsinteresCRUD from "./components/puntsinteres/PuntsinteresCRUD.jsx";
import Valoracions from "./components/valoracions/Valoracions.jsx";
import ValoracionsAfegeix from "./components/valoracions/ValoracionsAfegeix.jsx";
import ValoracionsCRUD from "./components/valoracions/ValoracionsCRUD.jsx";
import Fotos from "./components/fotos/Fotos.jsx";
import FotosAfegeix from "./components/fotos/FotosAfegeix.jsx";
import FotosCRUD from "./components/fotos/FotosCRUD.jsx";
import EspaisGestors from "./components/gestors/espais/EspaisGestors.jsx";
import EspaisGestorsCRUD from "./components/gestors/espais/EspaisGestorsCRUD.jsx";
import PuntsInteresGestorsCRUD from "./components/gestors/puntsinteres/PuntsInteresGestorsCRUD.jsx";
import Usuaris from "./components/usuaris/Usuaris.jsx";
import UsuarisCRUD from "./components/usuaris/UsuarisCRUD.jsx";
import UsuarisAfegeix from "./components/usuaris/UsuarisAfegeix.jsx";
import Visites from "./components/visites/Visites.jsx";
import VisitesCRUD from "./components/visites/VisitesCRUD.jsx";
import VisitesAfegeix from "./components/visites/VisitesAfegeix.jsx";
import VisitesEspaisGestorsCRUD from "./components/gestors/espais/VisitesEspaisGestorsCRUD.jsx";
import Registre from "./components/registre/Registre.jsx";
import Audios from "./components/audios/Audios.jsx";
import AudiosAfegeix from "./components/audios/AudiosAfegeix.jsx";
import AudiosCRUD from "./components/audios/AudiosCRUD.jsx";
import MesEspais from "./components/MesEspais.jsx";
import BarraCerca from "./components/BarraCerca.jsx";
import LlistaEspais from "./components/LlistaEspais.jsx";
import LlistaMunicipis from "./components/LlistaMunicipis.jsx";
import PuntsInteresEspai from "./components/PuntsInteresEspai.jsx";
import VisitesEspais from "./components/VisitesEspais.jsx";
import UltimsComentaris from "./components/UltimsComentaris.jsx";
import ValoracionsComentaris from "./components/ValoracionsComentaris.jsx";

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


   {/*Guardam el token i l'usuari al localStorage*/}
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
        {/* Routes sols per a usuaris logats administradors*/}
        {api_token && usuari_rol=="administrador" && <>
            {/* MUNICIPIS */}
            <Route path="/municipis" element={<Municipis api_token = {api_token}/>} />
            <Route path="/municipis/afegir" element={<MunicipisAfegeix api_token = {api_token}/>} />
            <Route path="/municipis/:id" element={<MunicipisCRUD api_token = {api_token}/>}/>
            {/* COMENTARIS API */}
            <Route path="/comentaris/afegir" element={<ComentarisAfegeix api_token = {api_token}/>} />
            <Route path="/comentaris/:id" element={<ComentarisCRUD api_token = {api_token}/>}/>
            <Route path="/comentaris" element={<Comentaris api_token = {api_token}/>} />
            {/* SERVEIS */}
            <Route path="/serveis" element={<Serveis api_token = {api_token}/>} />
            <Route path="/serveis/afegir" element={<ServeisAfegeix api_token = {api_token}/>} />
            <Route path="/serveis/:id" element={<ServeisCRUD api_token = {api_token}/>}/>
            {/* TIPUS */}
            <Route path="/tipus" element={<Tipus api_token = {api_token}/>} />
            <Route path="/tipus/afegir" element={<TipusAfegeix api_token = {api_token}/>} />
            <Route path="/tipus/:id" element={<TipusCRUD api_token = {api_token}/>}/>
            {/* IDIOMES */}
            <Route path="/idiomes" element={<Idiomes api_token = {api_token}/>} />
            <Route path="/idiomes/afegir" element={<IdiomesAfegeix api_token = {api_token}/>} />
            <Route path="/idiomes/:id" element={<IdiomesCRUD api_token = {api_token}/>}/>
            {/* MODALITATS */}
            <Route path="/modalitats" element={<Modalitats api_token = {api_token}/>} />
            <Route path="/modalitats/afegir" element={<ModalitatsAfegeix api_token = {api_token}/>} />
            <Route path="/modalitats/:id" element={<ModalitatsCRUD api_token = {api_token}/>}/>
            {/* ARQUITECTES */}
            <Route path="/arquitectes" element={<Arquitectes api_token = {api_token}/>} />
            <Route path="/arquitectes/afegir" element={<ArquitectesAfegeix api_token = {api_token}/>} />
            <Route path="/arquitectes/:id" element={<ArquitectesCRUD api_token = {api_token}/>} />
            {/* ESPAIS */}
            <Route path="/espais" element={<Espais api_token={api_token}/>} />
            <Route path="/espais/afegir" element={<EspaisAfegir api_token={api_token}/>} />
            <Route path="/espais/:id" element={<EspaisCRUD api_token={api_token}/>} />
            {/* PUNTS D'INTERÈS */}
            <Route path="/puntsinteres" element={<Puntsinteres api_token={api_token}/>} />
            <Route path="/puntsinteres/afegir" element={<PuntsinteresAfegeix api_token={api_token}/>} />
            <Route path="/puntsinteres/:id" element={<PuntsinteresCRUD api_token={api_token}/>} />
            {/* VALORACIONS */}
            <Route path="/valoracions" element={<Valoracions api_token={api_token}/>} />
            <Route path="/valoracions/afegir" element={<ValoracionsAfegeix api_token={api_token}/>} />
            <Route path="/valoracions/:id" element={<ValoracionsCRUD api_token={api_token}/>} />
            {/* FOTOS */}
            <Route path="/fotos" element={<Fotos api_token={api_token}/>} />
            <Route path="/fotos/afegir" element={<FotosAfegeix api_token={api_token}/>} />
            <Route path="/fotos/:id" element={<FotosCRUD api_token={api_token}/>} />
            {/* AUDIOS */}
            <Route path="/audios" element={<Audios api_token={api_token}/>} />
            <Route path="/audios/afegir" element={<AudiosAfegeix api_token={api_token}/>} />
            <Route path="/audios/:id" element={<AudiosCRUD api_token={api_token}/>} />
            {/* USUARIS */}
            <Route path="/usuaris" element={<Usuaris api_token = {api_token} usuari_nom={usuari_nom} usuari_id={usuari_id}/>} />
            <Route path="/usuaris/:id" element={<UsuarisCRUD api_token={api_token}/>} />
            <Route path="/usuaris/afegir" element={<UsuarisAfegeix api_token={api_token}/>} />
            {/* VISITES */}
            <Route path="/visites" element={<Visites api_token={api_token} usuari_nom={usuari_nom} usuari_id={usuari_id}/>} />
            <Route path="/visites/:id" element={<VisitesCRUD api_token={api_token} />} />
            <Route path="/visites/afegir" element={<VisitesAfegeix api_token={api_token} />} />
        </>} 
        {/* Routes sols per a usuaris logats gestors*/}
        {api_token && usuari_rol=="gestor" && <>
            {/* GESTIÓ D'ESPAIS */}
            <Route path="/espaisgestors" element={<EspaisGestors api_token = {api_token} usuari_id={usuari_id} />} />
            <Route path="/espaisgestors/:id" element={<EspaisGestorsCRUD api_token = {api_token} />} />
            {/* GESTIÓ DE PUNTS D'INTERÈS */}
            {/* Problema perque si poso un altre id no asignat al gestor el pot modificar */}
            <Route path="/espaisgestors/:id/puntsinteresgestors/:id" element={<PuntsInteresGestorsCRUD api_token = {api_token} />} />
            <Route path="/espaisgestors/:id/visitesgestors/:id" element={<VisitesEspaisGestorsCRUD api_token = {api_token} />} />
        </>}
        {/* Routes sols per a usuaris logats*/}
        {api_token && <>
            {/* INICI */}
            <Route path="/usuari" element={<Usuari api_token = {api_token} usuari_nom={usuari_nom} usuari_id={usuari_id}/>} />
            {/* LOGOUT */}
            <Route path="/logout" element={<Logout/>}/>
             {/* MÉS ESPAIS */}
             <Route path="/mesespais" element={<MesEspais api_token = {api_token}/>} />
             {/* VALORACIONS I COMENTARIS */}
              <Route path="/valoracionscomentaris" element={<ValoracionsComentaris api_token = {api_token}/>} />
             
        </>} 
        {/* Routes sols per a usuaris NO logats*/}
        {!api_token && <>
          <Route path="/login" element={<Login guardausuari_id={ferGuardausuari_id} guardaapi_token={ferGuardaapi_token} guardausuari_rol={ferGuardausuari_rol} guardausuari_nom={ferGuardausuari_nom}/>} />
          <Route path="/registre" element={<Registre guardausuari_id={ferGuardausuari_id} guardaapi_token={ferGuardaapi_token} guardausuari_rol={ferGuardausuari_rol} guardausuari_nom={ferGuardausuari_nom}/>} />
        </> } 
        {/* Routes per a tots els usuaris*/}
          <Route path="/ajuda" element={<Ajuda />} />
          <Route path="/inici" element={<Inici />} />
          <Route path="/mesespais" element={<MesEspais api_token = {api_token}/>} />
          <Route path="/puntsinteresespai" element={<PuntsInteresEspai api_token = {api_token}/>} />
          <Route path="/visitesespais" element={<VisitesEspais api_token = {api_token}/>}  />
          <Route path="/ultimscomentaris" element={<UltimsComentaris api_token = {api_token}/>} />
          <Route path="/valoracionscomentaris" element={<ValoracionsComentaris api_token = {api_token}/>} />
          <Route path="/cerca" element={<BarraCerca api_token = {api_token}/>} />
          <Route path="/municipis" element={<LlistaMunicipis api_token = {api_token}/>} />
          <Route path="/espais" element={<LlistaEspais api_token = {api_token}/>} />
          <Route path="*" element={<h1>Ups! Opció incorrecta</h1>} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
