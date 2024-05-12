<?php

require_once 'config.php';
require_once 'vistas/helpers/publicaciones.php';
require_once 'vistas/helpers/respuestas.php';

$mensaje = '';
$contenidoPrincipal = '';
$tituloPagina = 'Detalles de la publicación';

if (!isset($_GET['accion'])) {
    if (isset($_GET['id'])) {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        if ($id) {
            $detallesPublicacion = mostrarDetallesPublicacion($id);
            if ($detallesPublicacion) {
                $contenidoPrincipal .= $detallesPublicacion;
                if (estaLogado()) {
                    $contenidoPrincipal .= mostrarBotonAgregarRespuesta($id);
                }
                $contenidoPrincipal .= "<div class='publicacion-respuestas'><h2>Respuestas:</h2></div>";
                $contenidoPrincipal .= listaRespuestas($id);
            } else {
                $mensaje = "La publicacion solicitada no fue encontrada.";
            }

        } else {
            $mensaje = "Identificador de publicación inválido.";
        }
    } else {
        $mensaje = "No se proporcionó un identificador de publicación.";
    }
} elseif (isset($_GET['accion']) && $_GET['accion'] === 'agregarRespuesta' && isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $contenidoPrincipal .= buildFormularioRespuesta($id);
}
$contenidoPrincipal .= $mensaje;

require 'vistas/comun/layout.php';
