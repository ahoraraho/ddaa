<?php

class Administrador extends Usuarios
{
    private $rol;

    public function __construct($id, $idCliente, $nombre, $apellido, $dni, $telefono, $correo, $cargo, $direccion, $rol)
    {
        parent::__construct($id, $idCliente, $nombre, $apellido, $dni, $telefono, $correo, $cargo, $direccion);
        $this->rol = $rol;
    }

    public function getEspecialidad()
    {
        return $this->rol;
    }
}
?>