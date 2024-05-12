<?php

require_once 'config.php';
require_once 'vistas/helpers/noticias.php';
require_once 'src/noticias/bd/Noticia.php';

$tituloPagina = 'Noticias';
$mensaje = '';

$contenidoPrincipal = '';

//Verificar mensajes de éxito
if (isset($_GET['exito'])) {
    $mensaje = '<div class="alerta exito">Acción realizada con éxito.</div>';
}

// Verificar si hay mensaje de error
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'noAutorizado':
            $mensaje = '<div class="alerta error">No tienes autorización para realizar esta acción.</div>';
            break;
        case 'errorSubida':
            $mensaje = '<div class="alerta error">Error al subir la(s) imagen(es). Comprueba los archivos e intentalo de nuevo.</div>';
            break;
        case 'datosInvalidos':
            $mensaje = '<div class="alerta error">Los datos proporcionados son inválidos. Intentalo de nuevo</div>';
            break;
        default:
            $mensaje = '<div class="alerta error">Error desconocido. Por favor, intentalo de nuevo.</div>';
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
} elseif (isset($_GET['id']) && isset($_GET['accion']) && $_GET['accion'] === 'editarNoticia') {
    $contenidoPrincipal .= editarFormularioNoticia($_GET['id']);
}

// Agregar mensaje a contenido principal
$contenidoPrincipal .= $mensaje;

require 'vistas/comun/layout.php';
