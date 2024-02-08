import React, { useState, useEffect } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Form,Row,Col,Alert, Spinner } from "react-bootstrap";

function SelectEspais(props) {
  const [espais,setEspais]=useState([]);
    const [descarrega,setDescarrega]=useState(true);
    
    const omplirOptions=()=>{
        return espais.map(function(tupla){
            return <option key={tupla.id} value={tupla.id}>{tupla.nom}</option>;
        }); 
    }

    useEffect(
      () => {
        fetch('http://balearc.aurorakachau.com/public/api/espais')
            .then(response => {
                return response.json(response);
            })
            .then(jsonresposta => {
                setEspais(jsonresposta.data);
                setDescarrega(false);
            }
            )
            .catch(function (error) {
                console.log(error);
            })
    }
      ,
      []
  );

 if (descarrega) {
    return <Alert variant="info">Descarregant....</Alert>;
 } else
  return (
    <Row>
    <Col sm={6}>
      <Form.Select onChange={props.onChange} value={props.id}>
        <option key="-1" value="-1">Tria una espai...</option>
        { omplirOptions() }
      </Form.Select>
    </Col>
  </Row>
  );
}
export default SelectEspais;