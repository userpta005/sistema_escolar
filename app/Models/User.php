<?php

namespace App\Models;

use App\Config\Database;

class User {
    private $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public static function findByCredentials($email, $senha) {
        $stmt = $this->connection->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        return $stmt->fetch(); 
    }

    public function create($nome, $sobrenome, $email, $tipo, $senha = null) {
        $query = "INSERT INTO usuarios (nome, sobrenome, email, tipo, senha) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute([$nome, $sobrenome, $email, $tipo, $senha]);
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $query = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAllAlunos() {
        $query = "SELECT * FROM usuarios WHERE tipo = 'aluno'";
        $stmt = $this->connection->query($query);
        return $stmt->fetchAll();
    }

    public function updatePassword($id, $senha) {
        $query = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute([password_hash($senha, PASSWORD_BCRYPT), $id]);
    }
}