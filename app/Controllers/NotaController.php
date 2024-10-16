<?php

namespace App\Controllers;

use App\Models\Nota;
use App\Models\Materia; // Adicionei o modelo Materia para buscar matérias
use App\Models\User;
use App\Traits\AutenticacaoTrait;

class NotaController {
    use AutenticacaoTrait;

    public function __construct() {
        $this->verificarAutenticacao(); // Verifica se o usuário está autenticado
    }

    public function dashboard() {
        $usuarioId = $_SESSION['usuario_id'];
        $usuarioTipo = $_SESSION['usuario_tipo'];
        $nota = new Nota();
        $materiaModel = new Materia(); // Adicione a instância do modelo Materia
    
        if ($usuarioTipo === 'professor') {
            $notas = $nota->listarTodasAsNotas();
        } else {
            $notas = $nota->getMediaNotasPorAluno($usuarioId);
        }
        $materias = $materiaModel->listarTodasAsMaterias(); // Busque todas as matérias
    
        $data = [
            'title' => 'Dashboard de Notas',
            'headerTitle' => 'Visualização de Notas',
            'notas' => $notas,
            'materias' => $materias, // Passe as matérias para a view
            'usuario_id' => $usuarioId,
        ];
    
        $this->render('listar_notas', $data);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario_id = $_POST['usuario_id'];
            $materia_id = $_POST['materia_id'];
            $nota = $_POST['nota'];

            $notaModel = new Nota();
            if ($notaModel->create($usuario_id, $materia_id, $nota)) {
                header('Location: /notas'); 
                exit;
            } else {
                echo "Erro ao criar a nota.";
            }
        }
    }

    public function getNotasPorMateria($usuario_id, $materia) {
        $nota = new Nota();
        $notas = $nota->getNotasPorMateria($usuario_id, $materia);
        // Aqui verificamos se há notas e retornamos em JSON
        if ($notas) {
            echo json_encode($notas);
        } else {
            echo json_encode([]);
        }
    }

    private function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../Views/' . $view . '.php';
    }
}