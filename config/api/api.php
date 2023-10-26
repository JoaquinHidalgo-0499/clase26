<?php
class Api 
{
    private static $_instance;
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'clase26';
    private $conexion;

    public static function getConexion(){
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    private function __construct() {
        $this->conexion = mysqli_connect($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conexion) {
            echo "Conectado";
        }
    }
}