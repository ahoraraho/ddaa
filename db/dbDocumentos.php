    <?php

    class dbDocumentos
    {
        public function selectDocumentos()
        {
            global $conexion;

            $consulta = "SELECT p.nombre_proyecto, d.*
                        FROM proyectos_documentos pd
                        JOIN proyectos p ON p.idProyecto = pd.idProyecto
                        JOIN documentos d ON d.idDocumento = pd.idDocumento
                        WHERE pd.idDocumento = d.idDocumento;";
            $resultado = mysqli_query($conexion, $consulta);

            $documentos = array();

            if ($resultado) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    $documentos[] = $fila;
                }
                mysqli_free_result($resultado);
            }

            return $documentos;
        }

        public function selectDocumento($idDocumento)
        {
            global $conexion;

            $consulta = "SELECT p.nombre_proyecto, d.idDocumento as idDoc, d.acta_de_recepcion, d.resolucion_de_obra, d.resolucion_deductivos, d.resolucion_adicionales, d.anexo_de_promesa_de_consorcio, d.constancia, d.contrato_de_consorcio, d.contrato
            FROM proyectos_documentos pd
            JOIN proyectos p ON p.idProyecto = pd.idProyecto
            JOIN documentos d ON d.idDocumento = pd.idDocumento 
            WHERE pd.idDocumento = ?";
            $stmt = mysqli_prepare($conexion, $consulta);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $idDocumento);
                mysqli_stmt_execute($stmt);
                $resultado = mysqli_stmt_get_result($stmt);

                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    return mysqli_fetch_assoc($resultado);
                }
            }

            return [];
        }

        // Insertar un nuevo documento y el registro correspondiente en proyectos_documentos
        public function insertDocumento($idDocumento, $idProyecto, $nombre_proyecto, $acta_de_recepcion, $resolucion_de_obra, $resolucion_deductivos, $resolucion_adicionales, $anexo_de_promesa_de_consorcio, $constancia, $contrato_de_consorcio, $contrato)
        {
            global $conexion;

            // Insertar el documento
            $consulta = "INSERT INTO documentos
                        (acta_de_recepcion, resolucion_de_obra, resolucion_deductivos, resolucion_adicionales, anexo_de_promesa_de_consorcio, constancia, contrato_de_consorcio, contrato)
                        VALUES ('$acta_de_recepcion', '$resolucion_de_obra', '$resolucion_deductivos', '$resolucion_adicionales', '$anexo_de_promesa_de_consorcio', '$constancia', '$contrato_de_consorcio', '$contrato')";
            mysqli_query($conexion, $consulta);

            // Insertar el registro en proyectos_documentos
            $consultaProyectosDocumentos = "INSERT INTO proyectos_documentos
                                            (idProyecto, idDocumento)
                                            VALUES ('$idProyecto', '$idDocumento')";
            mysqli_query($conexion, $consultaProyectosDocumentos);

            return mysqli_affected_rows($conexion);
        }

        // Actualizar un documento según su idDocumento
        public function updateDocumento($idDocumento, $idProyecto , $acta_de_recepcion, $resolucion_de_obra, $resolucion_deductivos, $resolucion_adicionales, $anexo_de_promesa_de_consorcio, $constancia, $contrato_de_consorcio, $contrato)
        {
            global $conexion;

            $consulta = "UPDATE documentos
                        SET acta_de_recepcion = '$acta_de_recepcion',
                            resolucion_de_obra = '$resolucion_de_obra',
                            resolucion_deductivos = '$resolucion_de_obra',
                            resolucion_adicionales = '$resolucion_deductivos',
                            anexo_de_promesa_de_consorcio = '$anexo_de_promesa_de_consorcio',
                            constancia = '$constancia',
                            contrato_de_consorcio = '$contrato_de_consorcio',
                            contrato = '$contrato'
                        WHERE idDocumento = '$idDocumento'";

            mysqli_query($conexion, $consulta);

            $consultaProyectosDocumentos = "UPDATE proyectos_documentos p
                        SET idProyecto = '$idProyecto',
                            idDocumento = '$idDocumento',
                        WHERE p.idDocumento = '$idDocumento'";
                        
            mysqli_query($conexion, $consultaProyectosDocumentos);

            return mysqli_affected_rows($conexion);
        }

    // Eliminar un documento según su idDocumento
    public function deleteDocumento($idDocumento,$idProyecto)
    {
        global $conexion;

        // Eliminar el registro de la tabla documentos
        $consulta = "DELETE FROM documentos WHERE idDocumento = '$idDocumento'";
        mysqli_query($conexion, $consulta);

        // Eliminar los registros correspondientes en la tabla proyectos_documentos
        $consultaProyectosDocumentos = "DELETE FROM proyectos_documentos WHERE idDocumento = ?";
        mysqli_query($conexion, $consultaProyectosDocumentos);

    }



        public function MayorDocumento()
        {
            global $conexion;

            $consulta = "SELECT MAX(idDocumento) as maxId FROM documentos";

            $resultado = mysqli_query($conexion, $consulta);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            } else {
                return [];
            }
        }
    }
    ?>