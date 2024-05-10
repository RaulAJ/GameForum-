<?php

echo '<link rel="stylesheet" href="css/estilos.css">';

require_once 'config.php';
require_once 'vistas/helpers/juegos.php';
require_once 'src/juegos/bd/Juego.php';
$tituloPagina='Detalles del juego';
$mensaje = ''; 
$contenidoPrincipal = '';

if (isset($_POST['id'])){         //Si viene desde topjuegos
    $id = intval($_POST['id']);
}elseif(isset($_POST['juego'])){  //Si viene desde foro
    $id = Juego::obtenerIdJuego($_POST['juego']);
}
$juego = Juego::obtenerJuego($id);
// Obtener los detalles del juego
$nombre = htmlspecialchars($juego->getNombreJuego());
$anio = htmlspecialchars($juego->getAnioDeSalida());
$desarrollador = htmlspecialchars($juego->getDesarrollador());
$genero = htmlspecialchars($juego->getGenero());
$nota = $juego->getNota();
$descripcion = htmlspecialchars($juego->getDescripcion()); 
    
$contenidoPrincipal .= 
    "<div class='juego-detalle'>
        <h2>$nombre</h2>
        <p><strong>Año de salida:</strong> $anio</p>
        <p><strong>Desarrollador:</strong> $desarrollador</p>
        <p><strong>Género:</strong> $genero</p>
        <p><strong>Nota:</strong> $nota </p>
        <p><strong>Descripción:</strong> $descripcion</p>
    </div>";


require 'vistas/comun/layout.php';
