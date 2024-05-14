<?php

require_once '../config.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/respuestas/bd/Respuesta.php';

verificaLogado(Utils::buildUrl('/foro.php'));

$idforo = filter_input(INPUT_POST, 'idforo', FILTER_SANITIZE_NUMBER_INT);

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