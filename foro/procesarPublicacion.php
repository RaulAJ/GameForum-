<?php

require_once '../config.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/noticias/bd/Publicacion.php';

verificaLogado(Utils::buildUrl('/foro.php'));

if (!($_SESSION['admin'] || $_SESSION['moderador'] || $_SESSION['experto'])) {
    // Si el usuario no tiene un rol permitido, redirige a topJuegos.php con un mensaje de error
    Utils::redirige(Utils::buildUrl('/foro.php', ['error' => 'noAutorizado']));
    exit();
}

// Sanitizar y obtener valores de cada campo del formulario
$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
//$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);
$fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_SPECIAL_CHARS);
$contenido = filter_input(INPUT_POST, 'contenido', FILTER_SANITIZE_SPECIAL_CHARS);
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
$juego = filter_input(INPUT_POST, 'juego', FILTER_SANITIZE_SPECIAL_CHARS);

if($titulo && idUsuarioLogado() && $fecha && $contenido && $tipo && $juego){
    $publicacion = new Publicacion($titulo, $_SESSION['usuario'], $juego, $tipo, $fecha, $contenido, $id);

    if($noticia){
        Utils::redirige(Utils::buildUrl('/foro.php', ['exito' => '1']));
    } else{
        Utils::redirige(Utils::buildUrl('/foro.php', ['error' => '1']));
    }
}
else {
    // Redirigir de nuevo al formulario con un mensaje de error
    Utils::redirige(Utils::buildUrl('/noticias.php?accion=agregarPublicacion', ['error' => 'datosInvalidos']));
}