<?php

class dbEspecialistas{
     public function selectEspecialistas()
    {
        global $conexion;

        $consulta = "SELECT * FROM especialista";
        $resultado = mysqli_query($conexion, $consulta);

        $especialistas = array();
        if ($resultado) {
            while ($fila = mysqli_fetch_assoc($resultado)) {
                $especialistas[] = $fila;
            }
            mysqli_free_result($resultado);
        }

        return $especialistas;
    }
   
}

?>