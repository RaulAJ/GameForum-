<?php
// Link CSS
echo '<link rel="stylesheet" href="css/foro.css">';

require_once 'autorizacion.php';

/*
function buildFormularioNoticia()
{
    return <<<HTML
        <form class="formulario-noticia" action="noticias/procesarNoticia.php" method="post">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>
            
            <label for="contenido">Contenido:</label>
            <textarea id="contenido" name="contenido" rows="4" cols="50" required></textarea><br><br>
            
            <input type="submit" value="Enviar">
        </form>
        HTML;
}

function mostrarBotonAgregarNoticia()
{
    if (estaLogado()) {
        if ($_SESSION['admin'] || $_SESSION['moderador'] || $_SESSION['experto']) {
            return '<a href="noticias.php?accion=agregarNoticia" class="noticia-button">Redactar Noticia</a>';
        }
    }
    return '';
}
 */
function listaPublicaciones()
{
    $publicaciones = Publicacion::obtenerPublicaciones();
    $listaHtml = '<div class="lista-publicaciones">';

    foreach ($publicaciones as $publicacion) {
        $nombre = htmlspecialchars($publicacion->getTitulo());
        $fecha = htmlspecialchars($publicacion->getFecha());
        $usuario = htmlspecialchars($publicacion->getUsuario());
        $id = $publicacion->getId();

        $listaHtml .= "<div class=\"Publicacion\">
                        <h3 class=\"titulo-publicacion\">$nombre</h3>
                        <p class=\"fecha-publicacion\">$fecha</p>
                        <p class=\"usuario-publicacion\">Escrita por: $usuario </p>
                        <div class=\"contenido-publicacion\">{$publicacion->getContenido()}</div>";

        if (estaLogado()) {
            if (esMismoUsuario($usuario) || $_SESSION['admin'] || $_SESSION['moderador']) {
                $listaHtml .= "<p><a href='foro/borrarPublicacion.php?id=$id' class='borrar-button'>Borrar</a></p>";
            }
        }

        $listaHtml .= "<br><br></div>";
    }

    $listaHtml .= '</div>';
    return $listaHtml;
}
