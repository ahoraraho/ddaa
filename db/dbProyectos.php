<?php

class dbProyectos
{
        // Obtener registros de la tabla proyectos
        public function selectProyectos()
        {
            global $conexion;
    
            $consulta = "SELECT *, e.nombreEmpresa AS NomEmpresa FROM proyectos p INNER JOIN empresa e ON p.nombre_empresa = e.idEmpresa";
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
    
            $consulta = "SELECT p.* , d.* FROM proyectos p LEFT JOIN archivosproyectos d ON p.archivos = d.idArchivo WHERE idProyecto = ?";
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
        public function InsertProyecto($nombre_empresa, $nombre_proyecto, $numero_contrato, $entidad, $fecha_firma, $monto_contrato_original, $porcentaje_de_participacion, $adicionales_de_la_obra, $deductivos_de_obra, $monto_final_del_contrato, $miembro_del_consorcio, $observaciones, $contacto, $objeto, $especialidad, $archivos, $acta_de_recepcion, $resolucion_de_obra, $resolucion_deductivos, $resolucion_adicionales,$anexo_de_promesa_de_consorcio, $constancia, $contrato_de_consorcio, $contrato){

            global $conexion;

            $consulta = "INSERT INTO proyectos (nombre_empresa, nombre_proyecto, numero_contrato, entidad, fecha_firma, monto_contrato_original, porcentaje_de_participacion, adicionales_de_la_obra, deductivos_de_obra, monto_final_del_contrato, miembro_del_consorcio, observaciones, contacto, objeto, especialidad, archivos)
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
                        '$especialidad',
                        $archivos)";

            mysqli_query($conexion, $consulta);

            $consulta_docs = "INSERT INTO archivosproyectos (acta_de_recepcion, resolucion_de_obra, resolucion_deductivos, resolucion_adicionales,anexo_de_promesa_de_consorcio, constancia, contrato_de_consorcio, contrato)
            VALUES ('$acta_de_recepcion', '$resolucion_de_obra', '$resolucion_deductivos', '$resolucion_adicionales','$anexo_de_promesa_de_consorcio', '$constancia', '$contrato_de_consorcio', '$contrato')";

            mysqli_query($conexion, $consulta_docs);

            return mysqli_affected_rows($conexion);
        }

        
    
        // Actualizar registro en la tabla proyectos
        public function updateProyecto($idProyecto, $nombre_empresa, $nombre_proyecto, $numero_contrato, $entidad, $fecha_firma, $monto_contrato_original, $porcentaje_de_participacion, $adicionales_de_la_obra, $deductivos_de_obra, $monto_final_del_contrato, $miembro_del_consorcio, $observaciones, $contacto, $objeto, $especialidad, $archivos, $acta_de_recepcion, $resolucion_de_obra, $resolucion_deductivos, $resolucion_adicionales,$anexo_de_promesa_de_consorcio, $constancia, $contrato_de_consorcio, $contrato)
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
                    especialidad='$especialidad',
                    archivos = $archivos
                    WHERE idProyecto = $idProyecto";

            mysqli_query($conexion, $consulta);

            $consulta_docs="UPDATE archivosproyectos
                            SET 
                            acta_de_recepcion='$acta_de_recepcion',
                            resolucion_de_obra='$resolucion_de_obra',
                            resolucion_deductivos='$resolucion_deductivos',
                            resolucion_adicionales='$resolucion_adicionales',
                            anexo_de_promesa_de_consorcio='$anexo_de_promesa_de_consorcio',
                            constancia='$constancia',
                            contrato_de_consorcio='$contrato_de_consorcio',
                            contrato='$contrato'
                            WHERE
                            idArchivo = $archivos";

            mysqli_query($conexion, $consulta_docs);

            return mysqli_affected_rows($conexion);
        }
    
        // Eliminar registro en la tabla proyectos
        public function deleteProyecto($idProyecto,$archivos)
        {
            global $conexion;

            $consulta = "DELETE FROM proyectos WHERE idProyecto = $idProyecto";

            mysqli_query($conexion, $consulta);

            $consulta_docs="DELETE FROM archivosproyectos WHERE idArchivo = $archivos";

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
    }
?>