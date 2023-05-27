<?php
class Empresa {
    private $nombre;
    private $ruc;
    private $telefono;
    private $numeroPartida;
    private $mipe;

    public function __construct($nombre, $ruc, $telefono, $numeroPartida, $mipe) {
        $this->nombre = $nombre;
        $this->ruc = $ruc;
        $this->telefono = $telefono;
        $this->numeroPartida = $numeroPartida;
        $this->mipe = $mipe;
    }

    // Métodos getter

    public function getNombre() {
        return $this->nombre;
    }

    public function getRuc() {
        return $this->ruc;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getNumeroPartida() {
        return $this->numeroPartida;
    }

    public function getMipe() {
        return $this->mipe;
    }

    // Métodos setter

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setRuc($ruc) {
        $this->ruc = $ruc;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setNumeroPartida($numeroPartida) {
        $this->numeroPartida = $numeroPartida;
    }

    public function setMipe($mipe) {
        $this->mipe = $mipe;
    }

    // Otros métodos de la clase...
}
?>
