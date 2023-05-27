<?php
require_once '../config/Conexion.php';
class dbs
{
    private $conexion;

    public function __construct($host, $username, $password, $database)
    {
        $this->conexion = new Conexion($host, $username, $password, $database);
    }

    public function conectar()
    {
        $this->conexion->connect();
    }

    public function obtenerConexion()
    {
        return $this->conexion->getConnection();
    }

    // Resto del código de la clase DBS
}

$dbs = new dbs("localhost", "root", "", "ddd");
$dbs->conectar();
$conexion = $dbs->obtenerConexion();

?>