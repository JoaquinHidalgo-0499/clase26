<?php
require 'config.php';

class Usuario {
    private $id;
    private $username;
    private $email;

    public function __construct($id, $username, $email) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public static function registrarUsuario($username, $password, $email) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (username, password, email) VALUES (?, ?, ?)";
        $parametros = [$username, $hashedPassword, $email];

        try {
            ConexionDB::getInstancia()->ejecutarConsulta($sql, $parametros);
            return true; 
        } catch (Exception $e) {
            return false; 
        }
    }

    public static function autenticarUsuario($username, $password) {
        $sql = "SELECT id, username, password, email FROM usuarios WHERE username = ?";
        $parametros = [$username];

        try {
            $stmt = ConexionDB::getInstancia()->ejecutarConsulta($sql, $parametros);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($password, $usuario['password'])) {
                return new Usuario($usuario['id'], $usuario['username'], $usuario['email']);
            } else {
                return false; 
            }
        } catch (Exception $e) {
            return false; 
        }
    }
}


$resultado = Usuario::registrarUsuario('Gaston', '1234', 'gastongk@gmail.com');

if ($resultado === true) {
    echo "Usuario registrado exitosamente.";
} else {
    echo "Error al registrar el usuario.";
}
