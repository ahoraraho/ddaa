<?php
class dbEmpresa
{
    public function selectEmpresas()
    {
        global $conexion;

        $consulta = "SELECT * FROM empresa";
        $resultado = mysqli_query($conexion, $consulta);

        $empresas = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $empresas[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $empresas;
    }


    // Seleccionar un registro de la tabla empresa por su idEmpresa
    public function selectEmpresa($id)
    {
        global $conexion;

        $consulta = "SELECT * FROM empresa WHERE idEmpresa = ?";

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

    //insertar
    public function InsertEmpresa($nombre, $ruc, $telefono, $email, $num_partida, $mipe)
    {
        global $conexion;

        $consulta = "INSERT INTO empresa (nombreEmpresa,ruc,telefono,email,numeroPartida,mipe) 
                    VALUES ('$nombre','$ruc','$telefono','$email','$num_partida','$mipe')";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    // Actualizar registro en la tabla empresa
    public function UpdateEmpresa($id, $nombre, $ruc, $telefono, $email, $num_partida, $mipe)
    {
        global $conexion;

        $consulta = "UPDATE empresa
                    SET nombreEmpresa = '$nombre',
                    ruc = '$ruc',
                    telefono = '$telefono',
                    email = '$email',
                    numeroPartida = '$num_partida',
                    mipe = '$mipe'
                    WHERE idEmpresa = $id";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    // Eliminar registro en la tabla empresa
    public function DeleteEmpresa($id)
    {
        global $conexion;

        $consulta = "DELETE FROM empresa WHERE idEmpresa = $id";
        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    public function MayorIdEmpresa()
    {
        global $conexion;

        $consulta = "SELECT MAX(idEmpresa) as maxId FROM empresa";

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function filtrarEmpresa($buscarMipe)
    {
        global $conexion;
        $filtro = "";

        if ($buscarMipe != '') {
            $filtro = "WHERE mipe = '" . $buscarMipe . "'";
        }

        $consulta = "SELECT * FROM empresa $filtro";

        $resultado = mysqli_query($conexion, $consulta);

        $empresas = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $empresas[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $empresas;
    }

    public function buscarEmpresa($buscar)
    {
        global $conexion;

        $consulta = "SELECT * FROM empresa
                    WHERE nombreEmpresa LIKE '%" . $buscar . "%'
                    OR ruc LIKE '%" . $buscar . "%'
                    OR telefono LIKE '%" . $buscar . "%'
                    OR email LIKE '%" . $buscar . "%'
                    OR numeroPartida LIKE '%" . $buscar . "%'";

        $resultado = mysqli_query($conexion, $consulta);

        $empresas = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $empresas[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $empresas;
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

    public function selectArchivosEmpresa($id)
    {
        global $conexion;

        $consulta = "SELECT * FROM archivosEmpresa WHERE idEmpresa = ?";

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

    public function InsertArchivosEmpresa($id, $ficha_ruc, $constancia_RNP, $constancia_mipe, $certificado_discapacitados, $planilla_discapasitados, $carnet_conadis)
    {
        global $conexion;

        $consulta = "INSERT INTO archivosEmpresa (idEmpresa, ficha_ruc, constancia_RNP, constancia_mipe, certificado_discapacitados, planilla_discapasitados, carnet_conadis)
                    VALUES ($id, '$ficha_ruc', '$constancia_RNP', '$constancia_mipe', '$certificado_discapacitados', '$planilla_discapasitados', '$carnet_conadis');";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    // Actualizar registro en la tabla empresa
    public function UpdateArchivosEmpresa($id, $identificador, $archivo)
    {
        global $conexion;

        $consulta = "UPDATE archivosEmpresa
                    SET $identificador = '$archivo'
                    WHERE idEmpresa = $id;";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    // Eliminar registro en la tabla empresa
    public function DeleteArchivosEmpresa($id)
    {
        global $conexion;

        $consulta = "DELETE FROM archivosEmpresa WHERE idEmpresa = $id";
        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }
}