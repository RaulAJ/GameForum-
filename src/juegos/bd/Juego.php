<?php

class Juego 
{
    use MagicProperties;

    /** @var int El ID único del juego. */
    private $id;
    /** @var string El nombre del juego. */
    private $nombreJuego;
    /** @var int El año de salida/publicacion del juego. */
    private $anioDeSalida;
    /** @var string El nombre del desarrollador del juego. */
    private $desarrollador;
    /** @var string El género del juego. */
    private $genero;
    /** @var float La nota o calificación del juego. */
    private $nota;
    /** @var string Una breve descripción del juego. */
    private $descripcion;

    /**
     * Constructor de la clase Juego.
     *
     * Inicializa una nueva instancia de la clase Juego con los datos proporcionados.
     *
     * @param int $id El ID del juego.
     * @param string $nombreJuego El nombre del juego.
     * @param int $anioDeSalida El año de salida del juego.
     * @param string $desarrollador El desarrollador del juego.
     * @param string $genero El género del juego.
     * @param float $nota La nota o calificación del juego.
     * @param string $descripcion Una breve descripción del juego.
     */
    private function __construct($nombreJuego, $anioDeSalida, $desarrollador, $genero, $nota, $descripcion) {
        $this->nombreJuego = $nombreJuego;
        $this->anioDeSalida = $anioDeSalida;
        $this->desarrollador = $desarrollador;
        $this->genero = $genero;
        $this->nota = $nota;
        $this->descripcion = $descripcion;
    }

    public function getId() { return $this->id; }
    public function getNombreJuego() { return $this->nombreJuego; }
    public function getAnioDeSalida() { return $this->anioDeSalida; }
    public function getDesarrollador() { return $this->desarrollador; }
    public function getGenero() { return $this->genero; }
    public function getNota() { return $this->nota; }
    public function getDescripcion() { return $this->descripcion; }

    public static function crea($nombreJuego, $anioDeSalida, $desarrollador, $genero, $nota, $descripcion)
    {
        $juego = new Juego($nombreJuego, $anioDeSalida, $desarrollador, $genero, $nota, $descripcion);
        return $juego->guarda();
    }

    //Funciones de gestion de la BD

    public function guarda() 
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }

    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }

    private static function inserta(Juego $juego)
    {
        $result = false;
        $conn = BD::getInstance()->getConexionBd();
        if ($conn) {
            $query = sprintf("INSERT INTO videojuegos (ID, Juego, `Año de salida`, Desarrollador, Genero, Nota, Descripcion) VALUES ('%s', '%s', '%s', '%s', '%s', '%f', '%s')",
                $conn->real_escape_string($juego->getId()),
                $conn->real_escape_string($juego->getNombreJuego()),
                $conn->real_escape_string($juego->getAnioDeSalida()),
                $conn->real_escape_string($juego->getDesarrollador()),
                $conn->real_escape_string($juego->getGenero()),
                $juego->getNota(),
                $conn->real_escape_string($juego->getDescripcion())
            );

            if ($conn->query($query)) {
                $juego->id = $conn->insert_id;
                $result = true;
            } else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        }

        return $result;
    }

    //TODO: actualiza, borra

    private static function actualiza(Juego $juego)
    {

    }

    private static function borra(Juego $juego)
    {

    }

}