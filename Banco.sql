DROP DATABASE IF EXISTS ferrorama;
CREATE DATABASE ferrorama CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ferrorama;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('Administrador', 'Usuario', 'Comprador') NOT NULL DEFAULT 'Usuario',
    status ENUM('Ativo', 'Inativo', 'Manutencao') NOT NULL DEFAULT 'Ativo',
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE trens (
    id_trem INT AUTO_INCREMENT PRIMARY KEY,
    nome_trem VARCHAR(100) NOT NULL,
    modelo VARCHAR(50) NOT NULL DEFAULT 'Padrão',
    velocidade_maxima INT NOT NULL DEFAULT 80,
    status VARCHAR(30) DEFAULT 'Operacional',
    id_usuario_responsavel INT NULL,
    FOREIGN KEY (id_usuario_responsavel) REFERENCES usuarios (id_usuario) ON DELETE SET NULL
);

CREATE TABLE rotas (
    id_rota INT AUTO_INCREMENT PRIMARY KEY,
    nome_rota VARCHAR(100) NOT NULL,
    origem VARCHAR(100) NOT NULL,
    destino VARCHAR(100) NOT NULL,
    distancia_km DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    tempo_estimado_min INT NOT NULL DEFAULT 0,
    id_trem INT NOT NULL,
    FOREIGN KEY (id_trem) REFERENCES trens (id_trem) ON DELETE RESTRICT
);

CREATE TABLE sensores (
    id_sensor INT AUTO_INCREMENT PRIMARY KEY,
    nome_sensor VARCHAR(100) NOT NULL,
    identificacao VARCHAR(50) NOT NULL DEFAULT 'SNS-001',
    tipo_sensor VARCHAR(50) NOT NULL DEFAULT 'Presença',
    localizacao VARCHAR(100) NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'Ativo',
    data_instalacao DATE DEFAULT CURRENT_DATE
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
    CONSTRAINT fk_produtos_categorias FOREIGN KEY (id_categoria) REFERENCES categorias (id_categoria) ON DELETE CASCADE
);

INSERT INTO usuarios (nome, cpf, email, senha, perfil, status) VALUES
('Murilo Guimarães', '321.654.987-00', 'murilo_castilho@estudante.sesisenai.org.br', '123456', 'Administrador', 'Ativo'),
('Enzo Gubulin', '123.456.789-00', 'enzo.gubulin@estudante.sesisenai.org.br', '654321', 'Administrador', 'Ativo'),
('Usuário Teste', '111.222.333-44', 'usuario@ferrorama.com', '123456', 'Usuario', 'Ativo');

INSERT INTO trens (nome_trem, modelo, velocidade_maxima, status, id_usuario_responsavel) VALUES
('Locomotiva T-100', 'GE U20C', 90, 'Operacional', 1),
('Expressa Z-200', 'EMD SD70', 110, 'Operacional', 2);

INSERT INTO rotas (nome_rota, origem, destino, distancia_km, tempo_estimado_min, id_trem) VALUES
('Linha Expressa Sul', 'Estação Central', 'Terminal Sul', 45.50, 40, 1);

INSERT INTO sensores (nome_sensor, identificacao, tipo_sensor, localizacao, status, data_instalacao) VALUES
('Sensor Pista A1', 'SNS-001-A', 'Presença', 'Curva Norte', 'Ativo', '2026-01-15'),
('Sensor Velocidade V2', 'SNS-002-B', 'Velocidade', 'Reta Principal', 'Ativo', '2026-02-10');

INSERT INTO categorias (nome_categoria) VALUES
('Locomotivas'),
('Trilhos e Vias'),
('Vagões');

INSERT INTO produtos (id_categoria, nome_produto, descricao, preco, estoque) VALUES
(1, 'Locomotiva Maria Fumaça', 'Modelo clássico em escala', 350.00, 10),
(2, 'Kit Trilhos Curvos', 'Conjunto com 8 unidades', 85.50, 25);