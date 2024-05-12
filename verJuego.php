<?php

require_once 'config.php';
require_once 'vistas/helpers/juegos.php';

$tituloPagina = 'Detalles del juego';
$mensaje = ''; 
$contenidoPrincipal = '';

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if ($id) {
        $detallesJuego = mostrarDetallesJuego($id);
        if ($detallesJuego) {
            $contenidoPrincipal .= $detallesJuego;
            if (estaLogado()) {
                $contenidoPrincipal .= buildFormularioValorarJuego($id);
            }
        } else {
            $mensaje = "El juego solicitado no fue encontrado.";
        }
    } else {
        $mensaje = "Identificador de juego inválido.";
    }
} else {
    $mensaje = "No se proporcionó un identificador de juego.";
}
$contenidoPrincipal .= $mensaje;

require 'vistas/comun/layout.php';
