<?php
require_once 'vistas/helpers/usuarios.php';
require_once 'vistas/helpers/juegos.php';
require_once 'vistas/helpers/noticias.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>GameForum!</h1>
            </div>
            <div class="Btn">
                <?php
                if (basename($_SERVER['PHP_SELF']) == 'topJuegos.php') {
                    echo mostrarBotonAgregarJuego(); 
                }
                ?>
                <?php
                if (basename($_SERVER['PHP_SELF']) == 'noticias.php') {
                    echo mostrarBotonAgregarNoticia(); 
                }
                ?>
                 <?php
                if (basename($_SERVER['PHP_SELF']) == 'foro.php') {
                    echo mostrarBotonAgregarPublicacion(); 
                }
                ?>
            </div>
            <div class="login">
                <?= saludo() ?>
            </div>
        </div>
    </header>

    <nav>
        <div class="container">
            <ul>
                <li><a href="foro.php">Foro</a></li>
                <li><a href="noticias.php">Noticias</a></li>
                <li><a href="topJuegos.php">Top Juegos</a></li>      
            </ul>
        </div>
    </nav>

</body>
</html>
