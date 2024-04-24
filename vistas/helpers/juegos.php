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

function mostrarJuego($id) {
    // Obtener el juego desde la base de datos según su ID
    $juego = Juego::obtenerJuego($id);
    // Construir la estructura HTML para mostrar los detalles del juego
    $nombre = htmlspecialchars($juego->getNombreJuego());
    $anio = htmlspecialchars($juego->getAnioDeSalida());
    $desarrollador = htmlspecialchars($juego->getDesarrollador());
    $genero = htmlspecialchars($juego->getGenero());
    $nota = $juego->getNota();
    $descripcion = htmlspecialchars($juego->getDescripcion());

    $html = <<<HTML
    <div class="juego-detalle">
        <h2>$nombre</h2>
        <p><strong>Año de salida:</strong> $anio</p>
        <p><strong>Desarrollador:</strong> $desarrollador</p>
        <p><strong>Género:</strong> $genero</p>
        <p><strong>Nota:</strong> $nota</p>
        <p><strong>Descripción:</strong> $descripcion</p>
    </div>
    HTML;

    return $html;
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
        $nombre = htmlspecialchars($juego->getNombreJuego());
        $listaHtml .= "<div class=\"juego\">
        <div class=\"posicion-juego\">Top $posicion</div>
        <div class=\"nombre-juego\"><a href=?accion=verJuego&id={$juego->getId()}>$nombre</a></div>
        <div class=\"nota-juego\">{$juego->getNota()}</div>
    </div>";
        $posicion++;
    }
    $listaHtml .= '</div>';
    return $listaHtml;
}
?>