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
    ?>
    <?= $contenidoPrincipal ?> 
    <?php
	exit();
}

$_SESSION['usuario'] = $usuario->nombreUsuario;
$_SESSION['usuarioNombre'] = $usuario->nombreCompleto;
$_SESSION['edad'] = $usuario->edad;
$_SESSION['experto'] = $usuario->experto;
$_SESSION['correo'] = $usuario->correo;
$_SESSION['admin'] = $usuario->admin;
$_SESSION['moderador'] = $usuario->moderador;


$contenidoPrincipal=<<<EOS
	<h1>Bienvenido {$_SESSION['nombre']}</h1>
	<p>Usa el menú de la izquierda para navegar.</p>
EOS;
//cambiar en el futuro
?>
<?= $contenidoPrincipal ?> 
