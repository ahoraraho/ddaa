<?php
class dbEspecialidades
{
    /* Insertar registro en la tabla especialidad
    public function insertarEspecialidad($especialidad)
    {
        global $conexion;

        $nombre = $especialidad['nombre'];

        $consulta = "INSERT INTO especialidad (nombre) VALUES (?)";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $nombre);
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
    }*/

    // Obtener todos los registros de la tabla especialidad
    public function selectEspecialidades()
    {
        global $conexion;

        $consulta = "SELECT * FROM especialidad";
        $resultado = mysqli_query($conexion, $consulta);

        $especialidades = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $especialidades[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $especialidades;
    }

    // Seleccionar un registro de la tabla especialidad
    public function selectEspecialidad($id)
    {
        global $conexion;

        $consulta = "SELECT * FROM especialidad WHERE idEspecialidad = ?";
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

    public function InsertEspecialidad($nombre)
    {
        global $conexion;

        $consulta = "INSERT INTO especialidad (nombre)
                    VALUES ('$nombre')";
        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    // Actualizar registro en la tabla especialidad
    public function updateEspecialidad($id, $nombre)
    {
        global $conexion;

        $consulta = "UPDATE especialidad 
                    SET nombre = '$nombre' 
                    WHERE idEspecialidad = $id";
        $stmt = mysqli_prepare($conexion, $consulta);

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);

    }


    // Eliminar registro en la tabla especialidad
    public function deleteEspecialidad($id)
    {
        global $conexion;

        $consulta = "DELETE FROM especialidad WHERE idEspecialidad = $id";
        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    public function MayorIdEspecialidad(){
        global $conexion;
        $consulta = "SELECT MAX(idEspecialidad) as maxId from especialidad";
        $resultado = mysqli_query($conexion, $consulta);
        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function buscarEspecialidad($buscar)
    {
        global $conexion;

        $consulta = "SELECT * FROM especialidad
                    WHERE nombre LIKE '%" . $buscar . "%'";

        $resultado = mysqli_query($conexion, $consulta);

        $especialidades = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $especialidades[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $especialidades;
    }
}
?>
