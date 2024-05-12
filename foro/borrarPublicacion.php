<?php

require_once '../config.php';
require_once '../src/foro/bd/Publicacion.php';
require_once '../src/respuestas/bd/Respuesta.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/imagenes/bd/Imagen.php';

// Verifica si el usuario está logueado y si se ha enviado un ID de noticia
if (estaLogado() && isset($_POST['id'])) {
    $id_publicacion = $_POST['id'];

    // Obtén la noticia específica
    $publicacion = Publicacion::obtenerPublicacionPorId($id_publicacion);

    // Verifica si la noticia existe y si el usuario tiene permiso para borrarla
    if ($publicacion && (esMismoUsuario($publicacion->getUsuario()) || $_SESSION['admin'] || $_SESSION['moderador'])) {
        
        $imagenes = Imagen::obtenerPorForoId($id_publicacion);
        foreach ($imagenes as $imagen) {
            $rutaAbsoluta = RUTA_APP_ABSOLUTA . '/' . $imagen->getRuta();
            if (file_exists($rutaAbsoluta)) { // Asegurarse de que el archivo existe antes de intentar eliminarlo
                unlink($rutaAbsoluta); // Eliminar el archivo de imagen
            } else {
                error_log("Archivo no encontrado: " . $rutaAbsoluta);
            }
        }
        Respuesta::borraRespuestas($id_publicacion);
        Publicacion::borraPublicacion($id_publicacion);
        Utils::redirige(Utils::buildUrl('/foro.php', ['exito' => '1']));
        exit();
    } else {
        // Usuario no tiene permisos o la noticia no existe
        Utils::redirige(Utils::buildUrl('/foro.php', ['error' => 'noAutorizado']));
        exit();
    }
} else {
    // Si no está logueado o no se proporcionó un ID de noticia
    Utils::redirige(Utils::buildUrl('/foro.php', ['error' => 'noAutorizado']));
    exit();
}
