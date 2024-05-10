<?php

require_once 'config.php';
require_once 'vistas/helpers/juegos.php';
require_once 'src/juegos/bd/Juego.php';

$tituloPagina ='Juegos sugeridos';
$contenidoPrincipal = '';

$contenidoPrincipal .= 
'<div>
<h1>JUEGOS SUGERIDOS:</h1>
</div>';
$contenidoPrincipal .= listaSugerencias();

require 'vistas/comun/layout.php';
