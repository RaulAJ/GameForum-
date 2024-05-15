<?php

class Publicacion
{

    use MagicProperties;

    // Constantes de longitud máxima
    const MAX_TITULO_LENGTH = 20;
    const MAX_USUARIO_LENGTH = 15;
    const MAX_JUEGO_LENGTH = 20;
    const MAX_TIPO_LENGTH = 10;
    const MAX_CONTENIDO_LENGTH = 1000;

    // Atributos
    private $id;
    private $titulo;
    private $usuario;
    private $juego;
    private $tipo;
    private $fecha;
    private $contenido;

    // Constructor
    public function __construct($titulo, $usuario, $juego, $tipo, $fecha, $contenido, $id)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->usuario = $usuario;
        $this->juego = $juego;
        $this->tipo = $tipo;
        $this->fecha = $fecha;
        $this->contenido = $contenido;
    }

    // Método para validar los datos
    private static function validaDatos($titulo, $usuario, $juego, $tipo, $contenido)
    {
        return strlen($titulo) <= self::MAX_TITULO_LENGTH &&
            strlen($usuario) <= self::MAX_USUARIO_LENGTH &&
            strlen($juego) <= self::MAX_JUEGO_LENGTH &&
            strlen($tipo) <= self::MAX_TIPO_LENGTH &&
            strlen($contenido) <= self::MAX_CONTENIDO_LENGTH;
    }

    public static function crea($titulo, $usuario, $juego, $tipo, $fecha, $contenido)
    {
        if (!self::validaDatos($titulo, $usuario, $juego, $tipo, $contenido)) {
            error_log("Error: Datos demasiado largos para la creación.");
            return false;
        }
        
        $publicacion = new Publicacion($titulo, $usuario, $juego, $tipo, $fecha, $contenido, null);
        if ($publicacion->guarda()) {
            return $publicacion->getId(); // Devuelve el ID en lugar de true
        } else {
            return false;
        }
    }

    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    private static function inserta(Publicacion $publicacion)
    {
        if (!self::validaDatos($publicacion->getTitulo(), $publicacion->getUsuario(), $publicacion->getJuego(), $publicacion->getTipo(), $publicacion->getContenido())) {
            error_log("Error: Datos demasiado largos para la inserción.");
            return false;
        }

        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        // Insertar en foro
        $query = sprintf(
            "INSERT INTO foro (Titulo, Usuario, Juego, Tipo, Fecha, Contenido) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
            $conn->real_escape_string($publicacion->getTitulo()),
            $conn->real_escape_string($publicacion->getUsuario()),
            $conn->real_escape_string($publicacion->getJuego()),
            $conn->real_escape_string($publicacion->getTipo()),
            $conn->real_escape_string($publicacion->getFecha()),
            $conn->real_escape_string($publicacion->getContenido()),
        );

        if ($conn->query($query)) {
            $publicacion->id = $conn->insert_id; //actualizar noticia con el id generado automaticamente por la ultima insercion
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    public static function actualiza(Publicacion $publicacion)
    {
        if (!self::validaDatos($publicacion->getTitulo(), $publicacion->getUsuario(), $publicacion->getJuego(), $publicacion->getTipo(), $publicacion->getContenido())) {
            error_log("Error: Datos demasiado largos para la inserción.");
            return false;
        }

        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        $query = sprintf(
            "UPDATE foro SET Titulo='%s', Usuario='%s', Juego='%s', Tipo='%s', Fecha='%s', Contenido='%s' WHERE ID=%d",
            $conn->real_escape_string($publicacion->getTitulo()),
            $conn->real_escape_string($publicacion->getUsuario()),
            $conn->real_escape_string($publicacion->getJuego()),
            $conn->real_escape_string($publicacion->getTipo()),
            $conn->real_escape_string($publicacion->getFecha()),
            $conn->real_escape_string($publicacion->getContenido()),
            $publicacion->getId()
        );

        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error al actualizar la publicacion en la BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    public static function obtenerPublicaciones()
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            error_log("Error al conectar a la base de datos");
            return [];
        }

        $query = "SELECT * FROM foro ORDER BY Fecha DESC";
        $result = $conn->query($query);

        $foro = [];
        if ($result) {
            while ($fila = $result->fetch_assoc()) {
                $foro[] = new Publicacion(
                    $fila['Titulo'],
                    $fila['Usuario'],
                    $fila['Juego'],
                    $fila['Tipo'],
                    $fila['Fecha'],
                    $fila['Contenido'],
                    $fila['ID']
                );
            }
            $result->free();
        } else {
            error_log("Error al obtener las publicaciones: ({$conn->errno}): {$conn->error}");
        }
        return $foro;
    }
    public static function obtenerPublicacionPorId($id)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            error_log("Error al conectar a la base de datos");
            return null;
        }

        $query = sprintf("SELECT * FROM foro WHERE ID = %d", intval($id));
        $result = $conn->query($query);
        if ($result) {
            $fila = $result->fetch_assoc();
            if ($fila) {
                return new Publicacion(
                    $fila['Titulo'],
                    $fila['Usuario'],
                    $fila['Juego'],
                    $fila['Tipo'],
                    $fila['Fecha'],
                    $fila['Contenido'],
                    $fila['ID']
                );
            }
            $result->free();
        } else {
            error_log("Error al obtener la publicacion por ID: ({$conn->errno}): {$conn->error}");
        }
        return null;
    }

    public function borrate()
    {
        if ($this->id !== null) {
            return self::borraPublicacion($this->id);
        }
        return false;
    }

    public static function borraPublicacion($id)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        $query = sprintf("DELETE FROM foro WHERE ID = %d", $id);

        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error al borrar la publicacion ({$conn->errno}): {$conn->error}");
            return false;
        }
    }
    // Métodos para obtener y establecer los valores de los atributos
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
    public function getJuego()
    {
        return $this->juego;
    }
    public function setJuego($juego)
    {
        $this->juego = $juego;
    }
    public function getTipo()
    {
        return $this->tipo;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function getContenido()
    {
        return $this->contenido;
    }
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;
    }

}

