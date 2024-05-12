<?php
// Link CSS
echo '<link rel="stylesheet" href="css/estilos.css">';

require_once 'autorizacion.php';
require_once 'src/respuestas/bd/Respuesta.php';

function buildFormularioRespuesta($id)
{
    return <<<HTML
        <form class="formulario-foro" action="foro/procesarRespuesta.php" method="post">
            <input type='hidden' name='idforo' value='$id'>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>
            
            <label for="contenido">Contenido:</label>
            <textarea id="contenido" name="contenido" rows="2" cols="50" required></textarea><br><br>
            
            <input type="submit" value="Enviar">
        </form>
    HTML;
}


function mostrarBotonAgregarRespuesta($id) {
    if (estaLogado()) {
        if ($_SESSION['admin'] || $_SESSION['moderador'] || $_SESSION['experto']) {
            return <<<HTML
                <form action="verPublicacion.php" method="get">
                    <input type="hidden" name="accion" value="agregarRespuesta">
                    <input type="hidden" name="id" value="$id">
                    <button type="submit" class="boton-agregar-respuesta">Responder</button>
                </form>
            HTML;
        }
    }
    return '';
}

function listaRespuestas($idForo)
{
    $respuestas = Respuesta::obtenerRespuestas($idForo);
    $listaHtml = '<div class="lista-respuestas">';
    foreach ($respuestas as $respuesta) {
        $fecha = htmlspecialchars($respuesta->getFecha());
        $usuario = htmlspecialchars($respuesta->getUsuario());
        $listaHtml .= "<div class=\"Respuesta\">
                        <p class=\"fecha-respuesta\">$fecha</p>
                        <p class=\"usuario-respuesta\">Escrita por: $usuario </p>
                        <div class=\"contenido-respuesta\">{$respuesta->getContenido()}</div>";

        $listaHtml .= "<br><br></div>";
    }

    $listaHtml .= '</div>';
    return $listaHtml;
}