<?php
// Link CSS
echo '<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" href="css/noticias.css"></head><body>';

require_once 'autorizacion.php';

    function buildFormularioNoticia() {
        return <<<HTML
        <form class= "formulario" action="noticias/procesarNoticia.php" method="post">
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

function mostrarBotonAgregarNoticia() {
    if (estaLogado()) {
        if ($_SESSION['admin'] || $_SESSION['moderador'] || $_SESSION['experto']) {
            return '<a href="noticias.php?accion=agregarNoticia" class="button">Redactar Noticia</a>';
        } 
    }
    return '';
}

function listaNoticias() {
    $noticias = Noticia::obtenerNoticias();

    $listaHtml = '<div class="lista-noticias">';
    foreach ($noticias as $noticia) {
        $nombre = htmlspecialchars($noticia->getTitulo());
        $fecha = htmlspecialchars($noticia->getFecha());
        $usuario = htmlspecialchars($noticia->getUsuario());
        $listaHtml .= "<div class=\"noticia\">
        <h3 class=\"titulo-noticia\">$nombre</h3>
        <p class=\"fecha-noticia\">$fecha</p>
        <p class=\"usuario-noticia\">Escrita por: $usuario</p>
        <div class=\"contenido-noticia\">{$noticia->getContenido()}</div><br><br>
    </div>";
    }
    $listaHtml .= '</div>';
    return $listaHtml;
}

echo '</body></html>';
?>
