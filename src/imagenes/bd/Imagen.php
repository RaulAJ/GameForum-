<?php
require_once __DIR__ . "/../../../config.php";
class Imagen
{

    private $id;
    private $ruta;
    private $descripcion;
    private $videojuego_id;
    private $noticia_id;
    private $foro_id;

    private $sugerencia_juego_id;

    public function __construct($id, $ruta, $descripcion, $videojuego_id = null, $noticia_id = null, $foro_id = null, $sugerencia_juego_id = null)
    {
        $this->id = $id;
        $this->ruta = $ruta;
        $this->descripcion = $descripcion;
        $this->videojuego_id = $videojuego_id;
        $this->noticia_id = $noticia_id;
        $this->foro_id = $foro_id;
        $this->sugerencia_juego_id = $sugerencia_juego_id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRuta()
    {
        return $this->ruta;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public static function crea($file, $descripcion, $videojuego_id = null, $noticia_id = null, $foro_id = null, $sugerencia_juego_id = null)
    {
        $imagen = new Imagen(null, $file['name'], $descripcion, $videojuego_id, $noticia_id, $foro_id, $sugerencia_juego_id);
        return $imagen->guarda($file);
    }
    /**
     * Guarda la info de la imagen en la base de datos. Determina si debe insertar una imagen o actualizar una existente.
     * 
     * @return mixed imagen->id si se creó con exito, True si la imagen se actualizó con éxito, false si hubo un error.
     */
    public function guarda($file)
    {
        error_log("imagen::guarda");
        if ($this->id === null) {
            error_log("imagen::subir");
            return self::subir($file, $this->videojuego_id, $this->noticia_id, $this->foro_id, $this->sugerencia_juego_id);
        } else {
            return self::actualiza($this->id, $this->ruta, $this->descripcion, $this->videojuego_id, $this->noticia_id, $this->foro_id, $this->sugerencia_juego_id);
        }
    }

    private static function actualiza($id, $ruta, $descripcion, $videojuego_id = null, $noticia_id = null, $foro_id = null, $sugerencia_juego_id = null)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        $query = sprintf(
            "UPDATE imagenes SET ruta='%s', descripcion='%s', videojuego_id=%s, noticia_id=%s, foro_id=%s, sugerencia_juego_id=%s WHERE id=%d",
            $conn->real_escape_string($ruta),
            $conn->real_escape_string($descripcion),
            $videojuego_id ? $conn->real_escape_string($videojuego_id) : 'NULL',
            $noticia_id ? $conn->real_escape_string($noticia_id) : 'NULL',
            $foro_id ? $conn->real_escape_string($foro_id) : 'NULL',
            $sugerencia_juego_id ? $conn->real_escape_string($sugerencia_juego_id) : 'NULL',
            $id
        );

        if ($conn->query($query)) {
            return true;
        } else {
            error_log("Error al actualizar la imagen en la BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    /**
     * Sube una imagen al servidor y crea un registro en la base de datos.
     *
     * @param array $file Array de $_FILES['nombre_input'].
     * @return mixed Retorna el ID de la imagen en la base de datos o false si ocurre un error.
     */
    public static function subir($file, $videojuego_id = null, $noticia_id = null, $foro_id = null, $sugerencia_juego_id = null)
    {
        $target_dir = RUTA_UPLOADS . '/';
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));

        if (!self::verificarImagen($file, $file["tmp_name"])) {
            return false;
        }

        // Generar nombre de archivo único
        $uniqueFileName = uniqid("img_", true) . '.' . $imageFileType;
        $target_file = $target_dir . $uniqueFileName; // Ruta absoluta para mover el archivo
        $relative_path = 'uploads/' . $uniqueFileName; // Ruta relativa para guardar en la BD

        // nombre original del archivo como descripción
        $descripcion = $file['name'];

        // Intentar mover la imagen al directorio de destino
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            error_log("Failed to move file to $target_file");
            return false;
        }

        // Insertar la información de la imagen en la base de datos
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf(
            "INSERT INTO imagenes (ruta, descripcion, videojuego_id, noticia_id, foro_id, sugerencia_juego_id) VALUES ('%s', '%s', %s, %s, %s, %s)",
            $conn->real_escape_string($relative_path),
            $conn->real_escape_string($descripcion),
            $videojuego_id ? $conn->real_escape_string($videojuego_id) : 'NULL',
            $noticia_id ? $conn->real_escape_string($noticia_id) : 'NULL',
            $foro_id ? $conn->real_escape_string($foro_id) : 'NULL',
            $sugerencia_juego_id ? $conn->real_escape_string($sugerencia_juego_id) : 'NULL'
        );

        if ($conn->query($query)) {
            return $conn->insert_id;
        } else {
            error_log("Error guardando la imagen en la BD: " . $conn->error);
            // Si falla la inserción, eliminar el archivo subido
            unlink($target_file);
            return false;
        }
    }
    private static function verificarImagen($file, $filePath)
    {
        // Verificar si el archivo es realmente una imagen mediante getimagesize
        $check = getimagesize($filePath);
        if ($check === false) {
            error_log("El archivo no es una imagen.");
            return false;
        }

        // Obtener la extensión del archivo de una manera más fiable
        $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $valid_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $valid_types)) {
            error_log("Extensión de archivo no permitida: " . $imageFileType);
            return false;
        }

        return true;
    }

    /**
     * Elimina una imagen tanto del servidor como de la base de datos.
     *
     * @param int $id ID de la imagen a eliminar.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     */
    public static function eliminar($id)
    {
        $conn = BD::getInstance()->getConexionBd();
        $query = sprintf("SELECT ruta FROM imagenes WHERE id = %d", $id);
        $resultado = $conn->query($query);

        if ($resultado) {
            $fila = $resultado->fetch_assoc();
            if (unlink($fila['ruta'])) {
                $query = sprintf("DELETE FROM imagenes WHERE id = %d", $id);
                return $conn->query($query);
            }
        }
        return false;
    }

    public static function obtenerPorVideojuegoId($videojuego_id)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        // Prepare the query to select all images associated with a specific video game ID
        $query = sprintf(
            "SELECT * FROM imagenes WHERE videojuego_id = %d",
            $conn->real_escape_string($videojuego_id)
        );

        $resultado = $conn->query($query);
        if ($resultado) {
            $imagenes = [];
            while ($fila = $resultado->fetch_assoc()) {
                $imagenes[] = new Imagen(
                    $fila['id'],
                    $fila['ruta'],
                    $fila['descripcion'],
                    $fila['videojuego_id'],
                    $fila['noticia_id'],
                    $fila['foro_id'],
                    $fila['sugerencia_juego_id']
                );
            }
            $resultado->free();
            return $imagenes; // Returns an array of Imagen objects
        } else {
            error_log("Error al obtener imágenes por videojuego_id ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    public static function obtenerPorNoticiaId($noticia_id)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        $query = sprintf(
            "SELECT * FROM imagenes WHERE noticia_id = %d",
            $conn->real_escape_string($noticia_id)
        );

        $resultado = $conn->query($query);
        if ($resultado) {
            $imagenes = [];
            while ($fila = $resultado->fetch_assoc()) {
                $imagenes[] = new Imagen(
                    $fila['id'],
                    $fila['ruta'],
                    $fila['descripcion'],
                    $fila['videojuego_id'],
                    $fila['noticia_id'],
                    $fila['foro_id'],
                    $fila['sugerencia_juego_id']
                );
            }
            $resultado->free();
            return $imagenes; // Returns an array of Imagen objects
        } else {
            error_log("Error al obtener imágenes por noticia_id ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

    public static function obtenerPorForoId($foro_id)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        $query = sprintf(
            "SELECT * FROM imagenes WHERE foro_id = %d",
            $conn->real_escape_string($foro_id)
        );

        $resultado = $conn->query($query);
        if ($resultado) {
            $imagenes = [];
            while ($fila = $resultado->fetch_assoc()) {
                $imagenes[] = new Imagen(
                    $fila['id'],
                    $fila['ruta'],
                    $fila['descripcion'],
                    $fila['videojuego_id'],
                    $fila['noticia_id'],
                    $fila['foro_id'],
                    $fila['sugerencia_juego_id']
                );
            }
            $resultado->free();
            return $imagenes; // Returns an array of Imagen objects
        } else {
            error_log("Error al obtener imágenes por foro_id ({$conn->errno}): {$conn->error}");
            return false;
        }
    }
    public static function obtenerPorSugerenciaJuegoId($sugerencia_juego_id)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        $query = sprintf(
            "SELECT * FROM imagenes WHERE sugerencia_juego_id = %d",
            $conn->real_escape_string($sugerencia_juego_id)
        );

        $resultado = $conn->query($query);
        if ($resultado) {
            $imagenes = [];
            while ($fila = $resultado->fetch_assoc()) {
                $imagenes[] = new Imagen(
                    $fila['id'],
                    $fila['ruta'],
                    $fila['descripcion'],
                    $fila['videojuego_id'],
                    $fila['noticia_id'],
                    $fila['foro_id'],
                    $fila['sugerencia_juego_id']
                );
            }
            $resultado->free();
            return $imagenes; // Returns an array of Imagen objects
        } else {
            error_log("Error al obtener imágenes por sugerencia_juego_id ({$conn->errno}): {$conn->error}");
            return false;
        }
    }
}
