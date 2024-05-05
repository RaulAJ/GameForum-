<?php

require_once '../config.php';
require_once '../src/foro/bd/Publicacion.php';
require_once '../vistas/helpers/autorizacion.php';

// Verifica si el usuario está logueado y si se ha enviado un ID de noticia
if (estaLogado() && isset($_POST['id'])) {
    $id_publicacion = $_POST['id'];

    // Obtén la noticia específica
    $publicacion = Publicacion::obtenerPublicacionPorId($id_publicacion);

    // Verifica si la noticia existe y si el usuario tiene permiso para borrarla
    if ($publicacion && (esMismoUsuario($publicacion->getUsuario()) || $_SESSION['admin'] || $_SESSION['moderador'])) {
        Publicacion::borraRespuestas($id_publicacion);
        Publicacion::borraPublicacion($id_publicacion);
        header('Location: ../foro.php');
        exit();
    } else {
        // Usuario no tiene permisos o la noticia no existe
        header('Location: ../foro.php?error=noAutorizado');
        exit();
    }
} else {
    // Si no está logueado o no se proporcionó un ID de noticia
    header('Location: ../foro.php?error=noAutorizado');
    exit();
}
