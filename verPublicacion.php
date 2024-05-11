<?php

require_once 'config.php';
require_once 'vistas/helpers/publicaciones.php';
require_once 'vistas/helpers/respuestas.php';
require_once 'src/foro/bd/Publicacion.php';

$mensaje = ''; 
$contenidoPrincipal = '';
$tituloPagina = 'Detalles de la publicación';

if (!isset($_POST['accion'])){
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
    "<div class='seccion-info'>
        <h2>$titulo</h2>
        <div class='info-detalle'>
            <p class='info-label'>Usuario:</p>
            <p class='info-valor'>$usuario</p>
        </div>
        <div class='info-detalle'>
            <p class='info-label'>Juego:</p>
            <p class='info-valor'>
                <form action='verJuego.php' method='post'>
                    <input type='hidden' name='juego' value='$juego'>
                    <button type='submit' class='game-button'>$juego</button>
                </form>
            </p>
        </div>
        <div class='info-detalle'>
            <p class='info-label'>Tipo:</p>
            <p class='info-valor'>$tipo</p>
        </div>
        <div class='info-detalle'>
            <p class='info-label'>Fecha:</p>
            <p class='info-valor'>$fecha</p>
        </div>
        <div class='info-detalle'>
            <p class='info-label'>Descripción:</p>
            <p class='info-valor'>$contenido</p>
        </div>
    </div>";

    
    $contenidoPrincipal .= "<div class ='separador'></div>";  //esto no va
    
    $contenidoPrincipal .= mostrarBotonAgregarRespuesta($id);
    
    $contenidoPrincipal .= 
    "<div class='publicacion-respuestas'>
        <h2>Respuestas:</h2>
    </div>";

    $contenidoPrincipal .= listaRespuestas($id);
}
elseif (isset($_POST['accion']) && $_POST['accion'] === 'agregarRespuesta') {
    $id = $_POST['id'];
    $contenidoPrincipal .= buildFormularioRespuesta($id);
}




require 'vistas/comun/layout.php';
