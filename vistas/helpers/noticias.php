<?php
// Link CSS
echo '<link rel="stylesheet" href="css/estilos.css">';

require_once 'autorizacion.php';
require_once 'src/imagenes/bd/Imagen.php';

function buildFormularioNoticia()
{
    return <<<HTML
        <form class="formulario-noticia" action="noticias/procesarNoticia.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>
            
            <label for="contenido">Contenido:</label>
            <textarea id="contenido" name="contenido" rows="4" cols="50" maxlength="997" required></textarea><br><br>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen[]" multiple><br><br> 
            
            <input type="submit" value="Enviar">
        </form>
        HTML;
}


function editarformularioNoticia($id)
{
    $noticia = Noticia::obtenerNoticiaPorId($id);
    $titulo = htmlspecialchars($noticia->getTitulo());
    $fecha = htmlspecialchars($noticia->getFecha());
    $contenido = htmlspecialchars($noticia->getContenido());
    //$contenidoActual = htmlspecialchars($noticia->getContenido());
    return <<<HTML
        <form class="formulario-noticia" action="noticias/editarNoticia.php" method="post" enctype="multipart/form-data">
            <input type='hidden' name='id' value= '$id'>

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value='$titulo' required>
            
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" value='$fecha' required>
            
            <label for="contenido">Contenido:</label>
            <textarea id="contenido" name="contenido"  rows="4" cols="50" maxlength="997" required>$contenido</textarea><br><br>
            
            <label for="imagen">Añadir imágenes:</label>
            <input type="file" id="imagen" name="imagen[]" multiple><br><br> 

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
        $imagenes = Imagen::obtenerPorNoticiaId($id); // Obtener las imágenes asociadas

        $imagenesHtml = ''; // Inicializar el HTML para imágenes
        foreach ($imagenes as $imagen) {
            // Añadir cada imagen al HTML
            $rutaImagen = htmlspecialchars($imagen->getRuta());
            $descripcionImagen = htmlspecialchars($imagen->getDescripcion());
            $imagenesHtml .= "<img src='{$rutaImagen}' alt='{$descripcionImagen}' class='imagen-noticia'>";

        }

        $listaHtml .= "<div class=\"noticia\">
                        <h3 class=\"titulo-noticia\">$nombre</h3>
                        <p class=\"fecha-noticia\">$fecha</p>
                        <p class=\"usuario-noticia\">Escrita por: $usuario</p>
                        <div class=\"imagenes-noticia\">$imagenesHtml</div>
                        <div class=\"contenido-noticia\">{$noticia->getContenido()}</div>";

        if (estaLogado()) {
            if (esMismoUsuario($usuario) || $_SESSION['admin'] || $_SESSION['moderador']) {
            

                // Botón de borrar noticia
                $listaHtml .= "<form action='noticias/borrarNoticia.php' method='post' style='grid-area: borrar;'>
                                    <input type='hidden' name='id' value='$id'>
                                    <button type='submit' class='borrar_button'>Borrar</button>
                                </form>";

                // Botón de editar noticia
                $listaHtml .= "<form action='noticias.php' style='grid-area: editar;'>
                                    <input type='hidden' name='accion' value='editarNoticia'>
                                    <input type='hidden' name='id' value='$id'>
                                    <button type='submit' class='editar-button'>Editar</button>
                                </form>";

               
            }
        }

        $listaHtml .= "</div><br><br>";
    }

    $listaHtml .= '</div>';
    return $listaHtml;
}
