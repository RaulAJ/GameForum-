<?php

require_once 'config.php';
require_once 'vistas/helpers/juegos.php';
require_once 'src/juegos/bd/Juego.php';

$tituloPagina = 'Juegos Sugeridos';
$contenidoPrincipal = '';

// Manejo de mensajes de éxito y error
if (isset($_GET['exito'])) {
    switch ($_GET['exito']) {
        case '1':
            $contenidoPrincipal .= '<p class="success">Accion realizada con éxito.</p>';
            break;
    }
}

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'errorAceptarSugerencia':
            $contenidoPrincipal .= '<p class="error">Hubo un problema al aceptar la sugerencia del juego. Puede que el juego ya exista.</p>';
            break;
        case 'noAutorizado':
            $contenidoPrincipal .= '<p class="error">No tienes permisos para realizar esta acción.</p>';
            break;
        case 'datosInvalidos':
            $contenidoPrincipal .= '<p class="error">Datos inválidos. Por favor, verifica los campos e intenta nuevamente.</p>';
            break;
    }
}

$contenidoPrincipal .= '<div><h1>Juegos Sugeridos:</h1></div>';
$contenidoPrincipal .= listaSugerencias();

require 'vistas/comun/layout.php';
