import React from 'react'; // Add the missing import statement for React
import { storage } from '../../utils/storage';
import {Button, Container, Form} from 'react-bootstrap';

export default function Logout(){
    const tancar=()=>{
        storage.remove('api_token');
        storage.remove('usuari_id');
        storage.remove('usuari_rol');
        storage.remove('usuari_nom');
    }

        return  (
            <Container>
            <h2>Sortir de la sessió?</h2>
            <Form onSubmit={tancar} action="/inici">
            <Button variant="primary" type="submit">
                Sortir
            </Button>
            </Form>
            </Container>
        );
}