<?php
// Link CSS
echo '<link rel="stylesheet" href="css/estilos.css">';

require_once 'autorizacion.php';
require_once 'src/juegos/bd/Juego.php';
require_once 'src/respuestas/bd/Respuesta.php';
require_once 'src/imagenes/bd/Imagen.php';


function buildFormularioPublicacion()
{
    $juegos = Juego::obtenerNombresJuegos();

    $opcionesjuegos = '';
    foreach ($juegos as $juego) {
        $opcionesjuegos .= "<option value=\"$juego\">$juego</option>";
    }

    $opcionesTipo = '
        <option value="Duda">Duda</option>
        <option value="Guía">Guía</option>
        <option value="Truco">Truco</option>
        <option value="Otro">Otro</option>
    ';

    return <<<HTML
        <form class="formulario-foro" action="foro/procesarPublicacion.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo" required>
                $opcionesTipo
            </select>

            <label for="juego">Juego:</label>
            <select id="juego" name="juego" required>
                $opcionesjuegos
            </select>
            
            <label for="contenido">Contenido:</label>
            <textarea id="contenido" name="contenido" rows="4" cols="50" required></textarea><br><br>
            
            <label for="imagen">Imagenes:</label>
            <input type="file" id="imagen" name="imagen[]" multiple><br><br> 
            <input type="submit" value="Enviar">
        </form>
    HTML;
}

function editarformularioPublicacion($id)
{
    $juegos = Juego::obtenerNombresJuegos();
    $publicacion = Publicacion::obtenerPublicacionPorId($id);

    $titulo = htmlspecialchars($publicacion->getTitulo());
    $fecha = htmlspecialchars($publicacion->getFecha());
    $tipo = htmlspecialchars($publicacion->getTipo());
    $juego = htmlspecialchars($publicacion->getJuego());
    $contenido = htmlspecialchars($publicacion->getContenido());

    //Recopila los juegos posibles y selecciona del que se estaba hablando antes de editar
    $opcionesjuegos = '';
    foreach ($juegos as $juegoo) {
        if ($juegoo == $juego) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        $opcionesjuegos .= "<option value=\"$juegoo\" $selected>$juegoo</option>";
    }

    //Recopila los tipos posibles y selecciona del que se estaba hablando antes de editar
    //Si el tipo es añadido en la BD manualmente y no cumple con las 4 opciones, se selecciona "Duda" por defecto
    //Esto no le puede pasar al usuario ya que el formulario de creación restringe a estas 4 opciones
    $opcionesTipo = '';
    $tipos = ["Duda", "Guía", "Truco", "Otro"];
    foreach ($tipos as $tipoo) {
        if ($tipoo == $tipo) {
            $selected = 'selected';
        } else {
            $selected = '';
        }
        $opcionesTipo .= "<option value=\"$tipoo\" $selected>$tipoo</option>";
    }

    return <<<HTML
        <form class="formulario-foro" action="foro/editarPublicacion.php" method="post" enctype="multipart/form-data">
            <input type='hidden' name='id' value= '$id'>

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value='$titulo' required>
            
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" value='$fecha' required>

            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo" required>
                $opcionesTipo
            </select>

            <label for="juego">Juego:</label>
            <select id="juego" name="juego" required>
                $opcionesjuegos
            </select>
            
            <label for="contenido">Contenido:</label>
            <textarea id="contenido" name="contenido"  rows="4" cols="50" required>$contenido</textarea><br><br>
            
            <label for="imagen">Añadir imágenes:</label>
            <input type="file" id="imagen" name="imagen[]" multiple><br><br> 
            <input type="submit" value="Enviar">
        </form>
HTML;
}

function mostrarBotonAgregarPublicacion()
{
    if (estaLogado()) {
        if ($_SESSION['admin'] || $_SESSION['moderador'] || $_SESSION['experto']) {
            return '<a href="foro.php?accion=agregarPublicacion" class="foro-button">Redactar publicación</a>';
        }
    }
    return '';
}

function listaPublicaciones()
{
    $publicaciones = Publicacion::obtenerPublicaciones();
    $listaHtml = '<div class="lista-publicaciones">';

    foreach ($publicaciones as $publicacion) {
        $nombre = htmlspecialchars($publicacion->getTitulo());
        $fecha = htmlspecialchars($publicacion->getFecha());
        $usuario = htmlspecialchars($publicacion->getUsuario());
        $tipo = htmlspecialchars($publicacion->getTipo());
        $juego = htmlspecialchars($publicacion->getJuego());
        $id = $publicacion->getId();
        $imagenes = Imagen::obtenerPorForoId($id);

        $imagenesHtml = '';
        foreach ($imagenes as $imagen) {
            $rutaImagen = htmlspecialchars($imagen->getRuta());
            $descripcionImagen = htmlspecialchars($imagen->getDescripcion());
            $imagenesHtml .= "<img src='{$rutaImagen}' alt='{$descripcionImagen}' style='width: 100px; height: auto;'>";
        }

        $listaHtml .= "<div class=\"publicacion\">
                <h3 class=\"titulo-publicacion\">
                    <form action='verPublicacion.php' method='get'>
                        <input type='hidden' name='id' value='$id'>
                        <button type='submit' class='titulo-button'>$nombre</button>
                    </form>
                </h3>
                <p class=\"fecha-publicacion\">$fecha</p>
                <p class=\"tipo-publicacion\">Tipo: $tipo</p>
                <p class=\"juego-publicacion\">Juego: 
                    <form action='verJuego.php' method='post' style='grid-area: juego;'>
                        <input type='hidden' name='juego' value='$juego'>
                        <button type='submit' class='verJuego-button'>$juego</button>
                    </form>
                </p>
                <p class=\"usuario-publicacion\">Escrita por: $usuario </p>
                <div class=\"contenido-publicacion\">{$publicacion->getContenido()}</div>
                <div class=\"imagenes-publicacion\">$imagenesHtml</div>";


        if (estaLogado()) {
            if (esMismoUsuario($usuario) || $_SESSION['admin'] || $_SESSION['moderador']) {
                $listaHtml .= "<form action='foro/borrarPublicacion.php' method='post' style='grid-area: borrar;'>
                                        <input type='hidden' name='id' value='$id'>
                                        <button type='submit' class='borrar_button'>Borrar</button>
                                    </form>";
                $listaHtml .= "<form action='foro.php' style='grid-area: editar;'>
                                        <input type='hidden' name='accion' value='editarPublicacion'>
                                        <input type='hidden' name='id' value='$id'>
                                        <button type='submit' class='editar-button'>Editar</button>
                                    </form>";
            }
        }

        $listaHtml .= "<br><br></div>";
    }
    $listaHtml .= '</div>';
    return $listaHtml;
}

function mostrarDetallesPublicacion($id)
{
    require_once 'src/foro/bd/Publicacion.php';

    $publicacion = Publicacion::obtenerPublicacionPorId($id);
    if (!$publicacion) {
        return "Publicación no encontrada.";
    }

    // Extraer detalles
    $titulo = htmlspecialchars($publicacion->getTitulo());
    $usuario = htmlspecialchars($publicacion->getUsuario());
    $juego = htmlspecialchars($publicacion->getJuego());
    $tipo = htmlspecialchars($publicacion->getTipo());
    $fecha = htmlspecialchars($publicacion->getFecha());
    $contenido = htmlspecialchars($publicacion->getContenido());

    // Generar HTML
    $contenidoHtml = "<div class='seccion-info'>
        <h2>$titulo</h2>
        <div class='info-detalle'><p class='info-label'>Usuario:</p><p class='info-valor'>$usuario</p></div>
        <div class='info-detalle'><p class='info-label'>Juego:</p><p class='info-valor'>$juego</p></div>
        <div class='info-detalle'><p class='info-label'>Tipo:</p><p class='info-valor'>$tipo</p></div>
        <div class='info-detalle'><p class='info-label'>Fecha:</p><p class='info-valor'>$fecha</p></div>
        <div class='info-detalle'><p class='info-label'>Descripción:</p><p class='info-valor'>$contenido</p></div>
    </div>";

    // Recuperar y mostrar imagenes
    $imagenes = Imagen::obtenerPorForoId($id);
    $imagenesHtml = '';
    foreach ($imagenes as $imagen) {
        $rutaImagen = htmlspecialchars($imagen->getRuta());
        $descripcionImagen = htmlspecialchars($imagen->getDescripcion());
        $imagenesHtml .= "<img src='{$rutaImagen}' alt='{$descripcionImagen}' style='width: auto; height: auto;'>";
    }

    return $contenidoHtml . $imagenesHtml;  // Combinar
}

