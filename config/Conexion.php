<?php
class Conexion
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Error de conexión: " . $this->connection->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function close()
    {
        $this->connection->close();
    }
}

<<<<<<< HEAD
<<<<<<< HEAD

$dbConexion = new Conexion("localhost", "root", "", "da");
//$dbConexion = new Conexion("localhost", "root", "", "ddaa");
=======
$dbConexion = new Conexion("localhost", "root", "", "ddd");
>>>>>>> 2a51c7d7c32530b04fb37d68f9a6494dbb751e48
=======
$dbConexion = new Conexion("localhost", "root", "", "ddd");
>>>>>>> 1bb4ddf440e947ae5686cccc6630119516fd20d2

$dbConexion->connect();

$conexion = $dbConexion->getConnection();

?>
