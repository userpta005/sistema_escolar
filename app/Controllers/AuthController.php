<?php

namespace App\Controllers;

use App\Models\User;

class AuthController {
    public function login() {
        session_start();
    
        if (isset($_SESSION['usuario_id'])) {
            header('Location: /notas');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
    
            $userModel = new User();
            $user = $userModel->findByEmail($email);
    
            if ($user && $senha === $user['senha']) {
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_tipo'] = $user['tipo'];
    
                header('Location: /notas');
                exit;
            } else {
                $data = [
                    'title' => 'Página de Login',
                    'headerTitle' => 'Faça o Login',
                    'error' => 'Email ou senha incorretos!'
                ];
                $this->render('login', $data);
            }
        } else {
            $data = [
                'title' => 'Página de Login',
                'headerTitle' => 'Faça o Login'
            ];
            $this->render('login', $data);
        }
    }

    public function createUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $sobrenome = $_POST['sobrenome'];
            $email = $_POST['email'];
            $tipo = $_POST['tipo'];
            $senha = $_POST['senha'];
    
            $userModel = new User();
    
            // Verificar se o email já está cadastrado
            if ($userModel->findByEmail($email)) {
                $data = [
                    'title' => 'Cadastrar Usuário',
                    'headerTitle' => 'Cadastrar Usuário',
                    'error' => 'E-mail já cadastrado!'
                ];
                $this->render('cadastro_usuario', $data); // Redireciona de volta com erro
            } else {
                if ($userModel->create($nome, $sobrenome, $email, $tipo, $senha)) {
                    header('Location: /login'); // Redireciona para a lista de usuários
                    exit;
                } else {
                    $data = [
                        'title' => 'Cadastrar Usuário',
                        'headerTitle' => 'Cadastrar Usuário',
                        'error' => 'Erro ao cadastrar o usuário.'
                    ];
                    $this->render('cadastro_usuario', $data);
                }
            }
        } else {
            $data = [
                'title' => 'Cadastrar Usuário',
                'headerTitle' => 'Cadastrar Usuário'
            ];
            $this->render('cadastro_usuario', $data);
        }
    }

    public function logout() {
        session_start();
        session_destroy(); // Encerra a sessão
        header('Location: /login');
        exit;
    }

    private function render($view, $data = []) {
        extract($data); 

        require_once __DIR__ . '/../Views/' . $view . '.php';
    }
}