<?php

class Usuario
{

    use MagicProperties;

    public static function login($nombreUsuario, $password)
    {
        $usuario = self::buscaUsuario($nombreUsuario);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return $usuario;
        }
        if (!$usuario) {
            error_log("Error al buscar usuario: login");
        }
        error_log("Error al comprobar password");
        return false;
    }

    public static function crea($nombreUsuario, $nombreCompleto, $edad, $correo, $password, $experto, $moderador, $admin, $juegosValorados)
    {
        $passwordHash = self::hashPassword($password);
        $user = new Usuario($nombreUsuario, $passwordHash, $nombreCompleto, $edad, $correo, $experto, $moderador, $admin, $juegosValorados);
        return $user->guarda();
    }


    public static function compruebaValorado($idUsuario, $idJuego)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT JuegosValorados FROM usuarios  WHERE Usuario='%s'", $conn->real_escape_string($idUsuario));
        $rs = $conn->query($query);
        if ($rs) {
            $fila = $rs->fetch_assoc();
            $rs->free();
            if ($fila) {
                $juegosValorados = $fila['JuegosValorados'];
                $juegosValoradosArray = explode(", ", $juegosValorados);
                return in_array($idJuego, $juegosValoradosArray);
            } else {
                return false; // Usuario no encontrado
            }
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    public static function aniadirValoracion($idUsuario, $idJuego)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("UPDATE usuarios SET JuegosValorados = CONCAT(JuegosValorados, ', %d') WHERE Usuario='%s'", $idJuego, $conn->real_escape_string($idUsuario));
        if ($conn->query($query)) {
            return true; // Valoración añadida con éxito
        } else {
            error_log("Error al actualizar la base de datos: {$conn->errno} - {$conn->error}");
            return false; // Error al actualizar la base de datos
        }
    }


    public static function buscaUsuario($nombreUsuario)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios  WHERE Usuario='%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['Usuario'], $fila['Contraseña'], $fila['Nombre Completo'], $fila['Edad'], $fila['Correo'], $fila['Experto'], $fila['Moderador'], $fila['Admin'], $fila['JuegosValorados']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private static function inserta($usuario)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO usuarios (Usuario, `Nombre Completo`, Edad, Correo, Contraseña, Experto, Moderador, Admin, JuegosValorados) 
        VALUES ('%s', '%s', %d, '%s', '%s', %d, %d, %d, '%s')"
            ,
            $conn->real_escape_string($usuario->nombreUsuario)
            ,
            $conn->real_escape_string($usuario->nombreCompleto)
            ,
            $conn->real_escape_string($usuario->edad)
            ,
            $conn->real_escape_string($usuario->correo)
            ,
            $usuario->password
            ,
            $conn->real_escape_string($usuario->experto)
            ,
            $conn->real_escape_string($usuario->moderador)
            ,
            $conn->real_escape_string($usuario->admin)
            ,
            $conn->real_escape_string($usuario->juegosValorados)
        );
        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }


    private static function actualiza($usuario)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "UPDATE usuarios U SET nombreUsuario = '%s', nombre='%s', password='%s' WHERE U.id=%d"
            ,
            $conn->real_escape_string($usuario->nombreUsuario)
            ,
            $conn->real_escape_string($usuario->nombre)
            ,
            $conn->real_escape_string($usuario->password)
            ,
            $usuario->id
        );
        if ($conn->query($query)) {
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }


    private static function borra($usuario)
    {
        return self::borraPorId($usuario->id);
    }

    private static function borraPorId($nombreUsuario)
    {
        if (!$nombreUsuario) {
            return false;
        }
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "DELETE FROM usuarios WHERE Usuario = '%s'",
            $conn->real_escape_string($nombreUsuario)
        );
        if (!$conn->query($query)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private $nombreUsuario;

    private $nombreCompleto;

    private $edad;

    private $correo;

    private $experto;

    private $moderador;

    private $admin;

    private $password;

    private $juegosValorados;


    private function __construct($nombreUsuario, $password, $nombreCompleto, $edad, $correo, $experto, $moderador, $admin, $juegosValorados)
    {
        $this->nombreUsuario = $nombreUsuario;
        $this->password = $password;
        $this->nombreCompleto = $nombreCompleto;
        $this->edad = $edad;
        $this->correo = $correo;
        $this->experto = $experto;
        $this->admin = $admin;
        $this->moderador = $moderador;
        $this->juegosValorados = $juegosValorados;
    }


    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    public function getNombreCompleto()
    {
        return $this->nombreCompleto;
    }

    public function getEdad()
    {
        return $this->edad;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getExperto()
    {
        return $this->experto;
    }

    public function getAdmin()
    {
        return $this->admin;
    }
    public function getModerador()
    {
        return $this->moderador;
    }
    public function getJuegosValorados()
    {
        return $this->juegosValorados;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }

    public function guarda()
    {
        return self::inserta($this);
    }

    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
}
