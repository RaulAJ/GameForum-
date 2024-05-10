<?php
// Link CSS
echo '<link rel="stylesheet" href="css/estilos.css">';

require_once 'autorizacion.php';
require_once 'src/imagenes/bd/Imagen.php';

function mostrarBotonAgregarJuego()
{
    if (estaLogado()) {
        if ($_SESSION['admin'] || $_SESSION['moderador'] || $_SESSION['experto']) {
            return '<a href="topJuegos.php?accion=agregarJuego" class="juego-button">Añadir Juego</a> <a href="verSugerirJuegos.php" class="juego-button">Juegos sugeridos</a>';
        } else {
            return '<a href="topJuegos.php?accion=sugerirJuego" class="juego-button">Sugerir Juego</a>';
        }
    }
    return '';
}

function buildFormularioAgregarJuego()
{
    return <<<HTML
    <form class="formulario-agregar" action="juegos/nuevoJuego.php" method="post" enctype="multipart/form-data">
        <label for="titulo">Título del juego:</label>
        <input type="text" id="titulo" name="titulo" required>
        
        <label for="anioDeSalida">Año de Salida:</label>
        <input type="number" id="anioDeSalida" name="anioDeSalida" required>
        
        <label for="desarrollador">Desarrollador:</label>
        <input type="text" id="desarrollador" name="desarrollador" required>
        
        <label for="genero">Género:</label>
        <input type="text" id="genero" name="genero" required>
        
        <label for="nota">Nota:</label>
        <input type="number" step="0.1" id="nota" name="nota" required>
        
        <label for="descripcion">Descripción del juego:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>
        
        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen[]" multiple><br><br> 

        <input type="submit" value="Añadir videojuego">
    </form>
    HTML;
}

function buildFormularioSugerirJuego()
{
    return <<<HTML
    <form class="formulario-sugerir" action="juegos/procesarSugerirJuego.php" method="post" enctype="multipart/form-data">
        <label for="titulo">Título del juego:</label>
        <input type="text" id="titulo" name="titulo" required>
        
        <label for="anioDeSalida">Año de Salida:</label>
        <input type="number" id="anioDeSalida" name="anioDeSalida" required>
        
        <label for="desarrollador">Desarrollador:</label>
        <input type="text" id="desarrollador" name="desarrollador" required>
        
        <label for="genero">Género:</label>
        <input type="text" id="genero" name="genero" required>
        
        <label for="descripcion">Descripción del juego:</label>
        <textarea id="descripcion" name="descripcion" required></textarea>

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" name="imagen[]" multiple><br><br> 
        
        <input type="submit" value="Sugerir videojuego">
    </form>
    HTML;
}
function listaSugerencias()
{
    $sugerencias = Juego::obtenerSugerenciasJuegos();
    $listaHtml = '<div class="lista-juegos">';
    foreach ($sugerencias as $sugerencia) {
        $id = $sugerencia->getId();
        $nombre = htmlspecialchars($sugerencia->getNombreJuego());
        $listaHtml .= "<div class=\"juego\">
                       <form action='verJuego.php' method='post'>
                            <input type='hidden' name='id' value='$id'>
                            <button type='submit' class='borrar-button'>$nombre</button>
                        </form>
                        <form action='juegos/aceptarSugerirJuego.php' method='post'>
                            <input type='hidden' name='id' value='$id'>
                            <button>Aceptar juego</button>
                        </form>
                        <form action='juegos/borrarSugerenciaJuego.php' method='post'>
                            <input type='hidden' name='id' value='$id'>
                            <button>Rechazar juego</button>
                        </form>                       
                        </div>";
    }
    $listaHtml .= '</div>';
    return $listaHtml;
}
function listaJuegos($orden = 'notaDesc')
{
    switch ($orden) {
        case 'notaAsc':
            $juegos = Juego::obtenerJuegosPorNotaAscendente();
            break;
        case 'anioAsc':
            $juegos = Juego::obtenerJuegosPorAnioAscendente();
            break;
        case 'anioDesc':
            $juegos = Juego::obtenerJuegosPorAnioDescendente();
            break;
        default: // 'notaDesc'
            $juegos = Juego::obtenerTopJuegos();
            break;
    }

    $listaHtml = '<div class="lista-juegos">';
    $posicion = 1;
    foreach ($juegos as $juego) {
        $id = $juego->getId();
        $nombre = htmlspecialchars($juego->getNombreJuego());
        $imagenes = Imagen::obtenerPorVideojuegoId($id); // Fetch images for this game
        
        $imagenesHtml = '<div class="imagenes-juego">';
        foreach ($imagenes as $imagen) {
            // Construct HTML for each image
            $imagenesHtml .= "<img src='{$imagen->getRuta()}' alt='{$imagen->getDescripcion()}' style='width: 100px; height: auto;'>";
        }
        $imagenesHtml .= '</div>';

        $listaHtml .= "<div class=\"juego\">
                       <div class=\"posicion-juego\">Top $posicion</div>
                       <form action='verJuego.php' method='post'>
                            <input type='hidden' name='id' value='$id'>
                            <button type='submit' class='juego-button'>$nombre</button>
                         </form>
                         $imagenesHtml
                         <div class=\"nota-juego\">Nota: {$juego->getNota()}</div>
                       </div>";
        $posicion++;
    }
    $listaHtml .= '</div>';
    return $listaHtml;
}
