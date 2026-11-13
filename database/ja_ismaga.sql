SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "-03:00";

DROP DATABASE IF EXISTS `ja_ismaga`;
CREATE DATABASE `ja_ismaga` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ja_ismaga`;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('admin','operador','usuario comum') NOT NULL DEFAULT 'operador',
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `protegido` tinyint(1) DEFAULT 0,
  `trem_id` int(11) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `logradouro` varchar(150) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_usuarios_trens` (`trem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `trens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `capacidade` int(11) NOT NULL DEFAULT 0,
  `status` enum('ativo','manutencao','inativo') NOT NULL DEFAULT 'ativo',
  `usuario_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_trens_usuarios` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `rotas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_rota` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `origem` varchar(100) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `distancia_km` decimal(8,2) NOT NULL,
  `tempo_previsto` varchar(50) NOT NULL,
  `trem_id` int(11) DEFAULT NULL,
  `status_rota` enum('ativa','inativa','manutencao') NOT NULL DEFAULT 'ativa',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_rotas_trens` (`trem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `sensores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_sensor` varchar(50) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `localizacao` varchar(100) NOT NULL DEFAULT 'Estação Central',
  `status_leitura` varchar(50) NOT NULL DEFAULT 'Ativo',
  `nome` varchar(100) NOT NULL,
  `codigo_identificador` varchar(50) NOT NULL,
  `tipo_dado` varchar(50) NOT NULL,
  `trem_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_identificador` (`codigo_identificador`),
  KEY `fk_sensores_trens` (`trem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `dados_sensores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sensor_id` int(11) NOT NULL,
  `valor` varchar(50) NOT NULL,
  `data_horario` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_sensor_data` (`sensor_id`,`data_horario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`, `ativo`, `protegido`, `trem_id`, `created_at`) VALUES
(1, 'Administrador', 'admin@ismaga.com', '$2y$10$T15XL2dpq5510gruNEJiI.mZacf5ut79qIAJQuyC94nqZ3VaFNXNq', 'admin', 1, 1, NULL, '2026-10-23 14:36:54'),
(2, 'Ícaro', 'icaro@gmail.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe112k/kC9K2.S2/B69315nSJu5O.xIey', 'operador', 1, 0, NULL, '2026-10-23 14:36:54'),
(3, 'Isabela', 'isabela@gmail.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe112k/kC9K2.S2/B69315nSJu5O.xIey', 'operador', 1, 0, NULL, '2026-10-23 14:36:54'),
(4, 'Gabriela', 'gabriela@gmail.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe112k/kC9K2.S2/B69315nSJu5O.xIey', 'operador', 1, 0, NULL, '2026-10-23 14:36:54'),
(5, 'Maria', 'maria@gmail.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe112k/kC9K2.S2/B69315nSJu5O.xIey', 'operador', 1, 0, NULL, '2026-10-23 14:36:54'),
(6, 'Jaime', 'jaime@gmail.com', '$2y$10$H6SuyK56xP3XxsBBLkAsJeFvEXR7KyxhARPNVICe7V25BeJCBvYIy', 'operador', 1, 0, NULL, '2026-10-23 14:36:54'),
(7, 'Lucas', 'lucas@gmail.com', '$2y$10$ms49vpE1UMWIX1IHT9oBIeVpzyLUDH1x2m5ijTnjuQtYlS/CFg5i6', 'usuario comum', 1, 0, NULL, '2026-10-23 14:36:54');

INSERT INTO `trens` (`id`, `nome`, `modelo`, `capacidade`, `status`, `usuario_id`, `created_at`) VALUES
(1, 'Expressa Ferrorama', 'EF-2000', 350, 'ativo', 2, '2026-10-23 14:36:54'),
(2, 'Trem do 67', 'TEE-67', 67, 'manutencao', 5, '2026-10-23 14:36:54');

UPDATE `usuarios` SET `trem_id` = 1 WHERE `id` = 2;

INSERT INTO `rotas` (`id`, `nome_rota`, `descricao`, `origem`, `destino`, `distancia_km`, `tempo_previsto`, `trem_id`, `status_rota`, `created_at`) VALUES
(1, 'Linha Central', 'Rota principal para transporte urbano de passageiros.', 'Estação Central', 'Terminal Norte', 45.50, '01h 15m', 1, 'ativa', '2026-10-23 14:36:54'),
(2, 'Linha do morro', 'Rota principal para o lado mais humilde da cidade', 'Estação Central', 'Terminal do morro', 67.00, '01h 00m', 2, 'manutencao', '2026-10-23 14:36:54'),
(3, 'Linha do lux', 'Rota principal para o lado mais luxuoso da cidade', 'Estação Central', 'Terminal do luxo', 16.08, '50min', NULL, 'inativa', '2026-10-23 14:36:54');

INSERT INTO `sensores` (`id`, `codigo_sensor`, `tipo`, `localizacao`, `status_leitura`, `nome`, `codigo_identificador`, `tipo_dado`, `trem_id`) VALUES
(1, 'SNR-001', 'Temperatura', 'Locomotiva Principal', 'Ativo', 'Sensor Térmico Motor', 'SNR-001', 'Temperatura (°C)', 1),
(2, 'SNR-002', 'Velocidade / GPS', 'Vagão Frontal', 'Ativo', 'Tacômetro & GPS', 'SNR-002', 'Velocidade (km/h)', 1),
(3, 'SNR-003', 'Ultrassônico', 'Trilho Norte', 'Manutenção', 'Detector de Obstáculo', 'SNR-003', 'Distância (cm)', 2);

INSERT INTO `dados_sensores` (`id`, `sensor_id`, `valor`, `data_horario`) VALUES
(1, 1, '68.5 °C', NOW()),
(2, 2, '48.5 km/h', NOW());

ALTER TABLE `dados_sensores`
  ADD CONSTRAINT `fk_dados_sensores` FOREIGN KEY (`sensor_id`) REFERENCES `sensores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `rotas`
  ADD CONSTRAINT `fk_rotas_trens` FOREIGN KEY (`trem_id`) REFERENCES `trens` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `sensores`
  ADD CONSTRAINT `fk_sensores_trens` FOREIGN KEY (`trem_id`) REFERENCES `trens` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `trens`
  ADD CONSTRAINT `fk_trens_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_trens` FOREIGN KEY (`trem_id`) REFERENCES `trens` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

COMMIT;