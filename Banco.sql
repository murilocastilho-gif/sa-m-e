DROP DATABASE IF EXISTS ferrorama;
CREATE DATABASE ferrorama CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ferrorama;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('Administrador', 'Usuario', 'Comprador') NOT NULL DEFAULT 'Usuario',
    status ENUM('Ativo', 'Inativo', 'Manutencao') NOT NULL DEFAULT 'Ativo',
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sensores (
    id_sensor INT AUTO_INCREMENT PRIMARY KEY,
    nome_sensor VARCHAR(100) NOT NULL,
    tipo_sensor ENUM('Presenca', 'Velocidade', 'Parada') NOT NULL,
    localizacao VARCHAR(100) NOT NULL,
    status ENUM('Ativo', 'Inativo', 'Manutencao') NOT NULL DEFAULT 'Ativo',
    data_instalacao DATE NOT NULL
);

CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nome_categoria VARCHAR(100) NOT NULL
);

CREATE TABLE produtos (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT NOT NULL,
    nome_produto VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_produtos_categorias FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria) ON DELETE CASCADE
);

INSERT INTO usuarios (nome, cpf, email, senha, perfil, status) VALUES
('Administrador do Sistema', '000.000.000-00', 'admin@ferrorama.com', '123456', 'Administrador', 'Ativo'),
('Murilo Guimarães', '011.873.039-84', 'murilo_castilho@estudante.sesisenai.org.br', '123456', 'Administrador', 'Ativo'),
('Joao Silva', '111.222.333-44', 'joao@email.com', '123456', 'Comprador', 'Ativo');

INSERT INTO sensores (nome_sensor, tipo_sensor, localizacao, status, data_instalacao) VALUES
('Sensor Pista A1', 'Presenca', 'Curva Norte', 'Ativo', '2026-01-15'),
('Sensor Velocidade V2', 'Velocidade', 'Reta Principal', 'Ativo', '2026-02-10');

INSERT INTO categorias (nome_categoria) VALUES
('Locomotivas'),
('Trilhos e Vias'),
('Vagoes');

INSERT INTO produtos (id_categoria, nome_produto, descricao, preco, estoque) VALUES
(1, 'Locomotiva Maria Fumaca', 'Modelo classico em escala', 350.00, 10),
(2, 'Kit Trilhos Curvos', 'Conjunto com 8 unidades', 85.50, 25);