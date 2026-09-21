-- Remove o banco antigo se existir e cria o banco correto
DROP DATABASE IF EXISTS `ja_ismaga`;
CREATE DATABASE `ja_ismaga` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ja_ismaga`;

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Tabela de Trens
CREATE TABLE IF NOT EXISTS `trens` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `linha` VARCHAR(100) NOT NULL,
  `placa` VARCHAR(45) NOT NULL,
  `status` ENUM('ativo', 'manutencao', 'inativo') NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 2. Tabela de Usuários (Integrada com o seu login.php e autenticar.php)
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL, -- Suporta hash do password_hash()
  `trem_id` INT(11) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_usuarios_trens`
    FOREIGN KEY (`trem_id`)
    REFERENCES `trens` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 3. Tabela de Sensores IoT
CREATE TABLE IF NOT EXISTS `sensores` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `codigo_identificador` VARCHAR(45) NOT NULL,
  `tipo_dado` VARCHAR(50) NOT NULL, -- Ex: Temperatura, Velocidade, Vibração
  `trem_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_sensores_trens`
    FOREIGN KEY (`trem_id`)
    REFERENCES `trens` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 4. Tabela de Relatórios
CREATE TABLE IF NOT EXISTS `relatorios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(150) NOT NULL,
  `tipo_de_falha` VARCHAR(100) NOT NULL,
  `data_inicio` DATE NOT NULL,
  `data_fim` DATE NOT NULL,
  `data_criacao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_relatorios_usuarios`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuarios` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- 5. Tabela de Dados Coletados pelos Sensores
CREATE TABLE IF NOT EXISTS `dados_sensores` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sensor_id` INT(11) NOT NULL,
  `valor` VARCHAR(100) NOT NULL,
  `data_horario` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `relatorio_id` INT(11) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_dados_sensores`
    FOREIGN KEY (`sensor_id`)
    REFERENCES `sensores` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_dados_relatorios`
    FOREIGN KEY (`relatorio_id`)
    REFERENCES `relatorios` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

-- Inserção de um Usuário Padrão de Teste (Senha: 123456)
INSERT INTO `usuarios` (`nome`, `email`, `senha`) VALUES
('Administrador', 'admin@ismaga.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe112k/k6B18D/o2/a3jO0y9k2.4d9uCe');