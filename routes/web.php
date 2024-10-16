<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\MateriaController;
use App\Controllers\NotaController;

$router = new \Bramus\Router\Router();

// Rota para a página inicial
$router->get('/', function() {
    $controller = new AuthController();
    $controller->login();
});

// Rotas de autenticação
$router->get('/login', function() {
    $controller = new AuthController();
    $controller->login();
});

$router->post('/login', function() {
    $controller = new AuthController();
    $controller->login();
});

$router->get('/logout', function() {
    $controller = new AuthController();
    $controller->logout();
});

// Rotas de notas
$router->get('/notas', function() {
    $controller = new NotaController();
    $controller->dashboard();
});

$router->post('/notas/create', function() {
    $controller = new NotaController();
    $controller->create();
});

$router->get('/notas/getNotasPorMateria/{usuario_id}/{materia}', function($usuario_id, $materia) {
    $controller = new NotaController();
    $controller->getNotasPorMateria($usuario_id, $materia);
});

// Rotas de usuários
$router->get('/alunos', function() {
    $controller = new UserController();
    $controller->listarAlunos(); // Lista todos os usuários
});

$router->post('/alunos/criar', function() {
    $controller = new UserController();
    $controller->criarAluno(); // Cria um novo usuário
});

$router->get('/cadastro', function() {
    $controller = new AuthController();
    $controller->createUser(); // Cria um novo usuário
});

$router->post('/cadastro', function() {
    $controller = new AuthController();
    $controller->createUser(); // Cria um novo usuário
});

// Rotas de matérias
$router->get('/materias', function() {
    $controller = new MateriaController();
    $controller->listarMaterias(); // Lista todas as matérias
});

$router->post('/materias/criar', function() {
    $controller = new MateriaController();
    $controller->criarMateria(); // Cria uma nova matéria
});

$router->run();