INSERT INTO `usuaris` (`id`, `nom`, `llinatges`, `dni`, `mail`, `contrasenya`, `rol`, `data_baixa`, `created_at`, `updated_at`, `api_token`) VALUES
(1, 'Juan', 'Pérez', '12345678A', 'juanperez@gmail.com', 'JuanPerez123', 'usuari', NULL, '2023-12-14 17:55:42', '2023-12-14 17:55:42', NULL),
(2, 'Pepe', 'Pepito', '87654321B', 'pepepepito@gmail.com', 'PepePepito123', 'administrador', NULL, '2023-12-14 17:55:42', '2023-12-14 17:55:42', NULL),
(3, 'Gregorio', 'Martorell', '56789012C', 'gregoriomartorell@gmail.com', 'GregorioMartorell123', 'gestor', '2023-12-31', '2023-12-14 17:55:42', '2023-12-14 17:55:42', NULL),
(11, 'Miquel', 'Garcia', '12345678A', 'miquelgarcia@gmail.com', 'MiquelGarcia123', 'usuari', NULL, '2023-12-14 18:48:50', '2023-12-14 18:48:50', NULL),
(12, 'Aina', 'Martí', '23456789B', 'ainamarti@gmail.com', 'AinaMarti123', 'administrador', NULL, '2023-12-14 18:48:50', '2023-12-14 18:48:50', NULL),
(13, 'Pere', 'Soler', '34567890C', 'peresoler@gmail.com', 'PereSoler123', 'gestor', NULL, '2023-12-14 18:48:50', '2023-12-14 18:48:50', NULL),
(14, 'Antònia', 'Pons', '45678901D', 'antoniapons@gmail.com', 'AntoniaPons123', 'usuari', NULL, '2023-12-14 18:48:50', '2023-12-14 18:48:50', NULL),
(15, 'Llorenç', 'Gomila', '56789012E', 'llorencgomila@gmail.com', 'LlorençGomila123', 'administrador', NULL, '2023-12-14 18:48:50', '2023-12-14 18:48:50', NULL),
(16, 'Margarida', 'Morey', '67890123F', 'margaridamorey@gmail.com', 'MargaridaMorey123', 'usuari', NULL, '2023-12-14 18:48:50', '2023-12-14 18:48:50', NULL),
(17, 'Marcos', 'Weon', '67890123F', 'marcosweon@gmail.com', 'MarcosWeon123', 'gestor', NULL, '2023-12-14 19:34:40', '2023-12-14 19:34:40', NULL),
(18, 'Alicia', 'Mec', '67890123F', 'aliciamec@gmail.com', 'AliciaMec123', 'gestor', NULL, '2023-12-14 19:34:40', '2023-12-14 19:34:40', NULL);

INSERT INTO `idiomes` (`id`, `idioma`, `created_at`, `updated_at`, `data_baixa`) VALUES
(1, 'Espanyol', '2023-12-14 18:50:28', '2023-12-14 18:50:28', NULL),
(2, 'Anglès', '2023-12-14 18:50:28', '2023-12-14 18:50:28', NULL),
(3, 'Francès', '2023-12-14 18:50:28', '2023-12-14 18:50:28', NULL),
(4, 'Alemany', '2023-12-14 18:50:28', '2023-12-14 18:50:28', NULL),
(5, 'Italià', '2023-12-14 18:50:28', '2023-12-14 18:50:28', NULL),
(6, 'Català', '2023-12-14 18:50:28', '2023-12-14 18:50:28', NULL),
(7, 'Portuguès', '2023-12-14 18:50:59', '2023-12-14 18:50:59', NULL),
(8, 'Xinès', '2023-12-14 18:50:59', '2023-12-14 18:50:59', NULL),
(9, 'Japonès', '2023-12-14 18:50:59', '2023-12-14 18:50:59', NULL),
(10, 'Rus', '2023-12-14 18:50:59', '2023-12-14 18:50:59', NULL);

INSERT INTO `tipus` (`id`, `nom_tipus`, `created_at`, `updated_at`, `data_baixa`) VALUES
(1, 'Museu', '2023-12-14 18:51:38', '2023-12-14 18:51:38', NULL),
(2, 'Hotel', '2023-12-14 18:51:38', '2023-12-14 18:51:38', NULL),
(3, 'Institucional', '2023-12-14 18:51:38', '2023-12-14 18:51:38', NULL),
(4, 'Biblioteca', '2023-12-14 18:51:38', '2023-12-14 18:51:38', NULL),
(5, 'Teatre', '2023-12-14 18:51:38', '2023-12-14 18:51:38', NULL),
(6, 'Hostal', '2023-12-14 18:51:38', '2023-12-14 18:51:38', NULL),
(7, 'Exposició d\'art', '2023-12-14 18:51:38', '2023-12-14 18:51:38', NULL),
(8, 'Mercat', '2023-12-14 18:51:38', '2023-12-14 18:51:38', NULL),
(9, 'Mirador', '2023-12-14 18:51:38', '2023-12-14 18:51:38', NULL),
(10, 'Ruina', '2023-12-14 18:51:38', '2023-12-14 18:51:38', NULL);

INSERT INTO `modalitats` (`id`, `nom_modalitat`, `created_at`, `updated_at`, `data_baixa`) VALUES
(1, 'Pintura', '2023-12-14 19:04:59', '2023-12-14 19:04:59', NULL),
(2, 'Escultura', '2023-12-14 19:04:59', '2023-12-14 19:04:59', NULL),
(3, 'Fotografia', '2023-12-14 19:04:59', '2023-12-14 19:04:59', NULL),
(4, 'Art Digital', '2023-12-14 19:04:59', '2023-12-14 19:04:59', NULL),
(5, 'Art Tèxtil', '2023-12-14 19:04:59', '2023-12-14 19:04:59', NULL),
(6, 'Art Abstracte', '2023-12-14 19:04:59', '2023-12-14 19:04:59', NULL);

INSERT INTO `serveis` (`id`, `nom_serveis`, `created_at`, `updated_at`, `data_baixa`) VALUES
(1, 'Allotjament', '2023-12-14 19:06:40', '2023-12-14 19:06:40', NULL),
(2, 'Conferències', '2023-12-14 19:06:40', '2023-12-14 19:06:40', NULL),
(3, 'Biblioteca', '2023-12-14 19:06:40', '2023-12-14 19:06:40', NULL),
(4, 'WiFi', '2023-12-14 19:06:40', '2023-12-14 19:06:40', NULL),
(5, 'Banys', '2023-12-14 19:06:40', '2023-12-14 19:06:40', NULL),
(6, 'Seguretat', '2023-12-14 19:06:40', '2023-12-14 19:06:40', NULL);

INSERT INTO `arquitectes` (`id`, `nom`, `created_at`, `updated_at`, `data_baixa`) VALUES
(1, 'Antoni Gaudí', '2023-12-14 19:07:21', '2023-12-14 19:07:21', NULL),
(2, 'Lluís Domènech i Montaner', '2023-12-14 19:07:21', '2023-12-14 19:07:21', NULL),
(3, 'Josep Puig i Cadafalch', '2023-12-14 19:07:21', '2023-12-14 19:07:21', NULL),
(4, 'Enric Miralles', '2023-12-14 19:07:21', '2023-12-14 19:07:21', NULL),
(5, 'Ricardo Bofill', '2023-12-14 19:07:21', '2023-12-14 19:07:21', NULL),
(6, 'Zaha Hadid', '2023-12-14 19:07:21', '2023-12-14 19:07:21', NULL);

INSERT INTO `illes` (`id`, `nom`, `zona`, `created_at`, `updated_at`, `data_baixa`) VALUES
(1, 'Mallorca', 'Migjorn', '2023-12-14 19:08:42', '2023-12-14 19:08:42', NULL),
(2, 'Menorca', 'Nord', '2023-12-14 19:08:42', '2023-12-14 19:08:42', NULL),
(3, 'Eivissa', 'Ponent', '2023-12-14 19:08:42', '2023-12-14 19:08:42', NULL),
(4, 'Formentera', 'Llevant', '2023-12-14 19:08:42', '2023-12-14 19:08:42', NULL),
(5, 'Tenerife', 'Oest', '2023-12-14 19:08:42', '2023-12-14 19:08:42', NULL),
(6, 'Gran Canaria', 'Est', '2023-12-14 19:08:42', '2023-12-14 19:08:42', NULL);

INSERT INTO `municipis` (`id`, `nom`, `illa_id`, `created_at`, `updated_at`, `data_baixa`) VALUES
(1, 'Palma', 1, '2023-12-14 19:10:55', '2023-12-14 19:10:55', NULL),
(2, 'Maó', 2, '2023-12-14 19:10:55', '2023-12-14 19:10:55', NULL),
(3, 'Eivissa', 3, '2023-12-14 19:10:55', '2023-12-14 19:10:55', NULL),
(4, 'Sant Francesc Xavier', 4, '2023-12-14 19:10:55', '2023-12-14 19:10:55', NULL),
(5, 'Santa Cruz de Tenerife', 5, '2023-12-14 19:10:55', '2023-12-14 19:10:55', NULL),
(6, 'Las Palmas de Gran Canaria', 6, '2023-12-14 19:10:55', '2023-12-14 19:10:55', NULL);

INSERT INTO `modalitats_idiomes` (`idioma_id`, `modalitat_id`, `traduccio`, `created_at`, `updated_at`, `data_baixa`) VALUES
(1, 1, 'Pintura', '2023-12-14 19:15:10', '2023-12-14 19:15:10', NULL),
(1, 2, 'Escultura', '2023-12-14 19:15:10', '2023-12-14 19:15:10', NULL),
(1, 3, 'Fotografía', '2023-12-14 19:15:55', '2023-12-14 19:15:55', NULL),
(2, 1, 'Painting', '2023-12-14 19:15:10', '2023-12-14 19:15:10', NULL),
(2, 2, 'Sculpture', '2023-12-14 19:15:10', '2023-12-14 19:15:10', NULL),
(2, 3, 'Photography', '2023-12-14 19:15:55', '2023-12-14 19:15:55', NULL),
(3, 1, 'Peinture', '2023-12-14 19:15:10', '2023-12-14 19:15:10', NULL),
(3, 2, 'Sculpture', '2023-12-14 19:15:10', '2023-12-14 19:15:10', NULL),
(3, 3, 'Photographie', '2023-12-14 19:15:55', '2023-12-14 19:15:55', NULL);

INSERT INTO `serveis_idiomes` (`idioma_id`, `servei_id`, `traduccio`, `created_at`, `updated_at`, `data_baixa`) VALUES
(1, 1, 'Alojamiento', '2023-12-14 19:18:16', '2023-12-14 19:18:16', NULL),
(1, 2, 'Conferencias', '2023-12-14 19:18:16', '2023-12-14 19:18:16', NULL),
(1, 3, 'Biblioteca', '2023-12-14 19:19:35', '2023-12-14 19:19:35', NULL),
(2, 1, 'Accommodation', '2023-12-14 19:18:16', '2023-12-14 19:18:16', NULL),
(2, 2, 'Conferences', '2023-12-14 19:18:16', '2023-12-14 19:18:16', NULL),
(2, 3, 'Library', '2023-12-14 19:19:35', '2023-12-14 19:19:35', NULL),
(3, 1, 'Hébergement', '2023-12-14 19:18:16', '2023-12-14 19:18:16', NULL),
(3, 2, 'Conférences', '2023-12-14 19:18:16', '2023-12-14 19:18:16', NULL),
(3, 3, 'Bibliothèque', '2023-12-14 19:19:35', '2023-12-14 19:19:35', NULL);

INSERT INTO `espais` (`id`, `nom`, `descripcio`, `carrer`, `numero`, `pis_porta`, `web`, `mail`, `grau_acc`, `data_baixa`, `arquitecte_id`, `gestor_id`, `tipus_id`, `municipi_id`, `created_at`, `updated_at`) VALUES
(2, 'Museu d\'Art Contemporani', 'Un museu dedicat a l\'art contemporani', 'Carrer de Sant Miquel', '123', '1r', 'www.mac.com', 'info@mac.com', 'alt', NULL, 1, 17, 1, 1, '2023-12-14 19:23:56', '2023-12-14 19:23:56'),
(3, 'Centre Cultural Can Alcover', 'Espai cultural multifuncional', 'Avinguda de Jaume III', '45', NULL, 'www.canalcover.com', 'info@canalcover.com', 'mig', NULL, 2, 18, 2, 2, '2023-12-14 19:23:56', '2023-12-14 19:23:56'),
(4, 'Biblioteca Municipal de Palma', 'Biblioteca pública amb una àmplia col·lecció', 'Plaça de Cort', '1', NULL, 'www.bibliopalma.com', 'info@bibliopalma.com', 'alt', NULL, 3, 3, 3, 1, '2023-12-14 19:23:56', '2023-12-14 19:23:56'),
(7, 'Jardins de Alfabia', 'Espectaculars jardins històrics', 'Carretera de Palma a Sóller', '12', NULL, 'www.alfabia.com', 'info@alfabia.com', 'mig', NULL, 6, 3, 1, 3, '2023-12-14 19:28:44', '2023-12-14 19:28:44'),
(8, 'Platja de Ses Illetes', 'Espectacular platja a Formentera', 'Ses Illetes', '3', NULL, 'www.sesilletes.com', 'info@sesilletes.com', 'alt', NULL, 1, 13, 4, 5, '2023-12-14 19:32:23', '2023-12-14 19:32:23');

INSERT INTO `valoracions` (`id`, `puntuacio`, `data`, `data_baixa`, `usuari_id`, `espai_id`, `created_at`, `updated_at`) VALUES
(2, 4, '2023-01-15', NULL, 1, 2, '2023-12-14 19:39:49', '2023-12-14 19:39:49'),
(3, 5, '2023-02-20', NULL, 11, 3, '2023-12-14 19:39:49', '2023-12-14 19:39:49'),
(4, 1, '2023-03-10', NULL, 14, 4, '2023-12-14 19:39:49', '2023-12-14 19:39:49'),
(5, 5, '2023-04-05', NULL, 16, 7, '2023-12-14 19:39:49', '2023-12-14 19:39:49'),
(6, 4, '2023-05-12', NULL, 14, 8, '2023-12-14 19:39:49', '2023-12-14 19:39:49'),
(7, 5, '2023-06-18', NULL, 16, 2, '2023-12-14 19:39:49', '2023-12-14 19:39:49');

INSERT INTO `visites` (`id`, `titol`, `descripcio`, `inscripcio_previa`, `n_places`, `total_visitants`, `data_inici`, `data_fi`, `horari`, `data_baixa`, `espai_id`, `created_at`, `updated_at`) VALUES
(1, 'Visita guiada al Museu d\'Art Contemporani', 'Descobreix les últimes obres d\'art contemporani en aquest museu emocionant', 1, 50, 0, '2023-12-20', '2023-12-22', '10:00 - 12:00', NULL, 2, '2023-12-15 09:00:00', '2023-12-15 09:00:00'),
(2, 'Taller d\'art per a nens al Centre Cultural Can Alcover', 'Una oportunitat per als nens de desenvolupar la seva creativitat mitjançant diverses activitats artístiques', 1, 20, 0, '2023-12-18', '2023-12-18', '15:00 - 17:00', NULL, 3, '2023-12-15 10:30:00', '2023-12-15 10:30:00'),
(3, 'Presentació de llibre a la Biblioteca Municipal de Palma', 'Un esdeveniment emocionant amb l\'autor del llibre presentant la seva obra', 0, 30, 0, '2023-12-19', '2023-12-19', '18:30 - 20:30', NULL, 4, '2023-12-15 12:45:00', '2023-12-15 12:45:00'),
(4, 'Recorregut botànic als Jardins de Alfabia', 'Explora la diversitat de plantes en aquests jardins històrics impressionants', 1, 15, 0, '2023-12-21', '2023-12-21', '11:00 - 13:00', NULL, 7, '2023-12-15 14:20:00', '2023-12-15 14:20:00'),
(5, 'Sessió de yoga a la Platja de Ses Illetes', 'Relaxa\'t amb una sessió de yoga a la sorra amb vistes espectaculars', 1, 40, 0, '2023-12-23', '2023-12-23', '08:00 - 09:30', NULL, 8, '2023-12-15 16:10:00', '2023-12-15 16:10:00'),
(6, 'Ruta cultural pel Museu d\'Art Contemporani', 'Explora les diferents sales i obres d\'art amb un guia expert', 1, 25, 0, '2023-12-17', '2023-12-17', '14:00 - 16:00', NULL, 2, '2023-12-15 18:45:00', '2023-12-15 18:45:00'),
(7, 'Concert al Centre Cultural Can Alcover', 'Gaudeix d\'una nit plena de música en aquest espai cultural multifuncional', 1, 100, 0, '2023-12-24', '2023-12-24', '20:00 - 22:30', NULL, 3, '2023-12-15 20:30:00', '2023-12-15 20:30:00'),
(8, 'Trobada de lectors a la Biblioteca Municipal de Palma', 'Comparteix les teves experiències literàries preferides amb altres amants de la lectura', 0, 35, 0, '2023-12-16', '2023-12-16', '17:30 - 19:30', NULL, 4, '2023-12-16 08:15:00', '2023-12-16 08:15:00'),
(9, 'Visita nocturna als Jardins de Alfabia', 'Descobreix la màgia dels jardins il·luminats a la nit', 1, 20, 0, '2023-12-22', '2023-12-22', '19:00 - 21:00', NULL, 7, '2023-12-16 10:00:00', '2023-12-16 10:00:00'),
(10, 'Dia de jocs a la Platja de Ses Illetes', 'Una jornada plena de diversió i jocs a la platja', 1, 60, 0, '2023-12-25', '2023-12-25', '12:00 - 15:00', NULL, 8, '2023-12-16 12:30:00', '2023-12-16 12:30:00');

INSERT INTO `punts_interes` (`id`, `titol`, `descripcio`, `data_baixa`, `espai_id`, `created_at`, `updated_at`) VALUES
(1, 'Mirador des del Museu d\'Art Contemporani', 'Gaudeix d\'unes vistes espectaculars de la ciutat des del terrat del museu.', NULL, 2, '2023-12-18 09:00:00', '2023-12-18 09:00:00'),
(2, 'Galeria d\'art al Centre Cultural Can Alcover', 'Explora una variada col·lecció d\'obres d\'art local i internacional.', NULL, 3, '2023-12-18 10:30:00', '2023-12-18 10:30:00'),
(3, 'Espai de lectura a la Biblioteca Municipal de Palma', 'Troba un racó tranquil per llegir el teu llibre preferit a la biblioteca.', NULL, 4, '2023-12-18 12:45:00', '2023-12-18 12:45:00'),
(4, 'Rutes de senderisme als Jardins de Alfabia', 'Descobreix les rutes pintoresques que travessen els jardins històrics.', NULL, 7, '2023-12-18 14:20:00', '2023-12-18 14:20:00'),
(5, 'Esport aquàtic a la Platja de Ses Illetes', 'Prova el windsurf o simplement gaudeix d\'un dia de sol i mar.', NULL, 8, '2023-12-18 16:10:00', '2023-12-18 16:10:00'),
(6, 'Exposició temporal al Museu d\'Art Contemporani', 'No et perdis les últimes obres d\'artistes emergents en aquesta exposició temporal.', NULL, 2, '2023-12-18 18:45:00', '2023-12-18 18:45:00'),
(7, 'Conferència cultural al Centre Cultural Can Alcover', 'Assisteix a una conferència informativa sobre temes culturals actuals.', NULL, 3, '2023-12-19 20:30:00', '2023-12-19 20:30:00'),
(8, 'Club de lectura a la Biblioteca Municipal de Palma', 'Uneix-te al club de lectura local i comparteix les teves opinions literàries.', NULL, 4, '2023-12-20 08:15:00', '2023-12-20 08:15:00'),
(9, 'Visita guiada als Jardins de Alfabia', 'Aprofundeix en la història i el disseny d\'aquests impressionants jardins.', NULL, 7, '2023-12-20 10:00:00', '2023-12-20 10:00:00'),
(10, 'Esdeveniment musical a la Platja de Ses Illetes', 'Viu una nit màgica amb música en directe sota les estrelles.', NULL, 8, '2023-12-20 12:30:00', '2023-12-20 12:30:00');

INSERT INTO `visites_punts_interes` (`punts_interes_id`, `visita_id`, `ordre`, `data_baixa`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, '2023-12-18 09:00:00', '2023-12-18 09:00:00'),
(2, 2, 1, NULL, '2023-12-18 10:30:00', '2023-12-18 10:30:00'),
(3, 3, 1, NULL, '2023-12-18 12:45:00', '2023-12-18 12:45:00'),
(4, 4, 1, NULL, '2023-12-18 14:20:00', '2023-12-18 14:20:00'),
(5, 5, 1, NULL, '2023-12-18 16:10:00', '2023-12-18 16:10:00'),
(6, 6, 1, NULL, '2023-12-18 18:45:00', '2023-12-18 18:45:00'),
(7, 7, 1, NULL, '2023-12-19 20:30:00', '2023-12-19 20:30:00'),
(8, 8, 1, NULL, '2023-12-20 08:15:00', '2023-12-20 08:15:00'),
(9, 9, 1, NULL, '2023-12-20 10:00:00', '2023-12-20 10:00:00'),
(10, 10, 1, NULL, '2023-12-20 12:30:00', '2023-12-20 12:30:00');

-- Inserts EspaisServeis

-- Inserció 1
INSERT INTO espais_serveis (servei_id, espai_id, data_baixa) VALUES (1, 2, '2022-01-01');

-- Inserció 2
INSERT INTO espais_serveis (servei_id, espai_id, data_baixa) VALUES (2, 4, '2022-02-01');

-- Inserció 3
INSERT INTO espais_serveis (servei_id, espai_id, data_baixa) VALUES (3, 3, '2022-03-01');

-- Inserts EspaisModalitats

-- Inserció 1
INSERT INTO espais_modalitats (espai_id, modalitat_id, data_baixa) VALUES (2, 1, '2022-01-01');

-- Inserció 2
INSERT INTO espais_modalitats (espai_id, modalitat_id, data_baixa) VALUES (3, 2, '2022-02-01');

-- Inserció 3
INSERT INTO espais_modalitats (espai_id, modalitat_id, data_baixa) VALUES (4, 3, '2022-03-01');

-- Inserts VisitesIdiomes

-- Inserció 1
INSERT INTO visites_idiomes (idioma_id, visita_id, traduccio, data_baixa) VALUES (1, 3, 'Traducció 1', '2022-01-01');

-- Inserció 2
INSERT INTO visites_idiomes (idioma_id, visita_id, traduccio, data_baixa) VALUES (2, 2, 'Traducció 2', '2022-02-01');

-- Inserció 3
INSERT INTO visites_idiomes (idioma_id, visita_id, traduccio, data_baixa) VALUES (3, 4, 'Traducció 3', '2022-03-01');
