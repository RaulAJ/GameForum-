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

    public function __construct($id, $ruta, $descripcion, $videojuego_id = null, $noticia_id = null, $foro_id = null)
    {
        $this->id = $id;
        $this->ruta = $ruta;
        $this->descripcion = $descripcion;
        $this->videojuego_id = $videojuego_id;
        $this->noticia_id = $noticia_id;
        $this->foro_id = $foro_id;
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

    public static function crea($file, $descripcion, $videojuego_id = null, $noticia_id = null, $foro_id = null)
    {
        $imagen = new Imagen(null, $file['name'], $descripcion, $videojuego_id, $noticia_id, $foro_id);
        return $imagen->guarda($file);
    }

    public function guarda($file)
    {
        error_log("imagen::guarda");
        if ($this->id === null) {
            error_log("imagen::subir");
            return self::subir($file, $this->videojuego_id, $this->noticia_id, $this->foro_id);
        } else {
            return self::actualiza($this->id, $this->ruta, $this->descripcion, $this->videojuego_id, $this->noticia_id, $this->foro_id);
        }
    }

    private static function actualiza($id, $ruta, $descripcion, $videojuego_id = null, $noticia_id = null, $foro_id = null)
    {
        $conn = BD::getInstance()->getConexionBd();
        if (!$conn) {
            return false;
        }

        // Prepare the query to update the image details in the database
        $query = sprintf(
            "UPDATE imagenes SET ruta='%s', descripcion='%s', videojuego_id=%s, noticia_id=%s, foro_id=%s WHERE id=%d",
            $conn->real_escape_string($ruta),
            $conn->real_escape_string($descripcion),
            $videojuego_id ? $conn->real_escape_string($videojuego_id) : 'NULL',
            $noticia_id ? $conn->real_escape_string($noticia_id) : 'NULL',
            $foro_id ? $conn->real_escape_string($foro_id) : 'NULL',
            $id
        );

        // Execute the query
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
    public static function subir($file, $videojuego_id = null, $noticia_id = null, $foro_id = null)
{
    $target_dir = RUTA_UPLOADS . '/';
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verify the image
    if (!self::verificarImagen($file, $target_file)) {
        return false;
    }

    // Try to move the image to the destination directory
    if (!move_uploaded_file($file["tmp_name"], $target_file)) {
        error_log("Failed to move file from {$file['tmp_name']} to {$target_file}");
        return false;
    }

    // Insert the image information into the database
    $conn = BD::getInstance()->getConexionBd();
    $query = sprintf(
        "INSERT INTO imagenes (ruta, descripcion, videojuego_id, noticia_id, foro_id) VALUES ('%s', '%s', %s, %s, %s)",
        $conn->real_escape_string($target_file),
        $conn->real_escape_string('Descripción de ejemplo'),
        $videojuego_id ? $conn->real_escape_string($videojuego_id) : 'NULL',
        $noticia_id ? $conn->real_escape_string($noticia_id) : 'NULL',
        $foro_id ? $conn->real_escape_string($foro_id) : 'NULL'
    );

    if ($conn->query($query)) {
        $newId = $conn->insert_id;
        $newFileName = $target_dir . $newId . '.' . $imageFileType;
        rename($target_file, $newFileName);

        // Update the database with the new file path
        $updateQuery = sprintf(
            "UPDATE imagenes SET ruta='%s' WHERE id=%d",
            $conn->real_escape_string('uploads/' . $newId . '.' . $imageFileType),
            $newId
        );
        $conn->query($updateQuery);
        return $newId;
    } else {
        error_log("Error saving the image in the BD: {$conn->error}");
        return false;
    }
}
    //TODO
    private static function verificarImagen($file, $target_file)
    {
        // Implementación de las verificaciones
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
                    $fila['foro_id']
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
                    $fila['foro_id']
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
                    $fila['foro_id']
                );
            }
            $resultado->free();
            return $imagenes; // Returns an array of Imagen objects
        } else {
            error_log("Error al obtener imágenes por foro_id ({$conn->errno}): {$conn->error}");
            return false;
        }
    }

}
