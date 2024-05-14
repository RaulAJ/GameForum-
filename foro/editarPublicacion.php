<?php

require_once '../config.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/foro/bd/Publicacion.php';
require_once '../src/imagenes/bd/Imagen.php'; 

verificaLogado(Utils::buildUrl('/foro.php'));

$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
$fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_SPECIAL_CHARS);
$contenido = filter_input(INPUT_POST, 'contenido', FILTER_SANITIZE_SPECIAL_CHARS);
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
$juego = filter_input(INPUT_POST, 'juego', FILTER_SANITIZE_SPECIAL_CHARS);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

if ($titulo && idUsuarioLogado() && $fecha && $contenido && $tipo && $juego && $id) {
    $publicacion = new Publicacion($titulo, idUsuarioLogado(), $juego, $tipo, $fecha, $contenido, $id);
    $updateSuccessful = Publicacion::actualiza($publicacion);

    $errorEnImagen = false;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['name'][0] != '') {
        foreach ($_FILES['imagen']['name'] as $key => $value) {
            if ($_FILES['imagen']['error'][$key] == 0 && $_FILES['imagen']['size'][$key] > 0) {
                $file = [
                    'name' => $_FILES['imagen']['name'][$key],
                    'type' => $_FILES['imagen']['type'][$key],
                    'tmp_name' => $_FILES['imagen']['tmp_name'][$key],
                    'error' => $_FILES['imagen']['error'][$key],
                    'size' => $_FILES['imagen']['size'][$key]
                ];
                $descripcion = 'Descripción de la imagen editada';
                $imagenId = Imagen::crea($file, $descripcion, null, null, $id, null);

                if (!$imagenId) {
                    error_log("Error al subir la imagen editada para la publicación ID: " . $id);
                    $errorEnImagen = true;
                }
            } else {
                $errorEnImagen = true;
            }
        }
    }

    if ($errorEnImagen) {
        Utils::redirige(Utils::buildUrl('/foro.php', ['error' => 'errorSubida']));
    } elseif ($updateSuccessful) {
        Utils::redirige(Utils::buildUrl('/foro.php', ['exito' => '1']));
    } else {
        Utils::redirige(Utils::buildUrl('/foro.php', ['error' => 'errorEditar']));
    }
} else {
    Utils::redirige(Utils::buildUrl('/foro.php', ['error' => 'datosInvalidos']));
}
