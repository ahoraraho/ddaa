<?php
class dbProdd
{

    /* CRUD BASICO*/
    public function selectProdds()
    {
        global $conexion;

        $consulta = "SELECT * FROM tipoactualizacion";
        $resultado = mysqli_query($conexion, $consulta);

        $procesos = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $procesos[] = $fila;
            }
            mysqli_free_result($resultado);
        }
        return $procesos;
    }

    public function selectProdd($id)
    {
        global $conexion;

        $consulta = "SELECT * FROM tipoactualizacion WHERE idActual = ?";
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

    public function InsertProdd($nombre)
    {
        global $conexion;

        $consulta = "INSERT INTO tipoactualizacion (nombre) VALUES ('$nombre')";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    public function UpdateProdd($id, $nombre)
    {
        global $conexion;

        $consulta = "UPDATE tipoactualizacion
                    SET nombre = '$nombre'
                    WHERE idActual = $id";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    public function DeleteProdd($id)
    {
        global $conexion;

        $consulta = "DELETE FROM tipoactualizacion WHERE idActual = $id";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    public function MayorIdProdd()
    {
        global $conexion;

        $consulta = "SELECT MAX(idActual) as maxx FROM tipoactualizacion";

        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $fila = mysqli_fetch_assoc($resultado);
            return $fila['maxx'];
        } else {
            return 0;
        }
    }
}
