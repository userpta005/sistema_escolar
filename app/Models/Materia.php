<?php

// app/Models/Materia.php
namespace App\Models;

use \PDO;

use App\Config\Database;

class Materia {
    private $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    public function criarMateria($nome) {
        $query = "INSERT INTO materias (nome) VALUES (?)";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute([$nome]);
    }

    // Listar todas as matérias
    public function getAll() {
        $query = "SELECT * FROM materias";
        $stmt = $this->connection->query($query);
        return $stmt->fetchAll();
    }

    // Método para listar todas as matérias
    public function listarTodasAsMaterias() {
        $query = "SELECT id, nome FROM materias";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}