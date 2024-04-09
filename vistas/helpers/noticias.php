<?php

function buildFormularioNoticia() {
    return <<<HTML
    <form action="noticias/procesarNoticia.php" method="post">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
        
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        
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


function listaNoticias(){ //cambiar br's por lineas o algo
    $noticias = Noticia::obtenerNoticias();

    $listaHtml = '<div class="lista-noticias">';
        foreach ($noticias as $noticia) {
            $nombreYFecha = htmlspecialchars($noticia->getTitulo()) . ' (' . htmlspecialchars($noticia->getFecha()) . ')';
            $listaHtml .= "<div class=\"noticia\">
            <h3 class=\"titulo-noticia\">$nombreYFecha</h3>
            <div class=\"contenido-noticia\">{$noticia->getContenido()}</div><br><br>
        </div>";
        }
        $listaHtml .= '</div>';
        return $listaHtml;
}
