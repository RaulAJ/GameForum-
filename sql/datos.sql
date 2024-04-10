TRUNCATE TABLE `foro`;
TRUNCATE TABLE `noticias`;
TRUNCATE TABLE `respuestas`;
TRUNCATE TABLE `sugerenciasjuegos`;
TRUNCATE TABLE `usuarios`;
TRUNCATE TABLE `videojuegos`;

--
-- Volcado de datos para la tabla `foro`
--

INSERT INTO `foro` (`ID`, `Titulo`, `Usuario`, `Juego`, `Tipo`, `Fecha`, `Contenido`) VALUES
(1, 'Ayuda no puedo pasar', 'dacendej', 'Dark Souls', 'Duda', '2007-03-24', 'Llevo 5 días intentando pasarme las gargolas pero no consigo matar a la segunda. ¿Algun truco para que no me mate el fuego? Gracias!'),
(2, 'Como hacer un portal', 'jorglo03', 'Minecraft', 'Guia', '2010-03-24', 'Primero has de hacerte con un pico de diamante para poder picar 10 bloques de obsidiana, luego tienes que ponerlos en forma de portal y prender la parte inferior con un mechero. Listo! Si el portal se ha puesto en morado, cruzalo y estaras en el nether.'),
(3, 'Mejor configuracion?', 'dacendej', 'Fortnite', 'Duda', '2010-03-24', '¿Alguien sabe cual es la mejor configuracion para un PC de gama media? No consigo mas de 30 fps.');

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`ID`, `Titulo`, `Usuario`, `Fecha`, `Contenido`) VALUES
(1, 'Xbox Game Pass anuncia un juego por sorpresa', 'dacendej', '2007-03-24', 'A los miembros de Xbox Game Pass no se nos da un respiro con tantos títulos como tenemos disponibles en el catálogo. Sin embargo, el equipo responsable del servicio sigue trabajando para añadirnos más juegos al listado de pendientes. Hace escasos días conocimos los títulos de todos aquellos que llegarán durante la priemera quincena de marzo, pero parece que se dejaron uno en el tintero.\r\n\r\nNo es habitual que esto ocurra, pero al equipo de Xbox Game Pass le gusta juguetear con sus planes y sorprender de vez en cuando a los miembros de la suscripción. Y así es como la cuenta oficial del servicio ha anunciado por sorpresa y sin que nadie lo esperara, una nueva entrada que llega el 11 de marzo, y es NBA 2K24.\r\n\r\nNBA 2K24 nos sumerge en la esencia del baloncesto con una experiencia que abarca el pasado, presente y futuro de este deporte con un amplio abanico de modos de juego: Disfruta de la acción sin límites y personaliza tu Mi JUGADOR en Mi CARRERA. Colecciona leyendas para formar tu equ'),
(2, 'Nintendo pone fecha a la próxima película de Super', 'dacendej', '2024-03-10', 'La gente vuelve a sonreír, se ha anunciado en el Mario Day muchas novedades sobre el futuro de esta franquicia que encantarán a los jugadores y a las millones de personas que fueron a ver Super Mario Bros La Película al cine. Hace varios meses os hablamos de que no esperes pronto la próxima película de Super Mario Bros, pues la huelga de guionistas y actores había retrasado los planes, pero ahora ya tenemos fecha definitiva para esta producción.\r\nEn el canal de YouTube de Nintendo España Shigeru Miyamoto ha hablado sobre  las próximas novedades de la exitosa e histórica franquicia Mario. Lo más destacado ha sido que tanto Nintendo como Illumination ya están \"produciendo una nueva película animada basada en el mundo de Super Mario Bros\". Está previsto que \"se estrene el 3 de abril de 2026 en los EE. UU. y en muchos mercados adicionales a nivel mundial\", según lee en un comunicado en la web oficial.');

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`ID`, `ID foro`, `Usuario`, `Fecha`, `Contenido`) VALUES
(1, 1, 'rauare01', '2007-03-24', 'Te recomiendo ir al herrero y mejorar el arma a +5. Estuve en tu misma situacion y me apañe con eso. Pruebalo y me cuentas.'),
(2, 1, 'josev27', '2010-03-24', 'No se bro simplemente mejora, yo me lo pase a la primera XD'),
(3, 2, 'dacendej', '2011-03-24', 'Wow, no sabia que era tan facil. Gracias por la guia tio!');

--
-- Volcado de datos para la tabla `sugerenciasjuegos`
--

INSERT INTO `sugerenciasjuegos` (`ID`, `Juego`, `Año de salida`, `Desarrollador`, `Genero`, `Descripcion`) VALUES
(1, 'Dark Souls', 2011, 'From Softw', 'RPG', 'Dark Souls 1 es el primer juego de la saga Dark Souls. El juego tiene lugar en el reino de Lordran, '),
(2, 'Minecraft', 2011, 'Mojang', 'Sandbox', 'Minecraft es un videojuego sandbox enfocado en permitirle al jugador explorar y modificar un mundo generado dinámicamente hecho de bloques de un metro cúbico. Es mantenido por Mojang Studios, que forma parte de Xbox Game Studios, que a su vez es parte de Microsoft.'),
(3, 'ASDFGHJKL', 1111, 'Yo', 'RPG', 'Prueba de juego no valido'),
(4, 'Fortnite', 2017, 'Epic Games', 'Battle Roy', 'Fortnite es un mundo de experiencias múltiples. Dejaos caer en la isla y competid hasta ser los últimos jugadores (o equipos) que queden en pie. Cread una isla personalizada con vuestras propias reglas. Quedad con vuestros amigos en una isla creada por una de vuestras amistades. O eliminad hordas de monstruos con otros jugadores para salvar el mundo.');

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Usuario`, `Nombre Completo`, `Edad`, `Correo`, `Contraseña`, `Experto`, `Moderador`, `Admin`) VALUES
('dacendej', 'David Cendejas', 20, 'dacendej@ucm.es', 'David1234', 1, 1, 1),
('jorglo03', 'Jorge Lopez', 20, 'jorglo03@ucm.es', 'NodoFantasma', 1, 0, 0),
('josev27', 'Jose Galvez', 20, 'josegalvezv27@gmail.com', 'HackerBOYxx', 0, 0, 0),
('rauare01', 'Raul Arellano', 20, 'rauare01@ucm.es', 'AreRaul99', 1, 1, 0);

--
-- Volcado de datos para la tabla `videojuegos`
--

INSERT INTO `videojuegos` (`ID`, `Juego`, `Año de salida`, `Desarrollador`, `Genero`, `Nota`, `nResenias`, `Descripcion`) VALUES
(1, 'Dark Souls', 2011, 'From Softw', 'RPG', 8, 1, 'Dark Souls 1 es el primer juego de la saga Dark Souls. El juego tiene lugar en el reino de Lordran, '),
(2, 'Minecraft', 2011, 'Mojang', 'Sandbox', 10, 2, 'Minecraft es un videojuego sandbox enfocado en permitirle al jugador explorar y modificar un mundo generado dinámicamente hecho de bloques de un metro cúbico. Es mantenido por Mojang Studios, que forma parte de Xbox Game Studios, que a su vez es parte de Microsoft.'),
(3, 'Fortnite', 2017, 'Epic Games', 'Battle Roy', 5, 10, 'Fortnite es un mundo de experiencias múltiples. Dejaos caer en la isla y competid hasta ser los últimos jugadores (o equipos) que queden en pie. Cread una isla personalizada con vuestras propias reglas. Quedad con vuestros amigos en una isla creada por una de vuestras amistades. O eliminad hordas de monstruos con otros jugadores para salvar el mundo.');
