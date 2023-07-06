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
        public function InsertProyecto($nombre_empresa, $nombre_proyecto, $numero_contrato, $entidad, $fecha_firma, $monto_contrato_original, $porcentaje_de_participacion, $adicionales_de_la_obra, $deductivos_de_obra, $monto_final_del_contrato, $miembro_del_consorcio, $observaciones, $contacto, $objeto, $especialidad){

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
