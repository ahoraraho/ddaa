<?php
// require_once 'Usuarios.php';

class Especialista extends Usuarios
{
    private $especialidad;

    public function __construct($id, $idCliente, $nombre, $apellido, $dni, $telefono, $correo, $cargo, $direccion, $especialidad)
    {
        parent::__construct($id, $idCliente, $nombre, $apellido, $dni, $telefono, $correo, $cargo, $direccion);
        $this->especialidad = $especialidad;
    }

    public function getEspecialidad()
    {
        return $this->especialidad;
    }
}

