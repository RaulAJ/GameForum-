<?php

function estaLogado()
{
    return isset($_SESSION['usuario']);
}


function esMismoUsuario($idUsuario)
{
    return estaLogado() && $_SESSION['usuario'] == $idUsuario;
}

function idUsuarioLogado()
{
    return $_SESSION['usuario'] ?? false;
}

//TODO: A lo mejor $_SESSION['roles'] ?? admin, moderador, usuario, etc
function esAdmin()
{
    //return estaLogado() && (array_search(Usuario::ADMIN_ROLE, $_SESSION['roles']) !== false);
    return estaLogado() && $_SESSION['admin'];
}

function verificaLogado($urlNoLogado)
{
    if (! estaLogado()) {
        Utils::redirige($urlNoLogado);
    }
}
