<?php

namespace App\Controllers;

use App\Models\User; // Modelo para gerenciar usuários
use App\Traits\AutenticacaoTrait;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController {
    use AutenticacaoTrait;

    public function __construct() {
        $this->verificarAutenticacao(); // Verifica se o usuário está autenticado
    }

    public function listarAlunos() {
        $userModel = new User();
        $alunos = $userModel->getAllAlunos(); // Método para buscar todos os alunos

        $data = [
            'title' => 'Listagem de Alunos',
            'headerTitle' => 'Alunos Cadastrados',
            'alunos' => $alunos // Passa os alunos para a view
        ];

        $this->render('listar_alunos', $data); // Renderiza a view de listagem de alunos
    }

    public function criarAluno() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $sobrenome = $_POST['sobrenome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $userModel = new User();

            if ($userModel->create($nome, $sobrenome, $email, 'aluno', $senha)) { // Método para criar um novo aluno
                $this->enviarEmailComSenha($nome, $sobrenome, $email, $senha);

                header('Location: /alunos'); // Redireciona para a listagem de alunos
                exit;
            } else {
                $data = [
                    'title' => 'Listagem de Alunos',
                    'headerTitle' => 'Alunos Cadastrados',
                    'error' => 'Erro ao criar o aluno.'
                ];
                $this->render('listar_alunos', $data);
            }
        }
    }

    private function enviarEmailComSenha($nome, $sobrenome, $email, $senha) {
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor de e-mail
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.seuservidordeemail.com'; 
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'seuemail@exemplo.com'; 
            $mail->Password   = 'suasenha'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
            $mail->Port       = 587; 

            $mail->setFrom('seuemail@exemplo.com', 'Nome da Aplicação');
            $mail->addAddress($email, "$nome $sobrenome");

            $mail->isHTML(true);
            $mail->Subject = 'Cadastro realizado com sucesso';
            $mail->Body    = "
                <h1>Bem-vindo, $nome!</h1>
                <p>Você foi cadastrado com sucesso em nosso sistema.</p>
                <p><strong>Sua senha é:</strong> $senha</p>
            ";

            $mail->send();
            echo 'E-mail enviado com sucesso';
        } catch (Exception $e) {
            echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        }
    }

    private function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../Views/' . $view . '.php';
    }
}