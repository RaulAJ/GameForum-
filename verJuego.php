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
                if (!Usuario::compruebaValorado($_SESSION['usuario'], $id)){
                    $contenidoPrincipal .= "<h2>Valora este juego!</h2> ";
                    Usuario::aniadirValoracion($_SESSION['usuario'], $id);
                    $contenidoPrincipal .= buildFormularioValorarJuego($id);
                }
                else {
                    $contenidoPrincipal .= "<h2>Ya has valorado este juego, ¡gracias!</h2> ";
                }
            }
            else{
                $contenidoPrincipal .= "<h2>Regístrate para poder valorar este juego!</h2>";
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
