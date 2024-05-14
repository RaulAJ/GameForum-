<?php

require_once 'config.php';
require_once 'vistas/helpers/juegos.php';
require_once 'src/juegos/bd/Juego.php';

$tituloPagina = 'Valorar Juego';

$nota = filter_input(INPUT_POST, 'nota', FILTER_VALIDATE_FLOAT);

// Verificar si la nota es válida
if ($nota === false) {
    // Si la nota no es válida, redirigir de vuelta al formulario de valoración
    header("Location: formularioValorarJuego.php");
    exit();
}

$idJuego = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

$exito = Juego::nuevaResenia($idJuego, $nota);


$contenidoPrincipal=<<<EOS
	<h3>Has valorado el juego con un $nota/10</h3>
EOS;

require 'vistas/comun/layout.php';
