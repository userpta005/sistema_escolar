-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS sistema_escolar;
USE sistema_escolar;

-- Tabela de Usuários (podem ser alunos ou professores)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    tipo ENUM('aluno', 'professor') NOT NULL,
    senha VARCHAR(255),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserindo registros na tabela de usuários
INSERT INTO usuarios (nome, sobrenome, email, tipo, senha) VALUES
('Admin', 'Root', 'admin@example.com', 'professor', 'senhaSegura'),
('Maria', 'Silva', 'maria@example.com', 'aluno', 'senhaMaria'),
('João', 'Pereira', 'joao@example.com', 'aluno', 'senhaJoao');

-- Tabela de Materias
CREATE TABLE IF NOT EXISTS materias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- Inserindo registros na tabela de materias
INSERT INTO materias (nome) VALUES
('Matemática'),
('História'),
('Ciências');

-- Tabela de Notas
CREATE TABLE IF NOT EXISTS notas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    materia_id INT,
    nota DECIMAL(5,2) NOT NULL,
    data_lancamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE
);

-- Inserindo registros na tabela de notas
INSERT INTO notas (usuario_id, materia_id, nota) VALUES
(2, 1, 8.5), -- Nota do aluno Maria em Matemática
(2, 2, 7.0), -- Nota do aluno Maria em História
(3, 1, 9.0), -- Nota do aluno João em Matemática
(3, 3, 8.0); -- Nota do aluno João em Ciências

-- Tabela de Reset de Senha (para link de e-mail)
CREATE TABLE IF NOT EXISTS reset_senha (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    token VARCHAR(255) NOT NULL,
    expiracao TIMESTAMP NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Inserindo registros na tabela de reset_senha
INSERT INTO reset_senha (usuario_id, token, expiracao) VALUES
(1, 'token_exemplo_1', DATE_ADD(NOW(), INTERVAL 1 HOUR)), -- Para o usuário admin
(2, 'token_exemplo_2', DATE_ADD(NOW(), INTERVAL 1 HOUR)), -- Para a Maria
(3, 'token_exemplo_3', DATE_ADD(NOW(), INTERVAL 1 HOUR)); -- Para o João

-- mysql -u usuario -p < database/script.sql