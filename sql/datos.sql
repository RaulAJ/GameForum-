-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-05-2024 a las 00:07:45
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gameforum`
--

--
-- Volcado de datos para la tabla `foro`
--

INSERT INTO `foro` (`ID`, `Titulo`, `Usuario`, `Juego`, `Tipo`, `Fecha`, `Contenido`) VALUES
(1, 'Ayuda no puedo pasar', 'dacendej', 'Dark Souls', 'Duda', '2007-03-24', 'Llevo 5 días intentando pasarme las gargolas pero no consigo matar a la segunda. ¿Algun truco para que no me mate el fuego? Gracias!'),
(2, 'Cómo hacer un portal', 'dacendej', 'Minecraft', 'Duda', '2010-03-24', 'Primero has de hacerte con un pico de diamante para poder picar 10 bloques de obsidiana, luego tienes que ponerlos en forma de portal y prender la parte inferior con un mechero. Listo! Si el portal se ha puesto en morado, cruzalo y estaras en el nether.'),
(3, 'Mejor configuracion?', 'dacendej', 'CS:GO', 'Duda', '2010-03-24', '¿Alguien sabe cual es la mejor configuracion para un PC de gama media? No consigo mas de 30 fps.');

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`id`, `ruta`, `descripcion`, `noticia_id`, `foro_id`, `respuestas_id`, `videojuego_id`, `sugerencia_juego_id`) VALUES
(59, 'uploads/img_664231a012bab9.13320437.jpg', 'cb.jpg', 3, NULL, NULL, NULL, NULL),
(60, 'uploads/img_664231d0ea9604.55462772.png', 'sony.png', 4, NULL, NULL, NULL, NULL),
(61, 'uploads/img_6642336881b7f6.19028983.jpg', 'mc.jpg', NULL, NULL, NULL, 29, NULL),
(62, 'uploads/img_664233a0249b00.98425338.png', 'csgo.png', NULL, NULL, NULL, 30, NULL),
(63, 'uploads/img_66423441a32a24.47022241.png', 'Team-Fortress-2-logo.png', NULL, NULL, NULL, 32, NULL),
(65, 'uploads/img_664284ba062bc0.66795760.png', 'nether.png', NULL, 2, NULL, NULL, NULL),
(66, 'uploads/img_6642854c5041b3.10403879.jpg', 'gargola.jpg', NULL, 1, NULL, NULL, NULL),
(67, 'uploads/img_6642865f7b2ec8.01488503.png', 'nintengo.png', 2, NULL, NULL, NULL, NULL),
(68, 'uploads/img_66428684a81934.09304737.png', 'xbox.png', 1, NULL, NULL, NULL, NULL),
(69, 'uploads/img_66428904eed545.70223655.jpg', 'darksouls.jpg', NULL, NULL, NULL, 35, NULL),
(70, 'uploads/img_664289b8eb6cd7.07543614.png', 'fortnite.png', NULL, NULL, NULL, 36, NULL),
(71, 'uploads/img_66428a8b0a0181.97612991.jpg', 'picopark.jpg', NULL, NULL, NULL, 37, NULL),
(72, 'uploads/img_66428b1c09f184.20296403.jpg', 'cr.jpg', NULL, NULL, NULL, 38, NULL),
(73, 'uploads/img_66428b827ee006.31142770.png', 'candy.png', NULL, NULL, NULL, 39, NULL),
(74, 'uploads/img_66428c0d77c603.25151924.png', 'gta.png', NULL, NULL, NULL, 40, NULL),
(75, 'uploads/img_66428ccf0b1eb9.51625044.png', 'sims.png', NULL, NULL, NULL, NULL, 9),
(76, 'uploads/img_66428d4c1b8795.36626182.png', 'fifa.png', NULL, NULL, NULL, NULL, 10),
(77, 'uploads/img_66428dd93c8861.86201022.jpg', 'sekiro.jpg', NULL, NULL, NULL, NULL, 11),
(78, 'uploads/img_66428e2268d264.13099922.png', 'brawl.png', NULL, NULL, NULL, NULL, 12);

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`ID`, `Titulo`, `Usuario`, `Fecha`, `Contenido`) VALUES
(1, 'Xbox Game Pass anuncia un juego por sorpresa', 'dacendej', '2007-03-24', 'A los miembros de Xbox Game Pass no se nos da un respiro con tantos títulos como tenemos disponibles en el catálogo. Sin embargo, el equipo responsable del servicio sigue trabajando para añadirnos más juegos al listado de pendientes. Hace escasos días conocimos los títulos de todos aquellos que llegarán durante la priemera quincena de marzo, pero parece que se dejaron uno en el tintero.No es habitual que esto ocurra, pero al equipo de Xbox Game Pass le gusta juguetear con sus planes y sorprender de vez en cuando a los miembros de la suscripción. Y así es como la cuenta oficial del servicio ha anunciado por sorpresa y sin que nadie lo esperara, una nueva entrada que llega el 11 de marzo, y es NBA 2K24.NBA 2K24 nos sumerge en la esencia del baloncesto con una experiencia que abarca el pasado, presente y futuro de este deporte con un amplio abanico de modos de juego: Disfruta de la acción sin límites y personaliza tu '),
(2, 'Nintendo pone fecha a la próxima película de Super', 'dacendej', '2024-03-10', 'La gente vuelve a sonreír, se ha anunciado en el Mario Day muchas novedades sobre el futuro de esta franquicia que encantarán a los jugadores y a las millones de personas que fueron a ver Super Mario Bros La Película al cine. Hace varios meses os hablamos de que no esperes pronto la próxima película de Super Mario Bros, pues la huelga de guionistas y actores había retrasado los planes, pero ahora ya tenemos fecha definitiva para esta producción.&#13;&#10;En el canal de YouTube de Nintendo España Shigeru Miyamoto ha hablado sobre  las próximas novedades de la exitosa e histórica franquicia Mario. Lo más destacado ha sido que tanto Nintendo como Illumination ya están &#34;produciendo una nueva película animada basada en el mundo de Super Mario Bros&#34;. Está previsto que &#34;se estrene el 3 de abril de 2026 en los EE. UU. y en muchos mercados adicionales a nivel mundial&#34;, según lee en un comunicado en la web oficial.'),
(3, 'Nuevo DLC anunciado para Cyberpunk 2077', 'rauare01', '2024-04-11', 'CD Projekt Red ha anunciado un nuevo DLC para Cyberpunk 2077 que promete expandir aún más el mundo del juego. Según la compañía, este DLC incluirá nuevas misiones, personajes y contenido adicional que ampliará la experiencia de juego para los jugadores. Aunque aún no se han revelado detalles específicos sobre el contenido del DLC, los fanáticos están emocionados por la noticia y esperan ansiosos más información por parte de CD Projekt Red.'),
(4, 'Sony revela detalles sobre un próximo juego', 'dacendej', '2024-04-11', 'Durante una transmisión en vivo, Sony ha revelado detalles emocionantes sobre el próximo juego de la saga God of War. El nuevo título, titulado God of War: Ragnarok, continuará la historia de Kratos y su hijo Atreus en su viaje por los reinos nórdicos. Según los desarrolladores, el juego ofrecerá una experiencia épica con gráficos impresionantes, combate mejorado y una narrativa envolvente. Los fanáticos de la serie están emocionados por este anuncio y esperan con ansias el lanzamiento del juego en el futuro cercano.');

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`ID`, `ID foro`, `Usuario`, `Fecha`, `Contenido`) VALUES
(1, 1, 'rauare01', '2007-03-24', 'Te recomiendo ir al herrero y mejorar el arma a +5. Estuve en tu misma situacion y me apañe con eso. Pruebalo y me cuentas.'),
(2, 1, 'josev27', '2010-03-24', 'No se bro simplemente mejora, yo me lo pase a la primera XD'),
(3, 2, 'dacendej', '2011-03-24', 'Wow, no sabia que era tan facil. Gracias por la guia tio!'),
(4, 2, 'rauare01', '2012-06-06', 'Buahh, gracias por la ayuda, no encontraba en ningún lado como era!');

--
-- Volcado de datos para la tabla `sugerenciasjuegos`
--

INSERT INTO `sugerenciasjuegos` (`ID`, `Juego`, `Año de salida`, `Desarrollador`, `Genero`, `Descripcion`) VALUES
(9, 'Sims 4', 2014, 'EA', 'Simulación', 'El jugador controla la vida de uno o más personajes, satisfaciendo sus deseos y necesidades. La acción tiene lugar en una ciudad que consta de lotes residenciales y públicos que está habitada por Sims. Cada personaje está dotado de inteligencia y emociones, tiene una apariencia y personalidad únicas.5​ Las relaciones entre las personas se miden en dos escalas, lo que refleja la fuerza de la amistad y el afecto romántico. La interfaz de usuario con el sim se implementa en los modos de tercera​ y '),
(10, 'EA Sports FC 24', 2023, 'EA', 'Deportes', 'EA Sports FC 24 es un videojuego de fútbol, desarrollado por EA, y publicado por EA Sports. Este juego marca la primera entrega de la serie EA Sports FC, tras la conclusión de la asociación de EA con FIFA.1​3​ Fue lanzado a nivel mundial el 29 de septiembre de 2023 para Nintendo Switch, PlayStation 4, PlayStation 5, Windows, Xbox One y Xbox Series X/S.'),
(11, 'Sekiro', 2019, 'FromSoftwa', 'Aventura', 'En un reinventado período Sengoku de finales del siglo xvi en Japón, el señor de la guerra Isshin Ashina organizó un golpe sangriento y tomó el control de la tierra de Ashina del Ministerio del Interior. Durante este tiempo, un shinobi errante llamado Ukonzaemon Usui, conocido por muchos como Búho, adoptó a un niño huérfano sin nombre, al que nombró Lobo, y lo entrenó en los caminos del shinobi.'),
(12, 'Brawl Stars', 2018, 'Supercell', 'Battle Roy', 'El objetivo principal del juego es conseguir la mayor cantidad de trofeos y brawlers (los personajes de Brawl Stars), para progresar en un camino de trofeos. Los jugadores entran a diferentes modos de juego, con diferentes brawlers, cada uno con habilidades únicas, que luchan en diferentes modos de juego para subirlos de rango, de trofeos y de maestría.');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Usuario`, `Nombre Completo`, `Edad`, `Correo`, `Contraseña`, `Experto`, `Moderador`, `Admin`, `JuegosValorados`) VALUES
('dacendej', 'David Cendejas', 20, 'dacendej@ucm.es', 'David1234', 1, 1, 1, ', 34, 1, 35, 36, 37, 38, 39, 40'),
('jorglo03', 'Jorge Lopez', 20, 'jorglo03@ucm.es', 'NodoFantasma', 1, 0, 0, ', 34, 40, 35, 39, 38'),
('josev27', 'Jose Galvez', 20, 'josegalvezv27@gmail.com', 'HackerBOYxx', 0, 0, 0, ', 32'),
('rauare01', 'Raul Arellano', 20, 'rauare01@ucm.es', 'AreRaul99', 1, 1, 0, '');

--
-- Volcado de datos para la tabla `videojuegos`
--

INSERT INTO `videojuegos` (`ID`, `Juego`, `Año de salida`, `Desarrollador`, `Genero`, `Nota`, `nResenias`, `Descripcion`) VALUES
(29, 'Minecraft', 2009, 'Mojang', 'Aventura', 9.5, 2, 'Minecraft es un videojuego sandbox enfocado en permitirle al jugador explorar y modificar un mundo generado dinámicamente hecho de bloques de un metro cúbico. Es mantenido por Mojang Studios, que forma parte de Xbox Game Studios, que a su vez es parte de Microsoft.'),
(30, 'CS:GO', 2012, 'Valve', 'FPS', 9.7, 0, 'Global Offensive, al igual que los juegos anteriores de la serie Counter-Strike, es un juego de disparos en primera persona multijugador basado en objetivos. Dos equipos opuestos, los terroristas y los antiterroristas, compiten en modos de juego para completar objetivos repetidamente, como asegurar un lugar para colocar o desactivar una bomba y rescatar o capturar rehenes.'),
(32, 'Team Fortress 2', 2006, 'Valve', 'FPS', 9.2, 0, 'Como sus predecesores, Team Fortress 2 cuenta con dos equipos rivales, Reliable Excavation & Demolition (acrónimo RED y representado por el color rojo, red en inglés) y Builders League United (acrónimo BLU y representado por el color azul, blue en inglés), que compiten por un objetivo principal.8​ Los jugadores pueden elegir a una de las nueve clases de personajes para jugar en uno de estos equipos, cada uno con sus ventajas, debilidades y armas exclusivas.'),
(35, 'Dark Souls', 2011, 'FromSoftwa', 'Acción', 9.5, 2, 'El juego tiene lugar en el reino ficticio de Lordran. Los jugadores asumen el papel de un personaje humano maldito que se propone descubrir el destino de los humanos no muertos como ellos. La trama de Dark Souls se cuenta principalmente a través de detalles ambientales, texto de sabor de los objetos del juego y diálogos con personajes no jugables (PNJ).'),
(36, 'Fortnite', 2017, 'Epic Games', 'Battle Roy', 8, 1, 'Es un juego de tipo batalla real en el que compiten hasta cien jugadores en solitario, dúos, tríos o escuadrones. Los jugadores saltan de un autobús que cruza el mapa en el momento que deseen, y empiezan sin armas. Cuando aterrizan, deben buscar armas, objetos útiles y recursos, evitando que los maten mientras atacan a otros jugadores. La acción se divide en rondas con una duración determinada. Al acabar cada ronda, el área segura del mapa (la zona) se reduce en tamaño debido a una tormenta en c'),
(37, 'Pico Park', 2019, 'TECOPARK', 'Casual', 7, 1, 'Pico Park es un juego de rompecabezas de acción multijugador cooperativo local/en línea para 2 a 8 jugadores (de 2 a 10 jugadores en la versión clásica). El objetivo del juego es conseguir una llave y abrir la puerta cerrada al final del mapa. Los jugadores deben cooperar para alcanzar el objetivo, pero también tienen la capacidad de evitar alcanzar este objetivo, por ejemplo, bloqueando el movimiento de otros jugadores.'),
(38, 'Clash Royale', 2016, 'Supercell', 'Tower Defe', 5.5, 2, 'Clash Royale es un videojuego de tower rush que enfrenta a los jugadores en juegos con dos o cuatro jugadores (1v1 o 2v2) en los que el objetivo es destruir las torres enemigas (si es destruida la Torre del Rey se acaba la partida).  Después de tres minutos, si ambos jugadores / equipos tienen el mismo número de coronas o ninguna, el partido continúa en un período de tiempo extra de 1 minuto (más dependiendo de la arena) y el jugador que destruye una torre enemiga, gana instantáneamente. Si no s'),
(39, 'Candy Crush', 2012, 'King', 'Lógica', 5.5, 2, 'Candy Crush Saga es un videojuego de combinación de fichas, en el que el juego principal se basa en mover dos caramelos adyacentes de entre varios en el tablero de juego, para formar una fila o columna de al menos 3 caramelos del mismo color. En esta partida, los caramelos emparejados se retiran del tablero, y los caramelos encima de ellos caen en los espacios vacíos, con nuevos caramelos que aparecen en la parte superior del tablero. Esto puede crear un nuevo conjunto de caramelos emparejados, '),
(40, 'GTA V', 2013, 'Rockstar G', 'Acción', 8.5, 2, 'Grand Theft Auto V es un videojuego de acción-aventura de mundo abierto desarrollado por el estudio escocés Rockstar North y distribuido por Rockstar Games. Este título revolucionario hizo su debut el 17 de septiembre de 2013 en las consolas Xbox 360 y PlayStation 3.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
