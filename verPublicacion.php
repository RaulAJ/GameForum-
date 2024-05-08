<?php

echo '<link rel="stylesheet" href="css/estilos.css">';

require_once 'config.php';
require_once 'vistas/helpers/publicaciones.php';
require_once 'src/foro/bd/Publicacion.php';

$mensaje = ''; 
$contenidoPrincipal = '';

if (isset($_POST['id'])){        
    $id = intval($_POST['id']);
}

$publicacion = Publicacion::obtenerPublicacionPorId($id);

// Obtener los detalles del juego
$titulo = htmlspecialchars($publicacion->getTitulo());
$usuario = htmlspecialchars($publicacion->getUsuario());
$juego = htmlspecialchars($publicacion->getJuego());
$tipo = htmlspecialchars($publicacion->getTipo());
$fecha = $publicacion->getFecha();
$contenido = htmlspecialchars($publicacion->getContenido()); 
    
$contenidoPrincipal .= 
    "<div class='publicacion-detalle'>
        <h2>$titulo</h2>
        <p><strong>Usuario:</strong> $usuario</p>
        <p class=\"juego-publicacion\">Juego: 
                        <form action='verJuego.php' method='post'>
                            <input type='hidden' name='juego' value='$juego'>
                            <button type='submit' class='verPublicacion-button'>$juego</button>
                        </form></p>
        <p><strong>Tipo:</strong> $tipo</p>
        <p><strong>Fecha:</strong> $fecha </p>
        <p><strong>Descripción:</strong> $contenido</p>
    </div>";

$contenidoPrincipal .= "<div class separador></div>";  //esto no va

$contenidoPrincipal .= 
    "<div class publicacion-respuestas>
        <h2>Respuestas:</h2>
    </div>";

$contenidoPrincipal .= listaRespuestas($id);

require 'vistas/comun/layout.php';
