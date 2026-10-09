DROP DATABASE IF EXISTS `ja_ismaga`;
CREATE DATABASE `ja_ismaga` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ja_ismaga`;

SET FOREIGN_KEY_CHECKS = 0;


CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `tipo` ENUM('admin', 'operador', 'supervisor') NOT NULL DEFAULT 'operador',
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
  `origem` VARCHAR(100) NOT NULL,
  `destino` VARCHAR(100) NOT NULL,
  `distancia_km` DECIMAL(8,2) NOT NULL,
  `status_rota` ENUM('ativa', 'inativa', 'manutencao') NOT NULL DEFAULT 'ativa',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
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
(1, 'Administrador', 'admin@ismaga.com', '$2y$10$xG.x60mBf8.vWJshU7S28uX/5g3oE22bU6l.W.bK.D.Jj.D0vS/4a', 'admin', 1, 1, NULL),
(2, 'Ícaro', 'icaro@gmail.com', '$2y$10$xG.x60mBf8.vWJshU7S28uX/5g3oE22bU6l.W.bK.D.Jj.D0vS/4a', 'operador', 1, 0, NULL),
(3, 'Isabela', 'isabela@gmail.com', '$2y$10$xG.x60mBf8.vWJshU7S28uX/5g3oE22bU6l.W.bK.D.Jj.D0vS/4a', 'operador', 1, 0, NULL),
(4, 'Gabriela', 'gabriela@gmail.com', '$2y$10$xG.x60mBf8.vWJshU7S28uX/5g3oE22bU6l.W.bK.D.Jj.D0vS/4a', 'operador', 1, 0, NULL),
(5, 'Maria', 'maria@gmail.com', '$2y$10$xG.x60mBf8.vWJshU7S28uX/5g3oE22bU6l.W.bK.D.Jj.D0vS/4a', 'operador', 1, 0, NULL),
(6, 'Jaime', 'jaime@gmail.com', '$2y$10$xG.x60mBf8.vWJshU7S28uX/5g3oE22bU6l.W.bK.D.Jj.D0vS/4a', 'operador', 1, 0, NULL);

INSERT INTO `trens` (`id`, `nome`, `modelo`, `capacidade`, `status`, `usuario_id`) VALUES
(1, 'Expressa Ferrorama', 'EF-2000', 350, 'ativo', 2);


UPDATE `usuarios` SET `trem_id` = 1 WHERE `id` = 2;

INSERT INTO `rotas` (`nome_rota`, `origem`, `destino`, `distancia_km`, `status_rota`) VALUES
('Linha Central', 'Estação Central', 'Terminal Norte', 45.50, 'ativa');