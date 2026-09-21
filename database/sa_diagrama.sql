DROP DATABASE IF EXISTS `ja_ismaga`;
CREATE DATABASE `ja_ismaga` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ja_ismaga`;

CREATE TABLE IF NOT EXISTS `trens` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `linha` VARCHAR(100) NOT NULL,
  `placa` VARCHAR(45) NOT NULL,
  `status` ENUM('ativo', 'manutencao', 'inativo') NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL,
  `trem_id` INT(11) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_usuarios_trens`
    FOREIGN KEY (`trem_id`)
    REFERENCES `trens` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

INSERT INTO `usuarios` (`nome`, `email`, `senha`) VALUES
('Administrador', 'admin@ismaga.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe112k/k6B18D/o2/a3jO0y9k2.4d9uCe');