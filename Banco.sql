CREATE DATABASE IF NOT EXISTS `ferrorama` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ferrorama`;

DROP TABLE IF EXISTS `sensores`;
DROP TABLE IF EXISTS `rotas`;
DROP TABLE IF EXISTS `trens`;
DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id_usuario` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(100) NOT NULL,
  `cpf` VARCHAR(14) UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `perfil` ENUM('Administrador', 'Usuario') NOT NULL DEFAULT 'Usuario',
  `status` ENUM('Ativo', 'Inativo') NOT NULL DEFAULT 'Ativo',
  `data_cadastro` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `trens` (
  `id_trem` INT AUTO_INCREMENT PRIMARY KEY,
  `nome_trem` VARCHAR(100) NOT NULL,
  `modelo` VARCHAR(50),
  `status` ENUM('Em Operação', 'Em Manutenção', 'Inativo') NOT NULL DEFAULT 'Em Operação'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `rotas` (
  `id_rota` INT AUTO_INCREMENT PRIMARY KEY,
  `nome_rota` VARCHAR(100) NOT NULL,
  `origem` VARCHAR(100) NOT NULL,
  `destino` VARCHAR(100) NOT NULL,
  `descricao` TEXT,
  `distancia_km` DECIMAL(10,2) DEFAULT 0.00,
  `tempo_estimado_min` INT DEFAULT 0,
  `id_trem` INT DEFAULT NULL,
  CONSTRAINT `fk_rotas_trens` FOREIGN KEY (`id_trem`) REFERENCES `trens` (`id_trem`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `sensores` (
  `id_sensor` INT AUTO_INCREMENT PRIMARY KEY,
  `tipo` VARCHAR(50) NOT NULL,
  `localizacao` VARCHAR(100) NOT NULL,
  `status` ENUM('Ativo', 'Inativo', 'Em Manutenção') NOT NULL DEFAULT 'Ativo',
  `id_rota` INT DEFAULT NULL,
  CONSTRAINT `fk_sensores_rotas` FOREIGN KEY (`id_rota`) REFERENCES `rotas` (`id_rota`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `usuarios` (`nome`, `cpf`, `email`, `senha`, `perfil`, `status`) VALUES
('Administrador', '111.111.111-11', 'admin@ferrorama.com', '$2y$10$4Jyriz6RIAXwR97.gFDCg/1bEt1gtbdxvDfh6yi7kICL9kG', 'Administrador', 'Ativo'),
('Usuário Comum', '222.222.222-22', 'usuario@ferrorama.com', '$2y$10$4Jyriz6RIAXwR97.gFDCg/1bEt1gtbdxvDfh6yi7kICL9kG', 'Usuario', 'Ativo');

INSERT INTO `trens` (`nome_trem`, `modelo`, `status`) VALUES
('Locomotiva 01', 'ALCO FA-1', 'Em Operação'),
('Locomotiva 02', 'GE U20C', 'Em Manutenção');

INSERT INTO `rotas` (`nome_rota`, `origem`, `destino`, `descricao`, `distancia_km`, `tempo_estimado_min`, `id_trem`) VALUES
('Rota Expressa Norte', 'Estação Central', 'Terminal Norte', 'Linha principal de passageiros', 45.50, 60, 1),
('Rota Carga Sul', 'Pátio Industrial', 'Porto Sul', 'Linha dedicada ao transporte de carga', 120.00, 180, 2);

INSERT INTO `sensores` (`tipo`, `localizacao`, `status`, `id_rota`) VALUES
('Presença', 'Km 12 - Rota Norte', 'Ativo', 1),
('Velocidade', 'Km 45 - Rota Sul', 'Em Manutenção', 2);