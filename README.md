# Projecte Balearcs - README

## Grup E
- **Membres del grup:** Joan Toni, Aurora, Joan Company

## 1. Introducció
El projecte Balearcs té com a objectiu la creació d'un portal web multilingüe per a la promoció cultural del patrimoni arquitectònic de les Illes Balears. L'enfocament se centra en donar a conèixer els edificis més representatius, moviments arquitectònics i arquitectes rellevants de la regió.

## 2. Descripció de les Dades
El portal permet als usuaris gestionar informació sobre els espais arquitectònics, les visites expositives i els usuaris mateixos. Cada espai arquitectònic conté detalls com el nom, descripció, ubicació, contacte, tipus d'espai, informació de l'arquitecte, etc. També es registren visites expositives amb detalls sobre títol, dates, inscripció, etc. Els usuaris, tant gestors com visitants, tenen funcionalitats específiques al portal.

## 3. Funcionalitat
### FrontEnd
- Navegació a través de pàgines amb menú jeràrquic, barra de navegació i acordió.
- Selecció d'idioma general de la web amb traducció automàtica.
- Visualització dinàmica de fotografies dels espais destacats.
- Filtrat, ordenació i paginació d'informació bàsica dels espais.
- Cerques avançades amb múltiples filtres.
- Visualització detallada d'un espai amb informació completa.
- Detalls de visites expositives amb punts d'interès.
- Mostra dels 5 comentaris més recents.
- Formulari de contacte amb l'administrador.
- Registre d'usuaris per a comentaris i valoracions.

### BackEnd
- Administració d'espais, usuaris i comentaris.
- Gestió d'informació privada d'usuaris registrats.
- Funcionalitats específiques pels gestors d'espais.

## Mòdul A: Anàlisi i Planificació
### Descripció
Aquesta secció inclou la planificació del disseny conceptual, diagrama de fluxos i el model Entitat-Relació.

### Realització
Al final d'aquest projecte s'han proporcionat els diferents documents dins PLANIFICACIÓ:

a. Esbós de l'estructura de continguts i prototips de pantalles.

b. Model Entitat-Relació.

# Projecte Laravel

Aquest projecte és una aplicació web construïda amb Laravel que inclou migracions, models, controladors, middleware i documentació detallada.

## Requisits Previs

Assegura't de tenir instal·lades les següents eines abans de començar:
- [PHP](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Laravel](https://laravel.com/)

## Configuració de l'Entorn

1. **Clonar el Repositori:**

   ```bash
   git clone https://github.com/CIFP-Pau-Casesnoves-DAW/projecte-balearcs-e.git

2. **Instal·lar Dependències:**

   ```bash
   composer install

3. **Modificar l'arxiu de configuració**

2. **Clonar el Repositori:**

   ```bash
   composer install
   
## Migracions

Executa les migracions per crear la base de dades:
    
    php artisan migrate
    
## Models

- Arquitectes
- Audios
- Comentaris
- Espais
- Espaisidiomes
- EspaisModalitats
- EspaisServeis
- Fotos
- Idiomes
- Illa
- Login
- Modalitats
- Modalitatsidiomes
- Municipis
- Puntsinteres
- Serveis
- Serveisidiomes
- Tipus
- Usuaris
- Valoracions
- Visites
- Visitesidiomes
- VisitesPuntsInteres

## Controladors

- ArquitectesController
- AudiosController
- ComentarisController
- EspaisController
- EspaisidiomesController
- EspaisModalitatsController
- EspaisServeisController
- FotosController
- IdiomesController
- IllaController
- LoginController
- ModalitatsController
- ModalitatsidiomesController
- MunicipisController
- PuntsinteresController
- ServeisController
- ServeisidiomesController
- TipusController
- UsuarisController
- ValoracionsController
- VisitesController
- VisitesIdiomesController
- VisitesPuntsInteresController

## Middleware

S'han creat els Middlewares següents:

-  ControlaAdministrador
-  ControlaDadesAudios
-  ControlaDadesComentaris
-  ControlaDadesFotos
-  ControlaDadesPuntsInteres
-  ControlaDadesValoracions
-  ControlaDadesVisites
-  ControlaDadesEspais
-  ControlaDadesUsuaris
-  ControlaRegistreUsuaris
-  ControlaToken

## Documentació

La documentació del codi s'ha realitzat emprant Swagger (OpenAPI)

## Contribucions

Si vols contribuir al projecte, segueix aquests passos:

1. Fes un fork del repositori.
2. Crea una branca per a la teva funcionalitat o correcció: `git checkout -b feature/nova-funcionalitat`.
3. Realitza els teus canvis i fes un commit: `git commit -m "Afegeix nova funcionalitat"`.
4. Puja els teus canvis al teu repositori: `git push origin feature/nova-funcionalitat`.
5. Obre un pull request a GitHub.

## Llicència

Aquest projecte està sota la [Llicència CIFP PAUCASESNOVES](LICENSE).

## DonDominio

Aquest projecte està pujat a http://balearc.aurorakachau.com/public/api/nom_taula
