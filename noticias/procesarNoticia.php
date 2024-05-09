<?php

require_once '../config.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/noticias/bd/Noticia.php';
require_once '../src/imagenes/bd/Imagen.php';

verificaLogado(Utils::buildUrl('/noticias.php'));

if (!($_SESSION['admin'] || $_SESSION['moderador'] || $_SESSION['experto'])) {
    // Si el usuario no tiene un rol permitido, redirige a topJuegos.php con un mensaje de error
    Utils::redirige(Utils::buildUrl('/noticias.php', ['error' => 'noAutorizado']));
    exit();
}

// Sanitizar y obtener valores de cada campo del formulario
$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
$fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_SPECIAL_CHARS);
$contenido = filter_input(INPUT_POST, 'contenido', FILTER_SANITIZE_SPECIAL_CHARS);

if ($titulo && idUsuarioLogado() && $fecha && $contenido) {
    $noticiaId = Noticia::crea($titulo, idUsuarioLogado(), $fecha, $contenido);

    if ($noticiaId) {
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $file = $_FILES['imagen'];
            $descripcion = 'Descripción por defecto de la imagen';
            $imagenId = Imagen::crea($file, $descripcion, null, $noticiaId, null);

            if (!$imagenId) {
                // Opcional: Manejar el error de carga de imagen
                error_log("Error al subir la imagen para la noticia ID: " . $noticiaId);
            }
        }
        Utils::redirige(Utils::buildUrl('/noticias.php', ['exito' => '1']));
    } else {
        Utils::redirige(Utils::buildUrl('/noticias.php', ['error' => '1']));
    }
} else {
    // Redirigir de nuevo al formulario con un mensaje de error
    Utils::redirige(Utils::buildUrl('/noticias.php?accion=agregarNoticia', ['error' => 'datosInvalidos']));
}
