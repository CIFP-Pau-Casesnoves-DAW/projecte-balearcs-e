import React, { useState, useEffect } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Form,Row,Col,Alert, Spinner } from "react-bootstrap";
import { storage } from '../../utils/storage';

function SelectIlles(props) {
  const [illes,setIlles]=useState([]);
    const [descarrega,setDescarrega]=useState(true);
    
    const omplirOptions=()=>{
        return illes.map(function(tupla){
            return <option key={tupla.id} value={tupla.id}>{tupla.nom}</option>;
        }); 
    }

    useEffect(() => {
        fetch('http://balearc.aurorakachau.com/public/api/illes',{
          method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${storage.get('api_token')}`
            }

        }).then(response => {
                return response.json(response);
            })
            .then(jsonresposta => {
                setIlles(jsonresposta.data);
                setDescarrega(false);
            }
            )
            .catch(function (error) {
                console.log(error);
            })
    },[]
  );

 if (descarrega) {
    return <Alert variant="info">Descarregant....</Alert>;
 } else
  return (
    <Row>
    <Col sm={6}>
      <Form.Select onChange={props.onChange} value={props.id}>
        <option key="-1" value="-1">Tria una Illa...</option>
        { omplirOptions() }
      </Form.Select>
    </Col>
  </Row>
  );
}
export default SelectIlles;