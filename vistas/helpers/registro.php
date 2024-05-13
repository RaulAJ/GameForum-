<?php

function buildFormularioRegistro($username='', $password='', $nombreCompleto='', $edad='', $correo='')
{
    return <<<EOS
    <link rel="stylesheet" type="text/css" href="registro.css">
    <form id="formRegistro" class="registro-form" action="procesarRegistro.php" method="POST">
        <fieldset>
            <legend>Registro</legend>
            <div><label class="form-label">Usuario:</label> <input type="text" name="username" value="$username" class="form-input" id="campoUser"/></div>
            <span id="validUser" class="validation-message"></span>
            <div><label class="form-label">Nombre completo:</label> <input type="text" name="nombreCompleto" value="$nombreCompleto" class="form-input" /></div>
            <div><label class="form-label">Edad:</label> <input type="text" name="edad" value="$edad" class="form-input" /></div>
            <div><label class="form-label">Correo:</label> <input type="text" name="correo" value="$correo" class="form-input" id="campoEmail"/></div>
            <span id="validEmail" class="validation-message"></span>
            <div><label class="form-label">Contraseña:</label> <input type="password" name="password" value="$password" class="form-input" /></div>
            <div><button type="submit" class="form-button">Registrarse</button></div>
        </fieldset>
    </form>
    EOS;
}