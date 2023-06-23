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
    public function selectNoticia()
    {
        global $conexion;

        $consulta = "SELECT * FROM noticias WHERE destacado = 1";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            // mysqli_stmt_bind_param($stmt); // Mantener "i" para un entero
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                return mysqli_fetch_assoc($resultado);
            }
        }

        return [];
    }
}
