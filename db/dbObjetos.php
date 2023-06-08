<?php
class dbObjeto
{
    // Insertar registro en la tabla objeto
    public function insertarObjeto($objeto)
    {
        global $conexion;

        $nombreObjeto = $objeto['nombre'];

        $consulta = "INSERT INTO objeto (nombre) VALUES (?)";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $nombreObjeto);
            if (mysqli_stmt_execute($stmt)) {
                $idInsertado = mysqli_insert_id($conexion);
                mysqli_stmt_close($stmt);
                return $idInsertado;
            } else {
                mysqli_stmt_close($stmt);
                return false;
            }
        }

        return false;
    }

    // Obtener todos los registros de la tabla objeto
    public function obtenerObjetos()
    {
        global $conexion;

        $consulta = "SELECT * FROM objeto";
        $resultado = mysqli_query($conexion, $consulta);

        $objetos = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $objetos[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $objetos;
    }

    // Seleccionar un registro de la tabla objeto por su idObjeto
    public function selectObjeto($id)
    {
        global $conexion;

        $consulta = "SELECT * FROM objeto WHERE idObjeto = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

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

    // Actualizar un registro en la tabla objeto
    public function updateObjeto($objeto)
    {
        global $conexion;

        $idObjeto = $objeto['idObjeto'];
        $nombreObjeto = $objeto['nombre'];

        $consulta = "UPDATE objeto SET nombre = ? WHERE idObjeto = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $nombreObjeto, $idObjeto);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                mysqli_stmt_close($stmt);
                return true;
            }
        }

        return false;
    }

    // Eliminar un registro de la tabla objeto por su idObjeto
    public function deleteObjeto($idObjeto)
    {
        global $conexion;

        $consulta = "DELETE FROM objeto WHERE idObjeto = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $idObjeto);
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