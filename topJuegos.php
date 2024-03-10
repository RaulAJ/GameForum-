<title>Top Juegos</title>
<?php

require_once 'config.php';
require_once 'vistas/helpers/juegos.php';
require_once 'src/juegos/bd/Juego.php'; //quitar

$tituloPagina = 'Top Juegos';
$mensaje = ''; // Mensaje que se mostrará al usuario

$contenidoPrincipal = '';

//Verificar mensajes
if (isset($_GET['exito'])) {
    $mensaje = '<div class="alerta exito">El juego ha sido añadido con éxito.</div>';
}

// Verificar si hay mensaje de error
if (isset($_GET['error'])) {
    if ($_GET['error'] == '1') {
        $mensaje = '<div class="alerta error">Hubo un error al añadir el juego.</div>';
    } elseif ($_GET['error'] == 'datosInvalidos') {
        $mensaje = '<div class="alerta error">Los datos proporcionados son inválidos.</div>';
    }
}

// Verificar si no hay formulario activo ni mensaje de error
if (empty($mensaje) && !isset($_GET['accion'])) {
    // Si no hay formulario activo ni mensaje de error, mostrar los juegos
    $contenidoPrincipal .= '<h1>MEJORES JUEGOS:</h1>';
    $contenidoPrincipal .= listaJuegos();
}

//Formularios para agregar/sugerir juegos
if (isset($_GET['accion']) && $_GET['accion'] === 'agregarJuego') {
    $contenidoPrincipal .= buildFormularioAgregarJuego();
} elseif (isset($_GET['accion']) && $_GET['accion'] === 'sugerirJuego') {
    $contenidoPrincipal .= buildFormularioSugerirJuego();
}

// Agregar mensaje a contenido principal
$contenidoPrincipal .= $mensaje;

require 'vistas/comun/layout.php';
