<?php

function buildFormularioLogin($username='', $password='')
{
    return <<<EOS
        <form id="formLogin" class="login-form" action="procesarLogin.php" method="POST">
            <fieldset>
                <legend>Usuario y contraseña</legend>
                <div><label class="form-label">Usuario:</label> <input type="text" name="username" class="form-input" value="$username" /></div>
                <div><label class="form-label">Contraseña:</label> <input type="password" name="password" class="form-input" value="$password" /></div>
                <div><button type="submit" class="form-button">Entrar</button></div>
            </fieldset>
        </form>
    EOS;
}

?>

