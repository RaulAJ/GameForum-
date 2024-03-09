<?php

require_once 'vistas/helpers/usuarios.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi gran página web</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1>GameForum!</h1>
            </div>
            <div class="login">
				<?= saludo() ?>
            </div>
        </div>
    </header>

    <nav>
        <div class="container">
            <ul>
                <li><a href="#">Foro</a></li>
                <li><a href="#">Noticias</a></li>
                <li><a href="#">Top Juegos</a></li>
            </ul>
        </div>
    </nav>

    <!-- El resto del contenido de tu página va aquí -->

</body>
</html>
