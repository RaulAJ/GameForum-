<?php
// Link CSS
echo '<link rel="stylesheet" href="css/juegos.css">';

require_once 'autorizacion.php';

function mostrarBotonAgregarJuego() {
    if (estaLogado()) {
        if ($_SESSION['admin'] || $_SESSION['moderador'] || $_SESSION['experto']) {
            return '<a href="topJuegos.php?accion=agregarJuego" class="juego-button">Añadir Juego</a>';
        } else {
            return '<a href="topJuegos.php?accion=sugerirJuego" class="juego-button">Sugerir Juego</a>';
        }
    }
    return '';
}

function buildFormularioAgregarJuego() {
    return <<<HTML
    <form class="formulario-agregar" action="juegos/nuevoJuego.php" method="post">
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
        
        <input type="submit" value="Añadir videojuego">
    </form>
    HTML;
}

function buildFormularioSugerirJuego() {
    return <<<HTML
    <form class="formulario-sugerir" action="juegos/procesarSugerirJuego.php" method="post">
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
        
        <input type="submit" value="Sugerir videojuego">
    </form>
    HTML;
}

function listaJuegos($orden = 'notaDesc') {
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
        $listaHtml .= "<div class=\"juego\">
                       <div class=\"posicion-juego\">Top $posicion</div>
                       <form action='verJuego.php' method='post'>
                            <input type='hidden' name='id' value='$id'>
                            <button type='submit' class='borrar-button'>$nombre</button>
                         </form>
                         <div class=\"nota-juego\">{$juego->getNota()}</div>
                       </div>";
        $posicion++;
    }
    $listaHtml .= '</div>';
    return $listaHtml;
}
?>