import React from 'react';
import Carousel from 'react-bootstrap/Carousel';

const HomePage = () => {
    return (
        <div>
            <h1 style={{ color: 'Darkgreen', textAlign: 'center', padding: '30px'}}>BaleArts</h1>
            <p style={{ fontStyle: 'italic', textAlign: 'center' , paddingBottom: '30px'}}>Benvingut a la pàgina web de BaleArts</p>
            <Carousel>
                <Carousel.Item >
                    <img 
                        className="d-block w-100 carousel-image"
                        src="https://www.vacalia.com/blog/wp-content/uploads/2019/07/cathedral-3763071_1280-1024x682.jpg"
                        alt="First slide"
                        style={{ height: '600px', borderRadius:'15px' }} 
                    />
                    <Carousel.Caption>
                        <h3>Imagen 1</h3>
                        <p>Descripción de la imagen 1.</p>
                    </Carousel.Caption>
                </Carousel.Item>
                <Carousel.Item>
                    <img
                        className="d-block w-100 carousel-image"
                        src="https://upload.wikimedia.org/wikipedia/commons/1/1b/0051-Reiterstatur_Palma.JPG"
                        alt="Second slide"
                        style={{ height: '600px', borderRadius:'15px' }} 
                    />
                    <Carousel.Caption>
                        <h3>Imagen 2</h3>
                        <p>Descripción de la imagen 2.</p>
                    </Carousel.Caption>
                </Carousel.Item>
                <Carousel.Item>
                    <img
                        className="d-block w-100 carousel-image"
                        src="https://www.vacalia.com/blog/wp-content/uploads/2019/07/island-83308_640.jpg"
                        alt="Third slide"
                        style={{ height: '600px', borderRadius:'15px' }} 
                    />
                    <Carousel.Caption>
                        <h3>Imagen 3</h3>
                        <p>Descripción de la imagen 3.</p>
                    </Carousel.Caption>
                </Carousel.Item>
            </Carousel>
            <hr /> 
            <h1>Informació rellevant</h1>
            
        </div>
    );
};

export default HomePage;
