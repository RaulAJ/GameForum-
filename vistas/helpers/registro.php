<?php

function buildFormularioRegistro($username='', $password='', $nombreCompleto='', $edad='', $correo='')
{
    return <<<EOS
    <form id="formRegistro" action="procesarRegistro.php" method="POST">
        <fieldset>
            <legend>Registro</legend>
            <div><label>Usuario:</label> <input type="text" name="username" value="$username" id="campoUser"/></div>
            <span id="validUser"></span> </div>
            <div><label>Nombre completo:</label> <input type="text" name="nombreCompleto" value="$nombreCompleto" /></div>
            <div><label>Edad:</label> <input type="text" name="edad" value="$edad" /></div>
            <div><label>Correo:</label> <input type="text" name="correo" value="$correo" id="campoEmail"/></div>
            <span id="validEmail"></span> </div>
            <div><label>Contraseña:</label> <input type="password" name="password" password="$password" /></div>
            <div><button type="submit">Entrar</button></div>
        </fieldset>
    </form>
    EOS;
}