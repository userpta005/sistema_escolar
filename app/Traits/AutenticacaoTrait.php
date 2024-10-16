<?php

namespace App\Traits;

trait AutenticacaoTrait
{
    public function verificarAutenticacao()
    {
        session_start();
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
    }
}