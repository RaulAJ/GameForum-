<?php

require_once '../config.php';
require_once '../src/juegos/bd/Juego.php';
require_once '../vistas/helpers/autorizacion.php';

// Verifica si el usuario está logueado y si se ha enviado un ID de sugerirjuego
if (estaLogado() && isset($_POST['id'])) {
    $id_sugerencia = $_POST['id'];

    $sugerencia = Juego::obtenerSugerencia($id_sugerencia);

    if ($sugerencia && $_SESSION['admin'] || $_SESSION['moderador']) {
        Juego::crea($sugerencia->getNombreJuego(), $sugerencia->getAnioDeSalida(), $sugerencia->getDesarrollador(), $sugerencia->getGenero(), 0, $sugerencia->getDescripcion());
        Juego::borraDeSugerenciasJuegos($id_sugerencia);
        header('Location: ../verSugerirJuegos.php');
        exit();
    } else {
        // Usuario no tiene permisos o la noticia no existe
        header('Location: ../verSugerirJuegos.php?error=noAutorizado');
        exit();
    }
} else {
    // Si no está logueado o no se proporcionó un ID
    header('Location: ../verSugerirJuegos.php?error=noAutorizado');
    exit();
}
