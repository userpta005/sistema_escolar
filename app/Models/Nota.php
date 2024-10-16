<?php

namespace App\Models;

use App\Config\Database;
use \PDO;

class Nota {
    private $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    // Cadastrar nova nota
    public function create($usuario_id, $materia_id, $nota) {
        $query = "INSERT INTO notas (usuario_id, materia_id, nota) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute([$usuario_id, $materia_id, $nota]);
    }

    // Listar notas de um aluno (inclui todas as notas por matéria)
    public function getNotasByAluno($usuario_id) {
        $query = "SELECT m.nome AS materia, n.nota, u.nome AS aluno, u.id AS usuario_id 
                  FROM notas n 
                  JOIN materias m ON n.materia_id = m.id 
                  JOIN usuarios u ON n.usuario_id = u.id 
                  WHERE n.usuario_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obter a média das notas por aluno e incluir o nome e usuario_id do aluno
    public function getMediaNotasPorAluno($usuario_id) {
        $query = "SELECT u.nome AS aluno, u.id AS usuario_id, m.nome AS materia, AVG(n.nota) AS media 
                  FROM notas n 
                  JOIN materias m ON n.materia_id = m.id 
                  JOIN usuarios u ON n.usuario_id = u.id 
                  WHERE n.usuario_id = ? 
                  GROUP BY u.nome,n.materia_id, u.id, m.nome";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar todas as notas (professor) e incluir o nome e usuario_id do aluno
    public function listarTodasAsNotas() {
        $query = "SELECT u.nome AS aluno, n.materia_id, u.id AS usuario_id, m.nome AS materia, AVG(n.nota) AS media 
                  FROM notas n 
                  JOIN usuarios u ON n.usuario_id = u.id 
                  JOIN materias m ON n.materia_id = m.id 
                  GROUP BY u.nome, u.id, n.materia_id, m.nome";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obter notas de um aluno por matéria
    public function getNotasPorMateria($usuario_id, $materia_id) {
        $query = "SELECT n.nota, u.nome AS aluno, u.id AS usuario_id 
                  FROM notas n 
                  JOIN materias m ON n.materia_id = m.id 
                  JOIN usuarios u ON n.usuario_id = u.id 
                  WHERE n.usuario_id = ? AND n.materia_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([$usuario_id, $materia_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}