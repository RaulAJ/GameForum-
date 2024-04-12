<?php

require_once 'config.php';
require_once 'vistas/helpers/usuarios.php';
require_once 'vistas/helpers/autorizacion.php';
require_once 'vistas/helpers/login.php';

$tituloPagina = 'Login';

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = $_POST["password"] ?? null;

$esValido = $username && $password && ($usuario = Usuario::login($username, $password));
if (!$esValido) {
	$htmlFormLogin = buildFormularioLogin($username, $password);
	$contenidoPrincipal=<<<EOS
		<h1>Error</h1>
		<p>El usuario o contraseña no son válidos.</p>
		$htmlFormLogin
	EOS;
	require 'vistas/comun/layout.php';
	exit();
}

$_SESSION['usuario'] = $usuario->nombreUsuario;
$_SESSION['usuarioNombre'] = $usuario->nombreCompleto;
$_SESSION['edad'] = $usuario->edad;
$_SESSION['experto'] = $usuario->experto;
$_SESSION['correo'] = $usuario->correo;
$_SESSION['admin'] = $usuario->admin;
$_SESSION['moderador'] = $usuario->moderador;

//DEBUG {
$rolesUsuario = '';
if ($_SESSION['admin']) {
    $rolesUsuario .= 'Administrador, ';
}
if ($_SESSION['moderador']) {
    $rolesUsuario .= 'Moderador, ';
}
if (!$_SESSION['admin'] && !$_SESSION['moderador']) { // Suponiendo que todos son al menos 'Usuario' si no son admin o moderador
    $rolesUsuario .= 'Usuario, ';
}
$rolesUsuario = rtrim($rolesUsuario, ', ');

$datosUsuario = <<<HTML
<div class="datos-usuario">
    <ul>
        <li><span class="dato-usuario">Nombre de usuario:</span> {$_SESSION['usuario']}</li>
        <li><span class="dato-usuario">Nombre completo:</span> {$_SESSION['usuarioNombre']}</li>
        <li><span class="dato-usuario">Edad:</span> {$_SESSION['edad']}</li>
        <li><span class="dato-usuario">Experto:</span> {$_SESSION['experto']}</li>
        <li><span class="dato-usuario">Correo electrónico:</span> {$_SESSION['correo']}</li>
        <li><span class="dato-usuario">Rol:</span> $rolesUsuario</li>
    </ul>
</div>
HTML;		
//}
$contenidoPrincipal=<<<EOS
	<h1>Bienvenido {$_SESSION['usuario']}</h1>
	<h2>Datos:</h2>
	$datosUsuario
EOS;

require 'vistas/comun/layout.php';
