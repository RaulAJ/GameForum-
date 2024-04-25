<?php
require_once '../config.php';
require_once '../vistas/helpers/autorizacion.php';
require_once '../src/juegos/bd/Juego.php';
require_once '../vistas/helpers/juegos.php';

$contenidoPrincipal = '';

// Obtener el juego por su ID
//$id = intval($_POST['id']);
$juego = Juego::obtenerJuego(1);
//echo $id;
// Verificar si el juego se encontró
if ($juego) {
    // Obtener los detalles del juego
    $nombre = htmlspecialchars($juego->getNombreJuego());
    $anio = htmlspecialchars($juego->getAnioDeSalida());
    $desarrollador = htmlspecialchars($juego->getDesarrollador());
    $genero = htmlspecialchars($juego->getGenero());
    $nota = $juego->getNota();
    $descripcion = htmlspecialchars($juego->getDescripcion());

    // Construir la estructura HTML para mostrar los detalles del juego
    $contenidoPrincipal .= 
    '<div class="juego-detalle">
        <h2>$nombre</h2>
        <p><strong>Año de salida:</strong> $anio</p>
        <p><strong>Desarrollador:</strong> $desarrollador</p>
        <p><strong>Género:</strong> $genero</p>
        <p><strong>Nota:</strong> $nota</p>
        <p><strong>Descripción:</strong> $descripcion</p>
    </div>';
    
    
}  

return $contenidoPrincipal;
?>

