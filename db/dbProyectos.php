<?php

class dbProyectos
{
    // Obtener registros de la tabla proyectos
    public function selectProyectos()
    {
        global $conexion;

        $consulta = "SELECT *, e.nombreEmpresa AS NomEmpresa FROM proyectos AS p INNER JOIN empresa AS e ON p.nombre_empresa = e.idEmpresa";
        $resultado = mysqli_query($conexion, $consulta);

        $proyectos = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $proyectos[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $proyectos;
    }

    // Seleccionar registro de la tabla proyectos
    public function selectProyecto($idProyecto)
    {
        global $conexion;

        $consulta = "SELECT * FROM proyectos WHERE idProyecto = ?";
        $stmt = mysqli_prepare($conexion, $consulta);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $idProyecto);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                return mysqli_fetch_assoc($resultado);
            }
        }

        return [];
    }

    //insertar registros
    public function InsertProyecto($nombre_empresa, $nombre_proyecto, $numero_contrato, $entidad, $fecha_firma, $monto_contrato_original, $porcentaje_de_participacion, $adicionales_de_la_obra, $deductivos_de_obra, $monto_final_del_contrato, $miembro_del_consorcio, $observaciones, $contacto, $objeto, $especialidad)
    {

        global $conexion;

        $consulta = "INSERT INTO proyectos (nombre_empresa, nombre_proyecto, numero_contrato, entidad, fecha_firma, monto_contrato_original, porcentaje_de_participacion, adicionales_de_la_obra, deductivos_de_obra, monto_final_del_contrato, miembro_del_consorcio, observaciones, contacto, objeto, especialidad)
                        VALUES (  
                        '$nombre_empresa', 
                        '$nombre_proyecto', 
                        '$numero_contrato', 
                        '$entidad', 
                        '$fecha_firma', 
                        '$monto_contrato_original', 
                        '$porcentaje_de_participacion', 
                        '$adicionales_de_la_obra', 
                        '$deductivos_de_obra', 
                        '$monto_final_del_contrato', 
                        '$miembro_del_consorcio', 
                        '$observaciones', 
                        '$contacto', 
                        '$objeto', 
                        '$especialidad')";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }



    // Actualizar registro en la tabla proyectos
    public function updateProyecto($idProyecto, $nombre_empresa, $nombre_proyecto, $numero_contrato, $entidad, $fecha_firma, $monto_contrato_original, $porcentaje_de_participacion, $adicionales_de_la_obra, $deductivos_de_obra, $monto_final_del_contrato, $miembro_del_consorcio, $observaciones, $contacto, $objeto, $especialidad)
    {
        global $conexion;

        $consulta = "UPDATE proyectos
                    SET nombre_empresa='$nombre_empresa',
                    nombre_proyecto='$nombre_proyecto',
                    numero_contrato='$numero_contrato',
                    entidad='$entidad',
                    fecha_firma='$fecha_firma',
                    monto_contrato_original='$monto_contrato_original',
                    porcentaje_de_participacion='$porcentaje_de_participacion',
                    adicionales_de_la_obra='$adicionales_de_la_obra',
                    deductivos_de_obra='$deductivos_de_obra',
                    monto_final_del_contrato='$monto_final_del_contrato',
                    miembro_del_consorcio='$miembro_del_consorcio',
                    observaciones='$observaciones',
                    contacto='$contacto',
                    objeto='$objeto',
                    especialidad='$especialidad'
                    
                    WHERE idProyecto = $idProyecto";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    // Eliminar registro en la tabla proyectos
    public function deleteProyecto($idProyecto)
    {
        global $conexion;

        $consulta = "DELETE FROM proyectos WHERE idProyecto = $idProyecto";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    public function MayorIdProyecto()
    {
        global $conexion;

        $consulta = "SELECT MAX(idProyecto) as maxId FROM proyectos";

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function filtrarProyecto($buscarEmpresa, $buscarContacto, $buscarObjeto, $buscarEspecialidad)
{
    global $conexion;

    $filtro = "";
    $parametros = array();

    if (!empty($buscarEmpresa)) {
        $filtro .= "p.nombre_empresa = ?";
        $parametros[] = $buscarEmpresa;
    }

    if (!empty($buscarContacto)) {
        if (!empty($filtro)) {
            $filtro .= " AND ";
        }
        $filtro .= "p.contacto = ?";
        $parametros[] = $buscarContacto;
    }

    if (!empty($buscarObjeto)) {
        if (!empty($filtro)) {
            $filtro .= " AND ";
        }
        $filtro .= "p.objeto = ?";
        $parametros[] = $buscarObjeto;
    }

    if (!empty($buscarEspecialidad)) {
        if (!empty($filtro)) {
            $filtro .= " AND ";
        }
        $filtro .= "p.especialidad = ?";
        $parametros[] = $buscarEspecialidad;
    }

    $consulta = "SELECT *, e.nombreEmpresa AS NomEmpresa FROM proyectos p INNER JOIN empresa e ON p.nombre_empresa = e.idEmpresa";

    if (!empty($filtro)) {
        $consulta .= " WHERE " . $filtro;
    }

    $stmt = mysqli_prepare($conexion, $consulta);

    if ($stmt) {
        if (!empty($parametros)) {
            $tiposParametros = str_repeat("s", count($parametros));
            mysqli_stmt_bind_param($stmt, $tiposParametros, ...$parametros);
        }

        mysqli_stmt_execute($stmt);

        $resultado = mysqli_stmt_get_result($stmt);
        $proyectos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
    } else {
        $proyectos = array();
    }

    return $proyectos;
}


    public function buscarProyecto($buscar)
{
    global $conexion;

    $consulta = "SELECT p.*, e.nombreEmpresa AS NomEmpresa, c.nombre AS NomContacto, o.nombre AS NomObjeto, es.nombre AS NomEspecialidad
                FROM proyectos AS p
                INNER JOIN empresa AS e ON p.nombre_empresa = e.idEmpresa
                INNER JOIN contacto AS c ON p.contacto = c.idContacto
                INNER JOIN objeto AS o ON p.objeto = o.idObjeto
                INNER JOIN especialidad AS es ON p.especialidad = es.idEspecialidad
                WHERE e.nombreEmpresa LIKE '%" . $buscar . "%' 
                OR p.nombre_proyecto LIKE '%" . $buscar . "%'
                OR p.numero_contrato LIKE '%" . $buscar . "%'
                OR p.entidad LIKE '%" . $buscar . "%'
                OR p.fecha_firma LIKE '%" . $buscar . "%'
                OR CAST(p.monto_contrato_original AS CHAR) LIKE '%" . $buscar . "%'
                OR CAST(p.porcentaje_de_participacion AS CHAR) LIKE '%" . $buscar . "%'
                OR CAST(p.adicionales_de_la_obra AS CHAR) LIKE '%" . $buscar . "%'
                OR CAST(p.deductivos_de_obra AS CHAR) LIKE '%" . $buscar . "%'
                OR CAST(p.monto_final_del_contrato AS CHAR) LIKE '%" . $buscar . "%'
                OR p.miembro_del_consorcio LIKE '%" . $buscar . "%'
                OR p.observaciones LIKE '%" . $buscar . "%'
                OR c.nombre LIKE '%" . $buscar . "%'
                OR o.nombre LIKE '%" . $buscar . "%'
                OR es.nombre LIKE '%" . $buscar . "%'";

    $resultado = mysqli_query($conexion, $consulta);

    $proyectos = array();

    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $proyectos[] = $fila;
        }
        mysqli_free_result($resultado);
    }

    return $proyectos;
}



    public function MayorIdDocProyecto()
    {
        global $conexion;

        $consulta = "SELECT MAX(idArchivo) as maxId FROM archivosproyectos";

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
    /*OPTINE EL ULTIMO ID DE LA ULTIMA INSERCION A LA BASE DE DATOS */
    public function getUltimoRegistroId()
    {
        global $conexion;

        $query = "SELECT LAST_INSERT_ID()";
        $result = mysqli_query($conexion, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_row($result);
            return $row[0];
        } else {
            return false;
        }
    }


    /*------------------------------------------- */
    /**CODIGO PARA EL CRUD DE LO ARCHIVOS DE EMPRESA */
    /*------------------------------------------- */

    public function selectArchivosProyecto($id)
    {
        global $conexion;

        $consulta = "SELECT * FROM archivosProyectos WHERE idProyecto = ?";

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

    public function InsertArchivosProyecto($id, $acta_de_recepcion, $resolucion_de_obra, $resolucion_deductivos, $resolucion_adicionales, $anexo_de_promesa_de_consorcio, $constancia, $contrato_de_consorcio, $contrato)
    {
        global $conexion;

        $consulta = "INSERT INTO archivosProyectos(idProyecto, acta_de_recepcion, resolucion_de_obra, resolucion_deductivos, resolucion_adicionales, anexo_de_promesa_de_consorcio, constancia, contrato_de_consorcio, contrato)
                    VALUES ($id, '$acta_de_recepcion', '$resolucion_de_obra', '$resolucion_deductivos', '$resolucion_adicionales', '$anexo_de_promesa_de_consorcio', '$constancia' , '$contrato_de_consorcio', '$contrato');";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    // Actualizar registro en la tabla empresa
    public function UpdateArchivosProyecto($id, $identificador, $archivo)
    {
        global $conexion;

        $consulta = "UPDATE archivosProyectos
                    SET $identificador = '$archivo'
                    WHERE idProyecto = $id;";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    // Eliminar registro en la tabla empresa
    public function DeleteArchivosProyecto($id)
    {
        global $conexion;

        $consulta = "DELETE FROM archivosProyectos WHERE idProyecto = $id";
        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }
}