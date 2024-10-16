<?php

namespace App\Controllers;

use App\Models\Materia; // Modelo para gerenciar matérias
use App\Traits\AutenticacaoTrait;

class MateriaController {
    use AutenticacaoTrait;

    public function __construct() {
        $this->verificarAutenticacao(); // Verifica se o usuário está autenticado
    }

    public function listarMaterias() {
        $materiaModel = new Materia();
        $materias = $materiaModel->listarTodasAsMaterias(); // Método para buscar todas as matérias

        $data = [
            'title' => 'Listagem de Matérias',
            'headerTitle' => 'Matérias Cadastradas',
            'materias' => $materias // Passa as matérias para a view
        ];

        $this->render('listar_materias', $data); // Renderiza a view de listagem de matérias
    }

    public function criarMateria() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $materiaModel = new Materia();

            if ($materiaModel->criarMateria($nome)) { // Método para criar uma nova matéria
                header('Location: /materias'); // Redireciona para a listagem de matérias
                exit;
            } else {
                $data = [
                    'title' => 'Listagem de Matérias',
                    'headerTitle' => 'Matérias Cadastradas',
                    'error' => 'Erro ao criar a matéria.'
                ];
                $this->render('listar_materias', $data);
            }
        }
    }

    private function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../Views/' . $view . '.php';
    }
}