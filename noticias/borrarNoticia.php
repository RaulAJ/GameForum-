<?php

require_once '../config.php';
require_once '../src/noticias/bd/Noticia.php';
require_once '../vistas/helpers/autorizacion.php';

// Verifica si el usuario está logueado y si se ha enviado un ID de noticia
if (estaLogado() && isset($_GET['id'])) {
    $id_noticia = $_GET['id'];

    // Obtén la noticia específica
    $noticia = Noticia::obtenerNoticiaPorId($id_noticia);

    // Verifica si la noticia existe y si el usuario tiene permiso para borrarla
    if ($noticia && (esMismoUsuario($noticia->getUsuario()) || $_SESSION['admin'] || $_SESSION['moderador'])) {
        Noticia::borraNoticia($id_noticia);
        header('Location: ../noticias.php');
        exit();
    } else {
        // Usuario no tiene permisos o la noticia no existe
        header('Location: ../noticias.php?error=noAutorizado');
        exit();
    }
} else {
    // Si no está logueado o no se proporcionó un ID de noticia
    header('Location: ../noticias.php?error=noAutorizado');
    exit();
}
