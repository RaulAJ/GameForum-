<?php

require_once 'config.php';

$tituloPagina = 'GameForum!';

$contenidoPrincipal = <<<EOS
    <div class="bienvenida">
        <h2>Bienvenido a GameForum!</h2>
        <p>¡Aquí encontrarás todo sobre tus juegos favoritos, noticias de la industria del videojuego y mucho más!</p>
    </div>
EOS;

require 'vistas/comun/layout.php';
