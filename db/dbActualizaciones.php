<?php
class dbActualizaciones
{

    // Obtener registros de la tabla procesos
    public function selectNews($tipo)
    {
        global $conexion;

        $consulta = "SELECT A.*, T.nombre AS nombre_actualizacion
                        FROM actualizaciones A
                        INNER JOIN tipoActualizacion T ON A.tipo = T.idActual
                        WHERE T.nombre = '$tipo'";
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

    /* CRUD BASI */

    public function selectActualizaciones()
    {
        global $conexion;

        $consulta = "SELECT  * FROM actualizaciones";
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

    public function selectActulizacion($id)
    {
        global $conexion;

        $consulta = "SELECT A.*, T.nombre 
        FROM actualizaciones as A 
        INNER JOIN tipoactualizacion AS T ON A.tipo = T.idActual 
        WHERE A.idActualizacion = ?";

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

    public function InsertActualizacion($descripcion, $tipo, $nombreArchivo)
    {
        global $conexion;

        $consulta = "INSERT INTO actualizaciones (descripcion, tipo, archivo) VALUES ('$descripcion', '$tipo', '$nombreArchivo')";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    public function UpdateActualizacion($id, $descripcion, $tipo, $pdf)
    {
        global $conexion;

        $consulta = "UPDATE actualizaciones
                    SET descripcion = '$descripcion',
                    tipo = '$tipo',
                    archivo = '$pdf'
                    WHERE idActualizacion = $id";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }
    public function DeleteActualizacion($id)
    {
        global $conexion;

        $consulta = "DELETE FROM actualizaciones WHERE idActualizacion = $id";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    public function MayorIdActualizacion()
    {
        global $conexion;

        $consulta = "SELECT MAX(idActualizacion) as maxx FROM actualizaciones";

        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $fila = mysqli_fetch_assoc($resultado);
            return $fila['maxx'];
        } else {
            return 0;
        }
    }


    /*CODIGO PARA RESCATAR QUE TIPO DE ACTUALIZACION ES */
    public function selectTipos()
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

    public function filtrarActualizacion($buscarTipo)
    {
        global $conexion;
        $filtro = "";

        if ($buscarTipo != '') {
            $filtro = "WHERE tipo = '" . $buscarTipo . "'";
        }

        $consulta = "SELECT * FROM actualizaciones $filtro";

        $resultado = mysqli_query($conexion, $consulta);

        $actualizaciones = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $actualizaciones[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $actualizaciones;
    }

    public function buscarActualizacion($buscar)
    {
        global $conexion;

        $consulta = "SELECT actualizaciones.*, t.nombre AS tipoActu
        FROM actualizaciones
        INNER JOIN tipoactualizacion t ON actualizaciones.tipo = t.idActual
        
                    WHERE descripcion LIKE '%" . $buscar . "%'
                    OR archivo LIKE '%" . $buscar . "%'
                    OR t.nombre LIKE '%" . $buscar . "%'";

        $resultado = mysqli_query($conexion, $consulta);

        $actualizaciones = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $actualizaciones[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $actualizaciones;
    }
}
