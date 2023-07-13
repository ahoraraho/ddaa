<?php
class dbObjeto
{

    // Obtener todos los registros de la tabla objeto
    public function selectObjetos()
    {
        global $conexion;

        $consulta = "SELECT * FROM objeto";
        $resultado = mysqli_query($conexion, $consulta);

        $objetos = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $objetos[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $objetos;
    }

    // Seleccionar un registro de la tabla objeto por su idObjeto
    public function selectObjeto($id)
    {
        global $conexion;

        $consulta = "SELECT * FROM objeto WHERE idObjeto = ?";
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


    /*__________________*/
    
    public function InsertObjeto($nombre)
    {
        global $conexion;

        $consulta = "INSERT INTO objeto (nombre) 
                    VALUES ('$nombre')";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);

        //$dbConexion->close();
    }

    /*****************************************************************************
     *                      ACTUALIZA UN OBJETO POR EL ID
     *****************************************************************************/
    public function UpdateObjeto($id, $nombre)
    {
        global  $conexion;

        $consulta = "UPDATE objeto
                SET nombre = '$nombre'
                WHERE idObjeto = $id";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);

        //$dbConexion->close();
    }

    /*****************************************************************************
     *                      ELIMINA UNA OBJETO POR EL ID
     *****************************************************************************/
    public function DeleteObjeto($id)
    {
        global $conexion;

        $consulta = "DELETE FROM objeto WHERE idObjeto = $id";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);

        //$dbConexion->close();
    }

    public function MayorIdObjeto()
    {
        global $conexion;

        $consulta = "SELECT MAX(idObjeto) as maxId FROM objeto";

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function buscarObjeto($buscar)
    {
        global $conexion;

        $consulta = "SELECT * FROM objeto
                    WHERE nombre LIKE '%" . $buscar . "%'";

        $resultado = mysqli_query($conexion, $consulta);

        $objetos = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $objetos[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $objetos;
    }
}
