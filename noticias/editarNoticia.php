<?php

require_once '../config.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/noticias/bd/Noticia.php';
require_once '../src/imagenes/bd/Imagen.php';

verificaLogado(Utils::buildUrl('/noticias.php'));

if (!($_SESSION['admin'] || $_SESSION['moderador'] || $_SESSION['experto'])) {
    // Si el usuario no tiene un rol permitido, redirige a noticias.php con un mensaje de error
    Utils::redirige(Utils::buildUrl('/noticias.php', ['error' => 'noAutorizado']));
    exit();
}

// Sanitizar y obtener valores de cada campo del formulario
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
$fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_SPECIAL_CHARS);
$contenido = filter_input(INPUT_POST, 'contenido', FILTER_SANITIZE_SPECIAL_CHARS);

if ($titulo && idUsuarioLogado() && $fecha && $contenido) {
    $noticia = new Noticia($titulo, $_SESSION['usuario'], $fecha, $contenido, $id);
    $updateSuccessful = Noticia::actualiza($noticia);

    if (!$updateSuccessful) {
        Utils::redirige(Utils::buildUrl('/noticias.php', ['error' => 'errorEditar']));
        exit();
    }

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
                $imagenId = Imagen::crea($file, $descripcion, null, $id, null, null);

                if (!$imagenId) {
                    error_log("Error al subir la imagen editada para la noticia ID: " . $id);
                    $errorEnImagen = true;
                }
            } else {
                $errorEnImagen = true;
            }
        }
    }

    if ($errorEnImagen) {
        Utils::redirige(Utils::buildUrl('/noticias.php', ['error' => 'errorSubida']));
    } else {
        Utils::redirige(Utils::buildUrl('/noticias.php', ['exito' => '1']));
    }
} else {
    Utils::redirige(Utils::buildUrl('/noticias.php', ['error' => 'datosInvalidos']));
}
