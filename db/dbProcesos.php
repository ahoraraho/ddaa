<?php
class dbProcesos
{
    // Insertar registro en la tabla procesos
    public function insertarProceso($entidad, $nomenclatura, $nombreClave, $consultas, $integracion, $presentacion, $buenaPro, $valorReferencial, $postores, $encargado, $objeto, $observaciones)
    {
        global $conexion;

        $consulta = "INSERT INTO procesos (entidad, nomenclatura, nombreClave, consultas, integracion, presentacion, buenaPro, valorReferencial, postores, encargado, objeto, observaciones) VALUES ('$entidad', '$nomenclatura', '$nombreClave', '$consultas', '$integracion', '$presentacion', '$buenaPro', '$valorReferencial', $postores, $encargado, $objeto, '$observaciones')";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    // Obtener registros de la tabla procesos
    public function selectProcesos()
    {
        global $conexion;

        $consulta = "SELECT *, e.nombreEmpresa AS nomPostor, o.nombre AS nomObjeto, es.nombre AS nomEncargado
        FROM procesos p
        INNER JOIN empresa e ON p.postores = e.idEmpresa
        INNER JOIN objeto o ON p.objeto = o.idObjeto
        INNER JOIN especialista es ON p.encargado = es.idEspecialista
        ORDER BY p.numProceso;";
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

    // Seleccionar registro de la tabla procesos
    public function selectProceso($numProceso)
    {
        global $conexion;

        $consulta = "SELECT * FROM procesos WHERE numProceso = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $numProceso);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                return mysqli_fetch_assoc($resultado);
            }
        }

        return [];
    }

    // Actualizar registro en la tabla procesos
    public function updateProceso($numProceso, $entidad, $nomenclatura, $nombreClave, $consultas, $integracion, $presentacion, $buenaPro, $valorReferencial, $postores, $encargado, $objeto, $observaciones)
    {
        global $conexion;

        $consulta = "UPDATE procesos
             SET entidad = '$entidad',
             nomenclatura='$nomenclatura',
             nombreClave='$nombreClave',
             consultas='$consultas',
             integracion='$integracion',
             presentacion='$presentacion',
             buenaPro='$buenaPro',
             valorReferencial='$valorReferencial',
             postores='$postores',
             encargado='$encargado',
             objeto='$objeto',
             observaciones='$observaciones'
             WHERE numProceso = $numProceso";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    // Eliminar registro en la tabla procesos
    public function deleteProceso($numProceso)
    {
        global $conexion;

        $consulta = "DELETE FROM procesos WHERE numProceso = $numProceso";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    public function MayorIdProceso()
    {
        global $conexion;

        $consulta = "SELECT MAX(numProceso) as maxId FROM procesos";

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function filtrarProceso($buscarPostores, $buscarEncargado, $buscarObjeto)
{
    global $conexion;

    $filtro = "";
    $parametros = array();

    if (!empty($buscarPostores)) {
        $filtro .= "p.postores = ?";
        $parametros[] = $buscarPostores;
    }

    if (!empty($buscarEncargado)) {
        if (!empty($filtro)) {
            $filtro .= " AND ";
        }
        $filtro .= "p.encargado = ?";
        $parametros[] = $buscarEncargado;
    }

    if (!empty($buscarObjeto)) {
        if (!empty($filtro)) {
            $filtro .= " AND ";
        }
        $filtro .= "p.objeto = ?";
        $parametros[] = $buscarObjeto;
    }

    $consulta = "SELECT *, e.nombreEmpresa AS nomPostor, o.nombre AS nomObjeto, es.nombre AS nomEncargado
    FROM procesos p
    INNER JOIN empresa e ON p.postores = e.idEmpresa
    INNER JOIN objeto o ON p.objeto = o.idObjeto
    INNER JOIN especialista es ON p.encargado = es.idEspecialista";

    if (!empty($filtro)) {
        $consulta .= " WHERE " . $filtro;
    }

    $consulta .= " ORDER BY p.numProceso";

    $stmt = mysqli_prepare($conexion, $consulta);

    if ($stmt) {
        if (!empty($parametros)) {
            $tiposParametros = str_repeat("s", count($parametros));
            mysqli_stmt_bind_param($stmt, $tiposParametros, ...$parametros);
        }

        mysqli_stmt_execute($stmt);

        $resultado = mysqli_stmt_get_result($stmt);
        $procesos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
    } else {
        $procesos = array();
    }

    return $procesos;
}


public function buscarProceso($buscar)
{
    global $conexion;

    $consulta = "SELECT *, e.nombreEmpresa AS nomPostor, o.nombre AS nomObjeto, es.nombre AS nomEncargado
    FROM procesos p
    INNER JOIN empresa e ON p.postores = e.idEmpresa
    INNER JOIN objeto o ON p.objeto = o.idObjeto
    INNER JOIN especialista es ON p.encargado = es.idEspecialista
    WHERE p.entidad LIKE '%" . $buscar . "%'
    OR p.nomenclatura LIKE '%" . $buscar . "%'
    OR o.nombre LIKE '%" . $buscar . "%'
    OR p.nombreClave LIKE '%" . $buscar . "%'
    OR p.consultas LIKE '%" . $buscar . "%'
    OR p.integracion LIKE '%" . $buscar . "%'
    OR p.presentacion LIKE '%" . $buscar . "%'
    OR p.buenaPro LIKE '%" . $buscar . "%'
    OR e.nombreEmpresa LIKE '%" . $buscar . "%'
    OR CAST(p.valorReferencial AS CHAR) LIKE '%" . $buscar . "%'
    OR es.nombre LIKE '%" . $buscar . "%'
    ORDER BY p.numProceso";

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

}
?>