<?php
class dbContactos
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Insertar registro en la tabla contacto
    public function insertarContacto($contacto)
    {
        $dni = $contacto['dni'];
        $nombre = $contacto['nombre'];
        $email = $contacto['email'];
        $celular = $contacto['celular'];
        $cargo = $contacto['cargo'];

        $consulta = "INSERT INTO contacto (dni, nombre, email, celular, cargo) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $dni, $nombre, $email, $celular, $cargo);
            if (mysqli_stmt_execute($stmt)) {
                $idInsertado = mysqli_insert_id($this->conexion);
                mysqli_stmt_close($stmt);
                return $idInsertado;
            } else {
                mysqli_stmt_close($stmt);
                return false;
            }
        }

        return false;
    }

    // Obtener todos los contactos de la tabla contacto
    public function obtenerContactos()
    {
        $consulta = "SELECT * FROM contacto";
        $resultado = mysqli_query($this->conexion, $consulta);

        $contactos = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $contactos[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $contactos;
    }

    // Seleccionar un contacto por su ID de la tabla contacto
    public function selectContacto($id)
    {
        $consulta = "SELECT * FROM contacto WHERE idContacto = ?";
        $stmt = mysqli_prepare($this->conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                return mysqli_fetch_assoc($resultado);
            }
        }

        return [];
    }

    // Actualizar un registro en la tabla contacto
    public function updateContacto($contacto)
    {
        $idContacto = $contacto['idContacto'];
        $dni = $contacto['dni'];
        $nombre = $contacto['nombre'];
        $email = $contacto['email'];
        $celular = $contacto['celular'];
        $cargo = $contacto['cargo'];

        $consulta = "UPDATE contacto SET dni=?, nombre=?, email=?, celular=?, cargo=? WHERE idContacto=?";
        $stmt = mysqli_prepare($this->conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssi", $dni, $nombre, $email, $celular, $cargo, $idContacto);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                mysqli_stmt_close($stmt);
                return true;
            }
        }

        return false;
    }

    // Eliminar un registro de la tabla contacto
    public function deleteContacto($idContacto)
    {
        $consulta = "DELETE FROM contacto WHERE idContacto = ?";
        $stmt = mysqli_prepare($this->conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $idContacto);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                mysqli_stmt_close($stmt);
                return true;
            }
            
            mysqli_stmt_close($stmt);
        }

        return false;
    }
}
?>
