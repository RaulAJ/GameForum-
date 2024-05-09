<?php

require_once '../config.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/respuestas/bd/Respuesta.php';

verificaLogado(Utils::buildUrl('/foro.php'));

if (!($_SESSION['admin'] || $_SESSION['moderador'] || $_SESSION['experto'])) {
    // Si el usuario no tiene un rol permitido, redirige a topJuegos.php con un mensaje de error
    Utils::redirige(Utils::buildUrl('/foro.php', ['error' => 'noAutorizado']));
    exit();
}

$idforo = $_POST['idforo'];

//$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);
$fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_SPECIAL_CHARS);
$contenido = filter_input(INPUT_POST, 'contenido', FILTER_SANITIZE_SPECIAL_CHARS);


if(idUsuarioLogado() && $fecha && $contenido){
    $respuesta = Respuesta::crea($idforo,  idUsuarioLogado(), $fecha, $contenido);

    if($respuesta){
        Utils::redirige(Utils::buildUrl('/foro.php', ['exito' => '1']));
    } else{
        Utils::redirige(Utils::buildUrl('/foro.php', ['error' => '1']));
    }
}
else {
    // Redirigir de nuevo al formulario con un mensaje de error
    Utils::redirige(Utils::buildUrl('/noticias.php?accion=agregarPublicacion', ['error' => 'datosInvalidos']));
}