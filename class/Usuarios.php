<?php

class Usuarios
{
    protected $id;
    protected $idCliente;
    protected $nombre;
    protected $apellido;
    protected $dni;
    protected $telefono;
    protected $correo;
    protected $cargo;
    protected $direccion;

    public function __construct($id, $idCliente, $nombre, $apellido, $dni, $telefono, $correo, $cargo, $direccion)
    {
        $this->id = $id;
        $this->idCliente = $idCliente;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->telefono = $telefono;
        $this->correo = $correo;
        $this->cargo = $cargo;
        $this->direccion = $direccion;
    }

    // Métodos getter

    public function getId()
    {
        return $this->id;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getCargo()
    {
        return $this->cargo;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    // Métodos setter
/*
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    // Otros métodos...
*/
}
?>