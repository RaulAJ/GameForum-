<?php

require_once '../config.php';
require_once '../src/noticias/bd/Noticia.php';

// Verifica si se ha enviado un ID de noticia
if(isset($_GET['id'])) {
    // Obtén el ID de la noticia de la URL
    $id_noticia = $_GET['id'];

    Noticia::borraNoticia($id_noticia);
    header('Location: ../noticias.php');
    exit();
} else {
    // Si no se proporcionó un ID de noticia, redirige de vuelta a la página de noticias
    header('Location: ../noticias.php');
    exit();
}
?>
