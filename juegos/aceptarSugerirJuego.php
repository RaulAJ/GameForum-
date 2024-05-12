<?php

require_once '../config.php';
require_once '../src/juegos/bd/Juego.php';
require_once '../src/imagenes/bd/Imagen.php';
require_once '../vistas/helpers/autorizacion.php';

// Verifica si el usuario está logueado y si se ha enviado un ID de sugerirjuego
if (estaLogado() && isset($_POST['id'])) {
    $id_sugerencia = $_POST['id'];

    // Obtener la sugerencia
    $sugerencia = Juego::obtenerSugerencia($id_sugerencia);
    
    if ($sugerencia && ($_SESSION['admin'] || $_SESSION['moderador'])) {
        // Crear un nuevo juego a partir de la sugerencia
        $nuevoJuegoId = Juego::crea($sugerencia->getNombreJuego(), $sugerencia->getAnioDeSalida(), $sugerencia->getDesarrollador(), $sugerencia->getGenero(), 0, 0, $sugerencia->getDescripcion());

        // Obtener todas las imágenes asociadas con la sugerencia

        $imagenes = Imagen::obtenerPorSugerenciaJuegoId($id_sugerencia);
        foreach ($imagenes as $imagen) {
            // Actualizar cada imagen para asociarla con el nuevo juego en lugar de la sugerencia
            Imagen::actualizaImagenJuegoId($imagen->getId(), $nuevoJuegoId);
        }

        error_log("[aceptarsugerir]Intentando borrar sugerencia");
        // Eliminar la sugerencia de la base de datos
        Juego::borraDeSugerenciasJuegos($id_sugerencia);
        error_log("[aceptarsugerir]exito");
        
        //header('Location: ../verSugerirJuegos.php?exito=1');
        Utils::redirige(Utils::buildUrl('/verSugerirJuegos.php', ['exito' => '1']));
        exit();
    } else {
        //header('Location: ../verSugerirJuegos.php?error=noAutorizado');
        Utils::redirige(Utils::buildUrl('/verSugerirJuegos.php', ['error' => 'noAutorizado']));
        exit();
    }
} else {
    Utils::redirige(Utils::buildUrl('/verSugerirJuegos.php', ['error' => 'noAutorizado']));
    exit();
}
