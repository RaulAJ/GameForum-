<?php

require_once 'config.php';
require_once 'vistas/helpers/publicaciones.php';
require_once 'src/foro/bd/Publicacion.php';

$tituloPagina = 'Foro';
$mensaje = '';

$contenidoPrincipal = '';

//Verificar mensajesde éxito al añadir juegos
if (isset($_GET['exito'])) {
    $mensaje = '<div class="alerta exito">La publicacion ha sido añadida con éxito.</div>';
}


// Verificar si hay mensaje de error
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case '1': // al añadir juegos
            $mensaje = '<div class="alerta error">Hubo un error al añadir la publicacion.</div>';
            break;
        case 'datosInvalidos':
            $mensaje = '<div class="alerta error">Los datos proporcionados son inválidos.</div>';
            break;
        case 'noAutorizado':
            $mensaje = '<div class="alerta error">No tienes autorización para realizar esta acción.</div>';
            break;
        default:
            break;
    }
}

if (empty($mensaje) && !isset($_GET['accion'])) {
    // Si no hay formulario activo ni mensaje de error, mostrar los juegos
    $contenidoPrincipal .= '<h1>FORO:</h1>';
    $contenidoPrincipal .= listaPublicaciones();
} 

if (isset($_GET['accion']) && $_GET['accion'] === 'agregarPublicacion') {
    //$contenidoPrincipal .= buildFormularioNoticia();
} elseif (isset($_GET['accion']) && $_GET['accion'] === 'borrarPublicacion'){
    //Noticia::borrate();
}

// Agregar mensaje a contenido principal
$contenidoPrincipal .= $mensaje;

require 'vistas/comun/layout.php';
