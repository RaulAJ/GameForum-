<?php

require_once 'config.php';
require_once 'vistas/helpers/juegos.php';
require_once 'src/juegos/bd/Juego.php';
require_once 'vistas/helpers/juegos.php';

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
    '<div class="juego-detalle">
        <h2>'.$nombre.'</h2>
        <p>Año de salida: '.$anio.'</p>
        <p>Desarrollador: '.$desarrollador.'</p>
        <p>Género: '.$genero.'</p>
        <p>Nota: '.$nota.' </p>
        <p>Descripción: '.$descripcion.'</p>
    </div>';

    $contenidoPrincipal .= "<h2>Valora este juego!</h2> ";
    $contenidoPrincipal .= buildFormularioValorarJuego($id);
    


require 'vistas/comun/layout.php';
