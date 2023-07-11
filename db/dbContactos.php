<?php
class dbContactos
{

    // Insertar registro en la tabla contacto
    public function InsertarContacto($dni, $nombre, $email, $celular, $cargo)
    {
        global $conexion;

        $consulta = "INSERT INTO contacto 
                    (dni, nombre, email, celular, cargo) 
                    VALUES ('$dni','$nombre','$email','$celular','$cargo')";

        mysqli_query($conexion, $consulta);
        return mysqli_affected_rows($conexion);

    }

    // Obtener todos los contactos de la tabla contacto
    public function selectContactos()
    {
        global $conexion;

        $consulta = "SELECT * FROM contacto";
        $resultado = mysqli_query($conexion, $consulta);

        $contactos = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $contactos[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $contactos;
    }

    // Seleccionar un contacto por su ID de la tabla contacto
    public function selectContacto($id)
    {
        global $conexion;

        $consulta = "SELECT * FROM contacto WHERE idContacto = ?";
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

    // Actualizar un registro en la tabla contacto
    public function UpdateContacto($id, $dni, $nombre, $email, $celular, $cargo)
    {
        global $conexion;

        $consulta = "UPDATE contacto
                    SET dni= '$dni',
                    nombre= '$nombre',
                    email= '$email',
                    celular= '$celular',
                    cargo='$cargo'
                    WHERE idContacto = '$id'";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    // Eliminar un registro de la tabla contacto
    public function deleteContacto($id)
    {
        global $conexion;

        $consulta = "DELETE FROM contacto WHERE idContacto = $id";

        mysqli_query($conexion, $consulta);

        return mysqli_affected_rows($conexion);
    }

    public function MayorContacto()
    {
        global $conexion;

        $consulta = "SELECT MAX(idContacto) as maxId FROM contacto";

        $resultado = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($resultado) > 0) {
            return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function filtrarContacto($buscarCargo)
    {
        global $conexion;
        $filtro = "";

        if ($buscarCargo != '') {
            $filtro = "WHERE cargo = '" . $buscarCargo . "'";
        }

        $consulta = "SELECT * FROM contacto $filtro";

        $resultado = mysqli_query($conexion, $consulta);

        $contactos = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $contactos[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $contactos;
    }

    public function buscarContacto($buscar)
    {
        global $conexion;

        $consulta = "SELECT * FROM contacto
                    WHERE dni LIKE '%" . $buscar . "%'
                    OR nombre LIKE '%" . $buscar . "%'
                    OR email LIKE '%" . $buscar . "%'
                    OR celular LIKE '%" . $buscar . "%'
                    OR cargo LIKE '%" . $buscar . "%'";
        $resultado = mysqli_query($conexion, $consulta);

        $contactos = array();

        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $contactos[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $contactos;
    }
}
?>