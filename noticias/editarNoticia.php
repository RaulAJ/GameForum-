<?php

require_once '../config.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/noticias/bd/Noticia.php';

verificaLogado(Utils::buildUrl('/noticias.php'));

if (!($_SESSION['admin'] || $_SESSION['moderador'] || $_SESSION['experto'])) {
    // Si el usuario no tiene un rol permitido, redirige a topJuegos.php con un mensaje de error
    Utils::redirige(Utils::buildUrl('/noticias.php', ['error' => 'noAutorizado']));
    exit();
}

// Sanitizar y obtener valores de cada campo del formulario
$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
//$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);
$fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_SPECIAL_CHARS);
$contenido = filter_input(INPUT_POST, 'contenido', FILTER_SANITIZE_SPECIAL_CHARS);


if($titulo && idUsuarioLogado() && $fecha && $contenido){
    $id = intval($_POST['id']);
    $noticia = new Noticia($titulo, $_SESSION['usuario'], $fecha, $contenido, $id);
    Noticia::actualiza($noticia);

    if($noticia){
        Utils::redirige(Utils::buildUrl('/noticias.php', ['exito' => '1']));
        
    } else{
        Utils::redirige(Utils::buildUrl('/noticias.php', ['error' => '1']));
    }
}
else {
    // Redirigir de nuevo al formulario con un mensaje de error
    Utils::redirige(Utils::buildUrl('/noticias.php?accion=editarNoticia', ['error' => 'datosInvalidos']));
}