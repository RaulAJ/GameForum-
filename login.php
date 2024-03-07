<?php
require_once 'config.php';
require_once 'vistas/login.php';


$tituloPagina = 'Login';

$htmlFormLogin = buildFormularioLogin();
$contenidoPrincipal=<<<EOS
<h1>Acceso al sistema</h1>
$htmlFormLogin
EOS;
