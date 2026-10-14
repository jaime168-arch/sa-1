DROP DATABASE IF EXISTS `ja_ismaga`;
CREATE DATABASE `ja_ismaga` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ja_ismaga`;

SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `tipo` ENUM('admin', 'operador', 'usuario comum') NOT NULL DEFAULT 'operador',
  `ativo` TINYINT(1) NOT NULL DEFAULT 1,
  `protegido` TINYINT(1) DEFAULT 0,
  `trem_id` INT(11) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS `trens` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `modelo` VARCHAR(100) NOT NULL,
  `capacidade` INT(11) NOT NULL DEFAULT 0,
  `status` ENUM('ativo', 'manutencao', 'inativo') NOT NULL DEFAULT 'ativo',
  `usuario_id` INT(11) NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_trens_usuarios`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuarios` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_trens`
  FOREIGN KEY (`trem_id`)
  REFERENCES `trens` (`id`)
  ON DELETE SET NULL
  ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `rotas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_rota` VARCHAR(100) NOT NULL,
  `descricao` TEXT NULL,
  `origem` VARCHAR(100) NOT NULL,
  `destino` VARCHAR(100) NOT NULL,
  `distancia_km` DECIMAL(8,2) NOT NULL,
  `tempo_previsto` VARCHAR(50) NOT NULL,
  `trem_id` INT(11) NULL,
  `status_rota` ENUM('ativa', 'inativa', 'manutencao') NOT NULL DEFAULT 'ativa',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_rotas_trens`
    FOREIGN KEY (`trem_id`)
    REFERENCES `trens` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

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

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`, `ativo`, `protegido`, `trem_id`) VALUES
(1, 'Administrador', 'admin@ismaga.com', '123456', 'admin', 1, 1, NULL),
(2, 'Ícaro', 'icaro@gmail.com', '123456', 'operador', 1, 0, NULL),
(3, 'Isabela', 'isabela@gmail.com', '123456', 'operador', 1, 0, NULL),
(4, 'Gabriela', 'gabriela@gmail.com', '123456', 'operador', 1, 0, NULL),
(5, 'Maria', 'maria@gmail.com', '123456', 'operador', 1, 0, NULL),
(6, 'Jaime', 'jaime@gmail.com', '123456', 'operador', 1, 0, NULL),
(7, 'Lucas', 'lucas@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(8, 'Amanda', 'amanda@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(9, 'Asafe', 'asafe@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(10, 'Backhause', 'backhause@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(11, 'Batistela', 'batistela@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(12, 'Bruno', 'bruno@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(13, 'Caio', 'caio@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(14, 'Daniel', 'daniel@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(15, 'Edson', 'edson@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(16, 'Felipe', 'felipe@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(17, 'Fernanda', 'fernanda@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(18, 'Gabriel', 'gabriel@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(19, 'Higor', 'higor@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(20, 'Ignacio', 'ignacio@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(21, 'Jakeline', 'jakeline@gmail.com', '123456', 'operador', 1, 0, NULL),
(22, 'Jefferson', 'jefferson@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(23, 'Juliana', 'juliana@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(24, 'Lara', 'lara@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(25, 'Leila', 'leila@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(26, 'Liana', 'liana@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(27, 'Lombardi', 'lombardi@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(28, 'Luis', 'luis@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(29, 'Luiza', 'luiza@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(30, 'Marcos', 'Marcos@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(31, 'Mateus', 'mateus@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(32, 'Mel', 'mel@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(33, 'Miguel', 'miguel@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(34, 'Murilo', 'murilo@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(35, 'Rafael', 'rafael@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(36, 'Samuel', 'samuel@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(37, 'Tomczak', 'tomczak@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(38, 'Venso', 'venso@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(39, 'Vinicius', 'vinicius@gmail.com', '123456', 'usuario comum', 1, 0, NULL),
(40, 'Zilz', 'zilz@gmail.com', '123456', 'usuario comum', 1, 0, NULL);








INSERT INTO `trens` (`id`, `nome`, `modelo`, `capacidade`, `status`, `usuario_id`) VALUES
(1, 'Expressa Ferrorama', 'EF-2000', 350, 'ativo', 2),
(2, 'Trem do 67', 'TEE-670', 67, 'em manutenção', 5),
(3, 'Expresso polar', 'TT-2500', 222, 'inativo', 3);


UPDATE `usuarios` SET `trem_id` = 1 WHERE `id` = 2;

INSERT INTO `rotas` (`nome_rota`, `descricao`, `origem`, `destino`, `distancia_km`, `tempo_previsto`, `trem_id`, `status_rota`) VALUES
('Linha Central', 'Rota principal para transporte urbano de passageiros.', 'Estação Central', 'Terminal Norte', 45.50, '01h 15m', 1, 'ativa'),
('Linha do morro', 'Rota principal para o lado mais humilde da cidade', 'Estação Central', 'Terminal do morro', 67.00, '01h ', 2, 'em manutenção'),
('Linha do luxo', 'Rota principal para o lado mais luxuoso da cidade', 'Estação Central', 'Terminal do luxo', 16.08, '50min ', 3, 'inativa');