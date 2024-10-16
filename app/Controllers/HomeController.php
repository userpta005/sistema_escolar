<?php

namespace App\Controllers;

class HomeController {
    public function index() {
        $data = [
            'title' => 'Página Inicial',
            'headerTitle' => 'Bem-vindo à Página Inicial'
        ];

        $this->render('home', $data);
    }

    private function render($view, $data = []) {
        extract($data);

        require_once __DIR__ . '/../Views/templates/header.php';
        require_once __DIR__ . '/../Views/' . $view . '.php';
        require_once __DIR__ . '/../Views/templates/footer.php';
    }
}