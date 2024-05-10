<?php
/**
 * Para crear y añadir nuevos juegos en la BD
 */

require_once '../config.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/juegos/bd/Juego.php';
require_once '../src/imagenes/bd/Imagen.php';


verificaLogado(Utils::buildUrl('/topJuegos.php'));

if (!($_SESSION['admin'] || $_SESSION['moderador'] || $_SESSION['experto'])) {
    // Si el usuario no tiene un rol permitido, redirige a topJuegos.php con un mensaje de error
    Utils::redirige(Utils::buildUrl('/topJuegos.php', ['error' => 'noAutorizado']));
    exit();
}

//Validar datos recibidos:
$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
$anioDeSalida = filter_input(INPUT_POST, 'anioDeSalida', FILTER_SANITIZE_NUMBER_INT);
$desarrollador = filter_input(INPUT_POST, 'desarrollador', FILTER_SANITIZE_SPECIAL_CHARS);
$genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_SPECIAL_CHARS);
$nota = filter_input(INPUT_POST, 'nota', FILTER_VALIDATE_FLOAT);
$descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS);

// Crear y guardar el juego si todos los datos son válidos
if ($titulo && $anioDeSalida && $desarrollador && $genero && $nota !== false && $descripcion) {
    $juegoId = Juego::crea($titulo, $anioDeSalida, $desarrollador, $genero, $nota, $descripcion);
    $errorEnImagen = false;

    if ($juegoId && isset($_FILES['imagen']) && $_FILES['imagen']['name'][0] != '') {
        foreach ($_FILES['imagen']['name'] as $key => $value) {
            if ($_FILES['imagen']['error'][$key] == 0 && $_FILES['imagen']['size'][$key] > 0 ) { //// Comprobar que no hay error y que el tamaño del archivo es mayor a cero
                $file = [
                    'name' => $_FILES['imagen']['name'][$key],
                    'type' => $_FILES['imagen']['type'][$key],
                    'tmp_name' => $_FILES['imagen']['tmp_name'][$key],
                    'error' => $_FILES['imagen']['error'][$key],
                    'size' => $_FILES['imagen']['size'][$key]
                ];
                $imagenId = Imagen::crea($file, null, $juegoId, null, null, null);

                if (!$imagenId) {
                    error_log("Error al subir la imagen para el juego ID: " . $juegoId);
                    $errorEnImagen = true;
                }
            } else {
                $errorEnImagen = true;
            }
        }
    }

    if ($errorEnImagen) {
        Juego::borraDeVideojuegos($juegoId); // Borrar juego si la subida de la imagen falla
        Utils::redirige(Utils::buildUrl('/topJuegos.php', ['error' => 'errorSubida']));
    } else {
        Utils::redirige(Utils::buildUrl('/topJuegos.php', ['exito' => '1']));
    }
} else {
    // Redirigir de nuevo al formulario con un mensaje de error
    Utils::redirige(Utils::buildUrl('/topJuegos.php?accion=agregarJuego', ['error' => 'datosInvalidos']));
}