-- Limpeza e criação da base de dados com charset moderno (utf8mb4)
DROP DATABASE IF EXISTS `ja_ismaga`;
CREATE DATABASE `ja_ismaga` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ja_ismaga`;

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Tabela de Comboios / Trens
CREATE TABLE IF NOT EXISTS `trens` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `modelo` VARCHAR(100) NOT NULL,
  `capacidade` INT(11) NOT NULL DEFAULT 0,
  `status` ENUM('ativo', 'manutencao', 'inativo') NOT NULL DEFAULT 'ativo',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 2. Tabela de Rotas (Necessária para rota-form.js e rotas.js)
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

-- 3. Tabela de Utilizadores (Suporta hash de password seguro e chave estrangeira opcional)
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `trem_id` INT(11) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_usuarios_trens`
    FOREIGN KEY (`trem_id`)
    REFERENCES `trens` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 4. Tabela de Sensores IoT
CREATE TABLE IF NOT EXISTS `sensores` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `codigo_identificador` VARCHAR(50) NOT NULL UNIQUE,
  `tipo_dado` VARCHAR(50) NOT NULL, -- Ex: Temperatura, Velocidade, Vibração
  `trem_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_sensores_trens`
    FOREIGN KEY (`trem_id`)
    REFERENCES `trens` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 5. Tabela de Leituras dos Sensores
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

-- Carga Inicial de Dados de Teste

-- Utilizador Padrão (E-mail: admin@ismaga.com | Senha: 123456)
INSERT INTO `usuarios` (`nome`, `email`, `senha`) VALUES
('Administrador', 'admin@ismaga.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe112k/k6B18D/o2/a3jO0y9k2.4d9uCe');

-- Exemplo de Trem Inicial
INSERT INTO `trens` (`nome`, `modelo`, `capacidade`, `status`) VALUES
('Expressa Ferrorama', 'EF-2000', 350, 'ativo');

-- Exemplo de Rota Inicial
INSERT INTO `rotas` (`nome_rota`, `origem`, `destino`, `distancia_km`, `status_rota`) VALUES
('Linha Central', 'Estação Central', 'Terminal Norte', 45.50, 'ativa');