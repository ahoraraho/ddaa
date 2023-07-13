<?php
class dbNoticias
{

    // Obtener registros de la tabla noticias
    public function selectNoticias()
    {
        global $conexion;

        $consulta = "SELECT * FROM noticias";
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

    // Seleccionar registro de la tabla noticias
    public function selectNoticia($idNoticia)
    {
        global $conexion;

        $consulta = "SELECT * FROM noticias WHERE idNoticia = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $idNoticia);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                return mysqli_fetch_assoc($resultado);
            }
        }

        return [];
    }

    public function insertNoticia($titulo, $descripcion, $fecha, $destacado, $imagen)
    {
        global $conexion;

        $consulta = "INSERT INTO noticias (titulo, descripcion, fecha, destacado, imagen)
                    VALUES ('$titulo', '$descripcion', '$fecha', '$destacado','$imagen')";

        mysqli_query($conexion, $consulta);
        return mysqli_affected_rows($conexion);
    }

    public function updateNoticia($idNoticia, $titulo, $descripcion, $fecha, $destacado,$imagen)
    {
        global $conexion;

        $consulta = "UPDATE noticias
                    SET 
                    titulo = '$titulo',
                    descripcion = '$descripcion',
                    fecha = '$fecha',
                    destacado = $destacado,
                    imagen = '$imagen'
                    WHERE idNoticia = $idNoticia";

        mysqli_query($conexion, $consulta);

        $consulta_destacado = "UPDATE noticias
                    SET
                    destacado = 0
                    WHERE idNoticia != $idNoticia";

        mysqli_query($conexion, $consulta_destacado);
        return mysqli_affected_rows($conexion);
    }

    public function deleteNoticia($idNoticia)
    {
        global $conexion;

        $consulta = "DELETE FROM noticias WHERE idNoticia = $idNoticia";
        mysqli_query($conexion, $consulta);
    }

    public function MayorIdNoticia()
    {
        global $conexion;

        $consulta = "SELECT MAX(idNoticia) as maxId FROM noticias";

            $resultado = mysqli_query($conexion, $consulta);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            } else {
                return [];
            }
    }

    public function buscarNoticia($buscar)
    {
        global $conexion;

        $consulta = "SELECT * FROM noticias
                    WHERE titulo LIKE '%" . $buscar . "%'
                    OR descripcion LIKE '%" . $buscar . "%'
                    OR fecha LIKE '%" . $buscar . "%'
                    OR destacado LIKE '%" . $buscar . "%'
                    OR imagen LIKE '%" . $buscar . "%'";

        $resultado = mysqli_query($conexion, $consulta);

        $noticias = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $noticias[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $noticias;
    }
}
