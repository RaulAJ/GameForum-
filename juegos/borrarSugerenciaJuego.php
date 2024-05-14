<?php

require_once '../config.php';
require_once '../src/juegos/bd/Juego.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/imagenes/bd/Imagen.php';

// Verifica si el usuario está logueado y si se ha enviado un ID de sugerirjuego
if (estaLogado() && isset($_POST['id'])) {
    $id_sugerencia = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Obtener la sugerencia específica
    $sugerencia = Juego::obtenerSugerencia($id_sugerencia);

    // Verifica si la noticia existe y si el usuario tiene permiso para borrarla
    if ($sugerencia && $_SESSION['admin'] || $_SESSION['moderador']) {
        //borrar imagenes asociadas a la sugerencia
        $imagenes = Imagen::obtenerPorSugerenciaJuegoId($id_sugerencia);
        foreach ($imagenes as $imagen) {
            $rutaAbsoluta = RUTA_APP_ABSOLUTA . '/' . $imagen->getRuta();
            if (file_exists($rutaAbsoluta)) { // Asegurarse de que el archivo existe antes de intentar eliminarlo
                unlink($rutaAbsoluta); // Eliminar el archivo de imagen
            } else {
                error_log("Archivo no encontrado: " . $rutaAbsoluta);
            }
        }
        Juego::borraDeSugerenciasJuegos($id_sugerencia);
        Utils::redirige(Utils::buildUrl('/verSugerirJuegos.php', ['exito' => '1']));
        exit();
    } else {
        // Usuario no tiene permisos o la noticia no existe
        Utils::redirige(Utils::buildUrl('/verSugerirJuegos.php', ['error' => 'noAutorizado']));
        exit();
    }
} else {
    // Si no está logueado o no se proporcionó un ID de noticia
    Utils::redirige(Utils::buildUrl('/verSugerirJuegos.php', ['error' => 'noAutorizado']));
    exit();
}