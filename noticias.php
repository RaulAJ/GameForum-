<?php

require_once 'config.php';
require_once 'vistas/helpers/noticias.php';
require_once 'src/noticias/bd/Noticia.php';

$tituloPagina = 'Noticias';
$mensaje = '';

$contenidoPrincipal = '';

//Verificar mensajesde éxito al añadir juegos
if (isset($_GET['exito'])) {
    $mensaje = '<div class="alerta exito">La noticia ha sido añadida con éxito.</div>';
}


// Verificar si hay mensaje de error
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case '1': // al añadir juegos
            $mensaje = '<div class="alerta error">Hubo un error al añadir la noticia.</div>';
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
    $contenidoPrincipal .= '<h1>NOTICIAS:</h1>';
    $contenidoPrincipal .= listaNoticias();
}

if (isset($_GET['accion']) && $_GET['accion'] === 'agregarNoticia') {
    $contenidoPrincipal .= buildFormularioNoticia();
}

// Agregar mensaje a contenido principal
$contenidoPrincipal .= $mensaje;

require 'vistas/comun/layout.php';
