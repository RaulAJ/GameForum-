<?php
require_once '../config.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/foro/bd/Publicacion.php';
require_once '../src/imagenes/bd/Imagen.php';  // Assuming similar image handling as news

verificaLogado(Utils::buildUrl('/foro.php'));

$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
$fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_SPECIAL_CHARS);
$contenido = filter_input(INPUT_POST, 'contenido', FILTER_SANITIZE_SPECIAL_CHARS);
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
$juego = filter_input(INPUT_POST, 'juego', FILTER_SANITIZE_SPECIAL_CHARS);

if ($titulo && idUsuarioLogado() && $fecha && $contenido && $tipo && $juego) {
    $publicacionId = Publicacion::crea($titulo, idUsuarioLogado(), $juego, $tipo, $fecha, $contenido);
    $errorEnImagen = false;

    if ($publicacionId && isset($_FILES['imagen']) && $_FILES['imagen']['name'][0] != '') {
        foreach ($_FILES['imagen']['name'] as $key => $value) {
            if ($_FILES['imagen']['error'][$key] == 0 && $_FILES['imagen']['size'][$key] > 0) {
                $file = [
                    'name' => $_FILES['imagen']['name'][$key],
                    'type' => $_FILES['imagen']['type'][$key],
                    'tmp_name' => $_FILES['imagen']['tmp_name'][$key],
                    'error' => $_FILES['imagen']['error'][$key],
                    'size' => $_FILES['imagen']['size'][$key]
                ];
                $descripcion = 'Default image description';
                $imagenId = Imagen::crea($file, $descripcion, null, null, $publicacionId, null);

                if (!$imagenId) {
                    error_log("Error uploading image for post ID: " . $publicacionId);
                    $errorEnImagen = true;
                }
            } else {
                $errorEnImagen = true;
            }
        }
    }

    if ($errorEnImagen) {
        Publicacion::borraPublicacion($publicacionId); 
        Utils::redirige(Utils::buildUrl('/foro.php', ['error' => 'errorSubida']));
    } else {
        Utils::redirige(Utils::buildUrl('/foro.php', ['exito' => '1']));
    }
} else {
    Utils::redirige(Utils::buildUrl('/foro.php', ['error' => 'datosInvalidos']));
}
