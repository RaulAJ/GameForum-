<?php
// Link CSS
echo '<link rel="stylesheet" href="css/noticias.css">';
require_once 'autorizacion.php';
function buildFormularioNoticia()
{
    return <<<HTML
        <form class="formulario" action="noticias/procesarNoticia.php" method="post">
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

function listaNoticias()
{
    $noticias = Noticia::obtenerNoticias();

    $listaHtml = '<div class="lista-noticias">';
    foreach ($noticias as $noticia) {
        $nombre = htmlspecialchars($noticia->getTitulo());
        $fecha = htmlspecialchars($noticia->getFecha());
        $usuario = htmlspecialchars($noticia->getUsuario());
        $id = $noticia->getId();

        if (estaLogado()) {
            if (esMismoUsuario($usuario) || $_SESSION['admin'] || $_SESSION['moderador']) {
                $listaHtml .= "<div class=\"noticia\">
                        <h3 class=\"titulo-noticia\">$nombre</h3>
                        <p class=\"fecha-noticia\">$fecha</p>
                        <p class=\"usuario-noticia\">Escrita por: $usuario </p>
                        <div class=\"contenido-noticia\">{$noticia->getContenido()}</div>

                        <p><a href='noticias/borrarNoticia.php?id=$id' class='borrar-button'>Borrar</a></p>
                        <br><br>
                        </div>";
            }
        } else {
            $listaHtml .= "<div class=\"noticia\">
                    <h3 class=\"titulo-noticia\">$nombre</h3>
                    <p class=\"fecha-noticia\">$fecha</p>
                    <p class=\"usuario-noticia\">Escrita por: $usuario</p>
                    <div class=\"contenido-noticia\">{$noticia->getContenido()}</div><br><br>
                    </div>";
        }
    }
    $listaHtml .= '</div>';
    return $listaHtml;
}
