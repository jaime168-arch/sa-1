DROP DATABASE IF EXISTS `ja_ismaga`;
CREATE DATABASE `ja_ismaga` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ja_ismaga`;

SET FOREIGN_KEY_CHECKS = 0;

-- 1. TABELA DE TRENS
CREATE TABLE IF NOT EXISTS `trens` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `modelo` VARCHAR(100) NOT NULL,
  `capacidade` INT(11) NOT NULL DEFAULT 0,
  `status` ENUM('ativo', 'manutencao', 'inativo') NOT NULL DEFAULT 'ativo',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 2. TABELA DE ROTAS
CREATE TABLE IF NOT EXISTS `rotas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_rota` VARCHAR(100) NOT NULL,
  `origem` VARCHAR(100) NOT NULL,
  `destino` VARCHAR(100) NOT NULL,
  `distancia_km` DECIMAL(8,2) NOT NULL,
  `status_rota` ENUM('ativa', 'inativa', 'manutencao') NOT NULL DEFAULT 'ativa',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 3. TABELA DE USUÁRIOS (Atualizada com tipo e ativo)
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `tipo` VARCHAR(20) NOT NULL DEFAULT 'operador',
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,         
  `trem_id` INT(11) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_usuarios_trens`
    FOREIGN KEY (`trem_id`)
    REFERENCES `trens` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 4. TABELA DE SENSORES
CREATE TABLE IF NOT EXISTS `sensores` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `codigo_identificador` VARCHAR(50) NOT NULL UNIQUE,
  `tipo_dado` VARCHAR(50) NOT NULL,
  `trem_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_sensores_trens`
    FOREIGN KEY (`trem_id`)
    REFERENCES `trens` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 5. TABELA DE DADOS DOS SENSORES
CREATE TABLE IF NOT EXISTS `dados_sensores` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sensor_id` INT(11) NOT NULL,
  `valor` VARCHAR(50) NOT NULL,
  `data_horario` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `idx_sensor_data` (`sensor_id`, `data_horario`),
  CONSTRAINT `fk_dados_sensores`
    FOREIGN KEY (`sensor_id`)
    REFERENCES `sensores` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

-- INSERÇÕES DE DADOS INICIAIS DE TESTE

-- 1. Inserir Trens
INSERT INTO `trens` (`nome`, `modelo`, `capacidade`, `status`) VALUES
('Expressa Ferrorama', 'EF-2000', 350, 'ativo');

-- 2. Inserir Rotas
INSERT INTO `rotas` (`nome_rota`, `origem`, `destino`, `distancia_km`, `status_rota`) VALUES
('Linha Central', 'Estação Central', 'Terminal Norte', 45.50, 'ativa');

-- 3. Inserir Usuários (A senha para ambos é '123456')
INSERT INTO `usuarios` (`nome`, `email`, `senha`, `tipo`, `ativo`, `trem_id`) VALUES
('Administrador', 'admin@ismaga.com', '$2y$10$4B9a8fEshS6S3WcK6/b5E.wAmeQx8w7K0A3R2R5jU5s5bA5K6eE6u', 'admin', 1, NULL),
('Jailson', 'Jailsonaiprr@gmail.com', '$2y$10$4B9a8fEshS6S3WcK6/b5E.wAmeQx8w7K0A3R2R5jU5s5bA5K6eE6u', 'operador', 1, 1);