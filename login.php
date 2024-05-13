<?php
require_once 'config.php';
require_once 'vistas/helpers/login.php';


$tituloPagina = 'Login';

$htmlFormLogin = buildFormularioLogin();

$contenidoPrincipal=<<<EOS
<h1>Acceso al sistema</h1>
$htmlFormLogin
<div class="register-message-container">
    <p class="register-message">¿No tienes cuenta? <a href="registrarse.php" class="register-link">Regístrate</a></p>
</div>
EOS;

require_once 'vistas/comun/layout.php';
