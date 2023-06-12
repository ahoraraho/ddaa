<?php

class dbProyectos
{
        // Insertar registro en la tabla proyectos
        public function insertarProyecto($proyecto)
        {
            global $conexion;
    
            $idProyecto = $proyecto['idProyecto'];
            $nombreEmpresa = $proyecto['nombre_empresa'];
            $nombreProyecto = $proyecto['nombre_proyecto'];
            $numeroContrato = $proyecto['numero_contrato'];
            $entidad = $proyecto['entidad'];
            $fechaFirma = $proyecto['fecha_firma'];
            $montoContratoOriginal = $proyecto['monto_contrato_original'];
            $porcentajeParticipacion = $proyecto['porcentaje_de_participacion'];
            $adicionalesObra = $proyecto['adicionales_de_la_obra'];
            $deductivosObra = $proyecto['deductivos_de_la_obra'];
            $montoFinalContrato = $proyecto['monto_final_del_contrato'];
            $miembroConsorcio = $proyecto['miembro_del_consorcio'];
            $observaciones = $proyecto['observaciones'];
            $contrato = $proyecto['contrato'];
            $objeto = $proyecto['objeto'];
            $especialidad = $proyecto['especialidad'];
    
            $consulta = "INSERT INTO proyectos (idProyecto, nombre_empresa, nombre_proyecto, numero_contrato, entidad, fecha_firma, monto_contrato_original, porcentaje_de_participacion, adicionales_de_la_obra, deductivos_de_obra, monto_final_del_contrato, miembro_del_consorcio, observaciones, contrato, objeto, especialidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conexion, $consulta);
    
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "issisddddssssssii", $idProyecto, $nombreEmpresa, $nombreProyecto, $numeroContrato, $entidad, $fechaFirma, $montoContratoOriginal, $porcentajeParticipacion, $adicionalesObra, $deductivosObra, $montoFinalContrato, $miembroConsorcio, $observaciones, $contrato, $objeto, $especialidad);
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
    
        // Obtener registros de la tabla proyectos
        public function obtenerProyectos()
        {
            global $conexion;
    
            $consulta = "SELECT * FROM proyectos";
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
    
        // Actualizar registro en la tabla proyectos
        public function updateProyecto($proyecto)
        {
            global $conexion;
    
            $idProyecto = $proyecto['idProyecto'];
            $nombreEmpresa = $proyecto['nombre_empresa'];
            $nombreProyecto = $proyecto['nombre_proyecto'];
            $numeroContrato = $proyecto['numero_contrato'];
            $entidad = $proyecto['entidad'];
            $fechaFirma = $proyecto['fecha_firma'];
            $montoContratoOriginal = $proyecto['monto_contrato_original'];
            $porcentajeParticipacion = $proyecto['porcentaje_de_participacion'];
            $adicionalesObra = $proyecto['adicionales_de_la_obra'];
            $deductivosObra = $proyecto['deductivos_de_obra'];
            $montoFinalContrato = $proyecto['monto_final_del_contrato'];
            $miembroConsorcio = $proyecto['miembro_del_consorcio'];
            $observaciones = $proyecto['observaciones'];
            $contrato = $proyecto['contrato'];
            $objeto = $proyecto['objeto'];
            $especialidad = $proyecto['especialidad'];
    
            $consulta = "UPDATE proyectos SET nombre_empresa=?, nombre_proyecto=?, numero_contrato=?, entidad=?, fecha_firma=?, monto_contrato_original=?, porcentaje_de_participacion=?, adicionales_de_la_obra=?, deductivos_de_obra=?, monto_final_del_contrato=?, miembro_del_consorcio=?, observaciones=?, contrato=?, objeto=?, especialidad=? WHERE idProyecto=?";
            $stmt = mysqli_prepare($conexion, $consulta);
    
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssssddddssssii", $nombreEmpresa, $nombreProyecto, $numeroContrato, $entidad, $fechaFirma, $montoContratoOriginal, $porcentajeParticipacion, $adicionalesObra, $deductivosObra, $montoFinalContrato, $miembroConsorcio, $observaciones, $contrato, $objeto, $especialidad, $idProyecto);
                mysqli_stmt_execute($stmt);
    
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    mysqli_stmt_close($stmt);
                    return true;
                }
            }
    
            return false;
        }
    
        // Eliminar registro en la tabla proyectos
        public function deleteProyecto($idProyecto)
        {
            global $conexion;
    
            $consulta = "DELETE FROM proyectos WHERE idProyecto = ?";
            $stmt = mysqli_prepare($conexion, $consulta);
    
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $idProyecto);
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