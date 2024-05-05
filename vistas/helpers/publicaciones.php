<?php
// Link CSS
echo '<link rel="stylesheet" href="css/foro.css">';

require_once 'autorizacion.php';


function buildFormularioPublicacion()
{
    return <<<HTML
        <form class="formulario-notici" action="noticias/procesarPublicacion.php" method="post">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="tipo">Fecha:</label>
            <input type="text" id="tipo" name="tipo" required>

            <label for="juego">Fecha:</label>
            <input type="text" id="juego" name="juego" required>
            
            <label for="contenido">Contenido:</label>
            <textarea id="contenido" name="contenido" rows="4" cols="50" required></textarea><br><br>
            
            <input type="submit" value="Enviar">
        </form>
        HTML;
}


function editarformularioPublicacion($id)
{
    $publicacion = Publicacion::obtenerPublicacionPorId($id);
    $titulo = htmlspecialchars($publicacion->getTitulo());
    $fecha = htmlspecialchars($publicacion->getFecha());
    $tipo = htmlspecialchars($publicacion->getTipo());
    $juego = htmlspecialchars($publicacion->getJuego());
    $contenido = htmlspecialchars($publicacion->getContenido());
    //$contenidoActual = htmlspecialchars($noticia->getContenido());
    return <<<HTML
        <form class="formulario-noticia" action="foro/editarPublicacion.php" method="post">
            <input type='hidden' name='id' value= '$id'>

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value='$titulo' required>
            
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" value='$fecha' required>

            <label for="tipo">Tipo:</label>
            <input type="text" id="tipo" name="tipo" value='$tipo' required>

            <label for="juego">Juego:</label>
            <input type="text" id="juego" name="juego" value='$juego' required>
            
            <label for="contenido">Contenido:</label>
            <textarea id="contenido" name="contenido"  rows="4" cols="50" required>$contenido</textarea><br><br>
            
            <input type="submit" value="Enviar">
        </form>
        HTML;
}

/*
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
        $tipo =  htmlspecialchars($publicacion->getTipo());
        $juego =  htmlspecialchars($publicacion->getJuego());
        $id = $publicacion->getId();

        $listaHtml .= "<div class=\"Publicacion\">
                        <h3 class=\"titulo-publicacion\">$nombre</h3>
                        <p class=\"fecha-publicacion\">$fecha</p>
                        <p class=\"tipo-publicacion\">Tipo: $tipo</p>
                        <p class=\"juego-publicacion\">Juego: <a href='verJuego.php?nombre=$juego'>$juego</a></p>
                        <p class=\"usuario-publicacion\">Escrita por: $usuario </p>
                        <div class=\"contenido-publicacion\">{$publicacion->getContenido()}</div>";

        if (estaLogado()) {
            if (esMismoUsuario($usuario) || $_SESSION['admin'] || $_SESSION['moderador']) {
                $listaHtml .= "<form action='foro/borrarPublicacion.php' method='post'>
                <input type='hidden' name='id' value='$id'>
                <button type='submit' class='borrar-button'>Borrar</button>
                    </form>";
                $listaHtml .= "<form action='foro.php'>
                 <input type='hidden' name='accion' value='editarPublicacion'>
                 <input type='hidden' name='id' value='$id'>
                 <button type='submit' class='borrar-button'>Editar</button>
                    </form>";
             }
        }

        $listaHtml .= "<br><br></div>";
    }

    $listaHtml .= '</div>';
    return $listaHtml;
}
