<?php

require_once 'config.php';
require_once 'vistas/helpers/publicaciones.php';
require_once 'src/foro/bd/Publicacion.php';

$tituloPagina = 'Foro';
$mensaje = '';

$contenidoPrincipal = '';

//Verificar mensajes de éxito
if (isset($_GET['exito'])) {
    $mensaje = '<div class="alerta exito">Acción realizada con éxito.</div>';
}


// Verificar si hay mensaje de error
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case '1':
            $mensaje = '<div class="alerta error">Hubo un error al añadir la publicacion.</div>';
            break;
        case 'datosInvalidos':
            $mensaje = '<div class="alerta error">Los datos proporcionados son inválidos.</div>';
            break;
        case 'noAutorizado':
            $mensaje = '<div class="alerta error">No tienes autorización para realizar esta acción.</div>';
            break;
        case 'errorSubida':
            $mensaje = '<div class="alerta error">Error al subir la(s) imagen(es). Comprueba los archivos e intentalo de nuevo.</div>';
            break;
        case 'errorEditar':
            $mensaje = '<div class="alerta error">Error al editar la publicación. Por favor, intentalo de nuevo.</div>';
            break;
        default:
            $mensaje = '<div class="alerta error">Error desconocido. Por favor, intentalo de nuevo.</div>';
            break;
    }
}

if (empty($mensaje) && !isset($_GET['accion'])) {
    // Si no hay formulario activo ni mensaje de error, mostrar los juegos
    $contenidoPrincipal .= '<h1>FORO:</h1>';
    $contenidoPrincipal .= listaPublicaciones();
}

if (isset($_GET['accion']) && $_GET['accion'] === 'agregarPublicacion') {
    $contenidoPrincipal .= buildFormularioPublicacion();
} elseif (isset($_GET['id']) && isset($_GET['accion']) && $_GET['accion'] === 'editarPublicacion') {
    $contenidoPrincipal .= editarFormularioPublicacion($_GET['id']);
}

// Agregar mensaje a contenido principal
$contenidoPrincipal .= $mensaje;

require 'vistas/comun/layout.php';
