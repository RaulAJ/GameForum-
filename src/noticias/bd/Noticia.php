<?php

class Noticia {

    use MagicProperties;

    // Atributos
    private $id;
    private $titulo;
    private $usuario;
    private $fecha;
    private $contenido;

    // Constructor, la id ya no es siempre null para poder editar noticias
    public function __construct($titulo, $usuario, $fecha, $contenido, $id) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->usuario = $usuario;
        $this->fecha = $fecha;
        $this->contenido = $contenido;
    }

    public static function crea($titulo, $usuario, $fecha, $contenido)
    {
        $noticia = new Noticia($titulo, $usuario, $fecha, $contenido, null);
        return $noticia->guarda();
    }

    public function guarda() 
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    private static function inserta(Noticia $noticia)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }       

        // Insertar en Noticias
        $query = sprintf(
            "INSERT INTO noticias (Titulo, Usuario, Fecha, Contenido) VALUES ('%s', '%s', '%s', '%s')",
            $conn->real_escape_string($noticia->getTitulo()),
            $conn->real_escape_string($noticia->getUsuario()),
            $conn->real_escape_string($noticia->getFecha()),
            $conn->real_escape_string($noticia->getContenido()),
        );

        if ($conn->query($query)) {
            $noticia->id = $conn->insert_id; //actualizar noticia con el id generado automaticamente por la ultima insercion
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    public static function actualiza(Noticia $noticia)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        $query = sprintf(
            "UPDATE noticias SET Titulo='%s', Usuario='%s', Fecha='%s', Contenido='%s' WHERE ID= %d",
            $conn->real_escape_string($noticia->getTitulo()),
            $conn->real_escape_string($noticia->getUsuario()),
            $conn->real_escape_string($noticia->getFecha()),
            $conn->real_escape_string($noticia->getContenido()),
            $noticia->getId()
        );
        
        if ($conn->query($query)) {
            return true; 
        } else {
            error_log("Error al actualizar la noticia en la BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    public static function obtenerNoticias(){
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            error_log("Error al conectar a la base de datos");
            return [];
        }

        $query = "SELECT * FROM noticias ORDER BY Fecha DESC";
        $result = $conn->query($query);

        $noticias = [];
        if ($result) {
            while ($fila = $result->fetch_assoc()) {
                $noticias[] = new Noticia(
                    $fila['Titulo'],
                    $fila['Usuario'],
                    $fila['Fecha'],
                    $fila['Contenido'],
                    $fila['ID']
                );
            }
            $result->free();
        } else {
            error_log("Error al obtener las noticias: ({$conn->errno}): {$conn->error}");
        }
        return $noticias;
    }
    public static function obtenerNoticiaPorId($id) {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            error_log("Error al conectar a la base de datos");
            return null;
        }

        $query = sprintf("SELECT * FROM noticias WHERE ID = %d", intval($id));
        $result = $conn->query($query);
        if ($result) {
            $fila = $result->fetch_assoc();
            if ($fila) {
                return new Noticia(
                    $fila['Titulo'],
                    $fila['Usuario'],
                    $fila['Fecha'],
                    $fila['Contenido'],
                    $fila['ID']
                );
            }
            $result->free();
        } else {
            error_log("Error al obtener la noticia por ID: ({$conn->errno}): {$conn->error}");
        }
        return null;
    }


    public function borrate()
    {
        if ($this->id !== null) {
            return self::borraNoticia($this->id);
        }
        return false;
    }

    public static function borraNoticia($id)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        $query = sprintf("DELETE FROM noticias WHERE ID = %d", $id);

        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error al borrar la noticia ({$conn->errno}): {$conn->error}");
            return false;
        }
    }
    // Métodos para obtener y establecer los valores de los atributos
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getTitulo() {
        return $this->titulo;
    }
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    public function getUsuario() {
        return $this->usuario;
    }
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    public function getFecha() {
        return $this->fecha;
    }
    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
    public function getContenido() {
        return $this->contenido;
    }
    public function setContenido($contenido) {
        $this->contenido = $contenido;
    }

}

