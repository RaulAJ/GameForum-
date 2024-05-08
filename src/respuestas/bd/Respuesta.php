<?php

class Respuesta {

    use MagicProperties;

    // Atributos
    private $id;
    private $idforo;
    private $usuario;
    private $fecha;
    private $contenido;

    // Constructor
    public function __construct($idforo, $usuario, $fecha, $contenido, $id) {
        $this->id = $id;
        $this->idforo = $idforo;
        $this->usuario = $usuario;
        $this->fecha = $fecha;
        $this->contenido = $contenido;
    }

    public static function crea($idforo, $usuario, $fecha, $contenido)
    {
        $respuesta = new Respuesta($idforo, $usuario, $fecha, $contenido, null);
        return  $respuesta->guarda();
    }

    public function guarda() 
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    private static function inserta(Respuesta $respuesta)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }       

        $query = sprintf(
            "INSERT INTO respuestas (`ID foro`, Usuario, Fecha, Contenido) VALUES ('%s', '%s', '%s', '%s')",
            $conn->real_escape_string( $respuesta->getIdForo()),
            $conn->real_escape_string( $respuesta->getUsuario()),
            $conn->real_escape_string( $respuesta->getFecha()),
            $conn->real_escape_string( $respuesta->getContenido()),
        );

        if ($conn->query($query)) {
            $respuesta->id = $conn->insert_id; //actualizar noticia con el id generado automaticamente por la ultima insercion
            return true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    public static function actualiza(Respuesta $respuesta)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        $query = sprintf(
            "UPDATE foro SET `ID foro`='%s', Usuario='%s', Fecha='%s', Contenido='%s' WHERE ID=%d",
            $conn->real_escape_string( $respuesta->getIdForo()),
            $conn->real_escape_string( $respuesta->getUsuario()),
            $conn->real_escape_string( $respuesta->getFecha()),
            $conn->real_escape_string( $respuesta->getContenido()),
            $respuesta->getId()
        );
        
        if ($conn->query($query)) {
            return true; 
        } else {
            error_log("Error al actualizar la respuesta en la BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }
    
    public static function obtenerRespuestas($idForo){
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            error_log("Error al conectar a la base de datos");
            return [];
        }

        $query = sprintf("SELECT * FROM respuestas WHERE `ID foro` = %d", intval($idForo));
        $result = $conn->query($query);

        $respuestas = [];
        if ($result) {
            while ($fila = $result->fetch_assoc()) {
                $respuestas[] = new Respuesta(
                    $fila['ID foro'],
                    $fila['Usuario'],
                    $fila['Fecha'],
                    $fila['Contenido'],
                    $fila['ID']
                );
            }
            $result->free();
        } else {
            error_log("Error al obtener las publicaciones: ({$conn->errno}): {$conn->error}");
        }
        return $respuestas;
    }

    
    public static function borraRespuestas($id)   //borra las respuestas de la publicacion
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        $query = sprintf("DELETE FROM respuestas WHERE `ID foro` = %d", $id);

        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error al borrar la respuesta ({$conn->errno}): {$conn->error}");
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
    public function getIdForo() {
        return $this->idforo;
    }
    public function setIdForo($idforo) {
        $this->idforo = $idforo;
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

