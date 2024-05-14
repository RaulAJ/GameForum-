<?php

require_once '../config.php';
require_once '../src/noticias/bd/Juego.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/imagenes/bd/Imagen.php';

// Verifica si el usuario está logueado y si se ha enviado un ID de noticia
if (estaLogado() && isset($_POST['id'])) {
    $id_juego = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Obtener la noticia específica
    $juego = Juego::obtenerJuego($id_juego);

    // Verifica si la noticia existe y si el usuario tiene permiso para borrarla
    if ($juego && ($_SESSION['admin'] || $_SESSION['moderador'])) {
        //borrar imagenes asociadas al juego
        $imagenes = Imagen::obtenerPorVideojuegoId($id_juego);
        foreach ($imagenes as $imagen) {
            $rutaAbsoluta = RUTA_APP_ABSOLUTA . '/' . $imagen->getRuta();
            if (file_exists($rutaAbsoluta)) { // Asegurarse de que el archivo existe antes de intentar eliminarlo
                unlink($rutaAbsoluta); // Eliminar el archivo de imagen
            } else {
                error_log("Archivo no encontrado: " . $rutaAbsoluta);
            }
        }

        Juego::borraDeVideojuegos($id_juego);
        Utils::redirige(Utils::buildUrl('/topJuegos.php', ['exito' => '1']));
        exit();
    } else {
        // Usuario no tiene permisos o juego no existe
        Utils::redirige(Utils::buildUrl('/topJuegos.php', ['error' => 'noAutorizado']));
        exit();
    }
} else {
    // Si no está logueado o no se proporcionó un ID de noticia
    Utils::redirige(Utils::buildUrl('/topJuegos.php', ['error' => 'noAutorizado']));
    exit();
}
