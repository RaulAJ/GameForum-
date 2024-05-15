<?php
/**
 * Para añadir juegos a la tabla sugerenciasjuegos
 */

require_once '../config.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/juegos/bd/Juego.php';
require_once '../src/imagenes/bd/Imagen.php';

verificaLogado(Utils::buildUrl('/topJuegos.php'));

$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
$anioDeSalida = filter_input(INPUT_POST, 'anioDeSalida', FILTER_SANITIZE_NUMBER_INT);
$desarrollador = filter_input(INPUT_POST, 'desarrollador', FILTER_SANITIZE_SPECIAL_CHARS);
$genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_SPECIAL_CHARS);
$descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);

if ($titulo && $anioDeSalida && $desarrollador && $genero && $descripcion) {
    $sugerenciaId = Juego::sugiere($titulo, $anioDeSalida, $desarrollador, $genero, $descripcion);
    $errorEnImagen = false;

    if ($sugerenciaId === false) {
        // Redirigir al formulario con un mensaje de error de sugerencia duplicada
        Utils::redirige(Utils::buildUrl('/topJuegos.php', ['error' => 'errorSugerencia']));
        exit();
    } else {
        if ($sugerenciaId && isset($_FILES['imagen']) && $_FILES['imagen']['name'][0] != '') {
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
                    $imagenId = Imagen::crea($file, $descripcion, null, null, null, $sugerenciaId);

                    if (!$imagenId) {
                        error_log("Error al subir la imagen para la sugerencia ID: " . $sugerenciaId);
                        $errorEnImagen = true;
                    }
                } else {
                    $errorEnImagen = true;
                }
            }
        }

        if ($errorEnImagen) {
            Juego::borraDeSugerenciasJuegos($sugerenciaId); // Borrar sugerencia si la subida de la imagen falla
            Utils::redirige(Utils::buildUrl('/topJuegos.php', ['error' => 'errorSubida']));
        } else {
            Utils::redirige(Utils::buildUrl('/topJuegos.php', ['exitoSugerencia' => '1']));
        }
    }
} else {
    Utils::redirige(Utils::buildUrl('/topJuegos.php?accion=sugerirJuego', ['error' => 'datosInvalidos']));
}
