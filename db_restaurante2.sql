-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-01-2024 a las 22:08:19
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_restaurante2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `user` varchar(20) NOT NULL,
  `pass` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `user`, `pass`) VALUES
(111, 'admin@gmail.com', '$2y$10$FGYG3ekv9SqkQ4CtRl1ljOhvUfpO9qeQdvbp38dQeGQIIqIS.cdgK');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_camareros`
--

CREATE TABLE `tbl_camareros` (
  `id_user` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(40) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contrasena` varchar(250) NOT NULL,
  `tipo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_camareros`
--

INSERT INTO `tbl_camareros` (`id_user`, `nombre`, `apellido`, `correo`, `contrasena`, `tipo_id`) VALUES
(1, 'Julia', 'Gimeno', 'juliagimeno@gmail.com', 'qweQWE123', 1),
(2, 'Jorge', 'Lay', 'jorge@gmail.com', '$2y$10$qoqGHk2cmOumJNQ7KHPE4eyJgNr0rlykUvLIE86llfPXDz4RBsrvm', 3),
(3, 'Oscar', 'Lopez', 'oscar@gmail.com', '$2y$10$qoqGHk2cmOumJNQ7KHPE4eyJgNr0rlykUvLIE86llfPXDz4RBsrvm', 3),
(4, 'Oscar', 'Lerida', 'alberto@gmail.com', '$2y$10$qoqGHk2cmOumJNQ7KHPE4eyJgNr0rlykUvLIE86llfPXDz4RBsrvm', 3),
(5, 'Nerea', 'Lerida', 'nerea@gmail.com', '$2y$10$qoqGHk2cmOumJNQ7KHPE4eyJgNr0rlykUvLIE86llfPXDz4RBsrvm', 2),
(6, 'Julian', 'Romero', 'julian@gmail.com', '$2y$10$qoqGHk2cmOumJNQ7KHPE4eyJgNr0rlykUvLIE86llfPXDz4RBsrvm', 2),
(7, 'Juan', 'Vanegas', 'juan@gmail.com', '$2y$10$qoqGHk2cmOumJNQ7KHPE4eyJgNr0rlykUvLIE86llfPXDz4RBsrvm', 2),
(8, 'Pedro', 'Picapiedras', 'pedro@gmail.com', '$2y$10$qoqGHk2cmOumJNQ7KHPE4eyJgNr0rlykUvLIE86llfPXDz4RBsrvm', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_mesas`
--

CREATE TABLE `tbl_mesas` (
  `id_mesa` int(11) NOT NULL,
  `id_sala` int(11) DEFAULT NULL,
  `mesa_ocupada` tinyint(1) DEFAULT 0,
  `numero_mesa` int(11) DEFAULT NULL,
  `fecha_entrada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_mesas`
--

INSERT INTO `tbl_mesas` (`id_mesa`, `id_sala`, `mesa_ocupada`, `numero_mesa`, `fecha_entrada`) VALUES
(1, 1, 0, 1, NULL),
(2, 2, 0, 2, NULL),
(3, 7, 0, 1, NULL),
(4, 6, 0, 2, NULL),
(5, 3, 0, 1, NULL),
(6, 8, 0, 2, NULL),
(7, 4, 0, 1, NULL),
(8, 7, 0, 2, NULL),
(9, 5, 0, 1, NULL),
(10, 9, 0, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_registros_mesas`
--

CREATE TABLE `tbl_registros_mesas` (
  `id_registro_mesas` int(11) NOT NULL,
  `id_mesa` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `fecha_hora_entrada` timestamp NULL DEFAULT NULL,
  `fecha_hora_salida` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_registros_mesas`
--

INSERT INTO `tbl_registros_mesas` (`id_registro_mesas`, `id_mesa`, `id_user`, `fecha_hora_entrada`, `fecha_hora_salida`) VALUES
(1, 5, 1, '2025-11-23 17:33:26', '2023-11-23 17:33:26'),
(2, 7, 1, '2023-11-23 17:39:25', '2023-11-23 17:39:27'),
(3, 9, 1, '2023-11-23 17:48:00', '2023-11-23 17:48:00'),
(4, 5, 1, '2023-11-23 17:56:43', '2023-11-23 17:56:46'),
(5, 4, 1, '2023-11-23 17:56:47', '2023-11-23 17:56:47'),
(6, 2, 1, '2023-11-23 17:56:48', '2023-11-23 17:56:50'),
(7, 4, 1, '2023-11-23 17:57:09', '2023-11-23 17:57:12'),
(8, 1, 1, '2023-11-23 17:57:10', '2023-11-23 17:57:12'),
(9, 10, 1, '2023-11-23 17:57:10', '2023-11-23 17:57:13'),
(10, 9, 1, '2023-11-23 17:57:09', '2023-11-23 17:57:13'),
(11, 5, 1, '2023-11-23 17:57:08', '2023-11-23 17:57:13'),
(12, 6, 1, '2023-11-23 17:57:09', '2023-11-23 17:57:14'),
(13, 8, 1, '2023-11-24 13:36:55', '2023-11-24 13:36:57'),
(14, 5, 1, '2023-11-24 13:36:50', '2023-11-24 13:36:59'),
(15, 5, 1, '2023-11-24 13:37:06', '2023-11-24 13:37:37'),
(16, 5, 1, '2023-11-24 13:37:39', '2023-11-24 13:38:07'),
(17, 10, 1, '2023-11-24 14:04:27', '2023-11-24 14:04:28'),
(18, 5, 1, '2023-11-24 15:08:47', '2023-11-24 15:08:48'),
(19, 5, 1, '2023-11-24 15:08:50', '2023-11-24 15:08:56'),
(20, 5, 1, '2023-11-24 15:08:57', '2023-11-24 15:08:58'),
(21, 9, 1, '2023-11-24 15:09:30', '2023-11-24 15:09:30'),
(22, 10, 1, '2023-11-24 15:09:32', '2023-11-24 15:09:33'),
(23, 1, 1, '2023-11-24 15:09:33', '2023-11-24 15:09:34'),
(24, 4, 1, '2023-11-24 15:09:35', '2023-11-24 15:09:36'),
(25, 2, 1, '2025-11-24 15:09:37', '2023-11-24 15:09:37'),
(26, 7, 1, '2023-11-24 15:09:38', '2023-11-24 15:09:39'),
(27, 8, 1, '2023-11-24 15:09:40', '2023-11-24 15:09:40'),
(28, 3, 1, '2023-11-24 15:09:41', '2023-11-24 15:09:42'),
(29, 6, 1, '2023-11-24 15:09:43', '2023-11-24 15:09:43'),
(30, 9, 1, '2023-11-24 15:10:31', '2023-11-24 15:10:34'),
(31, 9, 1, '2023-11-24 15:10:46', '2023-11-24 15:17:37'),
(32, 10, 1, '2023-11-24 15:17:36', '2023-11-24 15:17:38'),
(33, 2, 1, '2023-11-24 15:17:40', '2023-11-24 15:17:41'),
(34, 8, 1, '2023-11-24 15:17:43', '2023-11-24 15:17:44'),
(35, 7, 1, '2023-11-24 15:17:48', '2023-11-24 15:17:50'),
(36, 3, 1, '2023-11-24 15:21:03', '2023-11-24 15:25:56'),
(37, 3, 1, '2023-11-24 15:25:57', '2023-11-24 15:25:58'),
(38, 8, 1, '2023-11-24 15:24:42', '2023-11-24 15:26:37'),
(39, 8, 1, '2023-11-24 15:26:37', '2023-11-24 15:26:38'),
(40, 4, 1, '2023-11-24 15:21:01', '2023-11-24 15:30:29'),
(41, 4, 1, '2023-11-24 15:30:31', '2023-11-24 17:06:45'),
(42, 3, 1, '2023-11-24 15:25:59', '2023-11-24 17:06:47'),
(43, 8, 1, '2023-11-24 15:26:39', '2023-11-24 17:06:50'),
(44, 4, 1, '2023-11-24 17:06:54', '2023-11-24 17:47:53'),
(45, 4, 1, '2023-11-24 18:09:43', '2023-11-24 18:09:46'),
(46, 4, 1, '2023-11-24 18:09:48', '2023-11-24 18:09:51'),
(47, 4, 1, '2023-11-26 16:46:43', '2023-11-26 16:46:45'),
(48, 3, 1, '2023-11-26 16:47:00', '2023-11-26 16:47:02'),
(49, 3, 1, '2023-11-26 16:47:04', '2023-11-26 16:47:08'),
(50, 5, 1, '2023-11-26 16:47:10', '2023-11-26 16:47:11'),
(51, 10, 1, '2023-11-26 16:47:12', '2023-11-26 16:47:13'),
(52, 1, 1, '2023-11-26 16:47:16', '2023-11-26 16:47:17'),
(53, 5, 2, '2023-11-26 16:51:25', '2023-11-26 16:51:26'),
(54, 9, 2, '2023-11-26 16:51:27', '2023-11-26 16:51:28'),
(55, 1, 2, '2023-11-26 16:51:29', '2023-11-26 16:51:30'),
(56, 7, 2, '2023-11-26 16:51:31', '2023-11-26 16:51:32'),
(57, 2, 2, '2023-11-26 16:51:33', '2023-11-26 16:51:33'),
(58, 8, 2, '2023-11-26 16:51:34', '2023-11-26 16:51:35'),
(59, 10, 2, '2023-11-26 16:51:36', '2023-11-26 16:51:37'),
(60, 9, 2, '2023-11-26 16:51:38', '2023-11-26 16:51:40'),
(61, 9, 3, '2023-11-26 16:53:12', '2023-11-26 16:53:37'),
(62, 8, 3, '2023-11-26 16:53:15', '2023-11-26 16:53:39'),
(63, 5, 3, '2023-11-26 16:53:19', '2023-11-26 16:53:39'),
(64, 2, 3, '2023-11-26 16:53:29', '2023-11-26 16:53:40'),
(65, 10, 3, '2023-11-26 16:53:26', '2023-11-26 16:53:41'),
(66, 1, 3, '2023-11-26 16:53:17', '2023-11-26 16:53:42'),
(67, 4, 3, '2023-11-26 16:53:35', '2023-11-26 16:53:43'),
(68, 3, 3, '2023-11-26 16:53:24', '2023-11-26 16:53:43'),
(69, 6, 3, '2023-11-26 16:53:32', '2023-11-26 16:53:44'),
(70, 7, 3, '2023-11-26 16:53:21', '2023-11-26 16:53:44'),
(71, 3, 1, '2023-11-26 17:44:57', '2023-11-26 17:44:59'),
(72, 8, 1, '2023-11-26 17:44:58', '2023-11-26 17:45:06'),
(73, 9, 1, '2023-11-26 17:45:07', '2023-11-26 18:42:58'),
(74, 9, 1, '2023-11-26 18:45:34', '2023-11-26 18:45:37'),
(75, 9, 1, '2023-11-26 18:45:49', '2023-11-26 18:46:19'),
(76, 1, 1, '2023-11-26 18:46:22', '2023-11-26 18:46:27'),
(77, 4, 1, '2023-11-26 18:49:05', '2024-01-18 16:28:16'),
(78, 6, 3, '2023-11-26 18:51:48', '2024-01-23 14:46:38'),
(79, 7, 3, '2023-11-27 15:53:15', NULL),
(80, 9, 1, '2024-01-17 15:33:40', NULL),
(81, 3, 2, '2024-01-19 17:47:46', '2024-01-24 17:55:27'),
(82, 5, NULL, '2024-01-22 09:28:55', '2024-01-22 15:22:54'),
(83, 10, NULL, '2026-01-22 14:29:00', NULL),
(84, 5, NULL, '2024-01-22 14:24:34', '2024-01-22 15:37:06'),
(85, 5, NULL, '2024-01-22 12:39:00', '2024-01-22 15:46:17'),
(86, 8, NULL, '2024-01-28 15:44:00', NULL),
(87, 5, NULL, '2024-01-22 15:48:00', '2024-01-24 13:36:03'),
(88, 6, NULL, '2024-01-24 12:35:49', NULL),
(89, 6, NULL, '2024-01-24 12:35:50', '2024-01-24 13:41:03'),
(90, 5, NULL, '2024-01-24 12:36:48', '2024-01-24 13:37:11'),
(91, 5, NULL, '2024-01-24 12:37:16', NULL),
(92, 5, NULL, '2024-01-24 12:38:44', '2024-01-24 13:39:48'),
(93, 4, NULL, '2024-01-24 12:40:44', '2024-01-24 13:40:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_registros_sillas`
--

CREATE TABLE `tbl_registros_sillas` (
  `id_registro_silla` int(11) NOT NULL,
  `id_silla` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `fecha_hora_entrada` timestamp NULL DEFAULT NULL,
  `fecha_hora_salida` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_salas`
--

CREATE TABLE `tbl_salas` (
  `id_sala` int(11) NOT NULL,
  `ubicacion_sala` varchar(50) NOT NULL,
  `capacidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_salas`
--

INSERT INTO `tbl_salas` (`id_sala`, `ubicacion_sala`, `capacidad`) VALUES
(1, 'Terraza Principal', 30),
(2, 'Salón Principal', 50),
(3, 'Sala VIP 1', 15),
(4, 'Terraza Secundaria', 20),
(5, 'Sala de Eventos 1', 40),
(6, 'Salón secundario', 30),
(7, 'Terraza trasera', 30),
(8, 'Sala VIP 2', 15),
(9, 'Sala de Eventos 2', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_sillas`
--

CREATE TABLE `tbl_sillas` (
  `id_silla` int(11) NOT NULL,
  `silla_ocupada` tinyint(1) DEFAULT 0,
  `id_mesa` int(11) DEFAULT NULL,
  `fecha_entrada` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_sillas`
--

INSERT INTO `tbl_sillas` (`id_silla`, `silla_ocupada`, `id_mesa`, `fecha_entrada`) VALUES
(7, 0, 4, NULL),
(8, 0, 4, NULL),
(9, 0, 5, NULL),
(10, 0, 5, NULL),
(12, 0, NULL, NULL),
(23, 0, 1, NULL),
(24, 0, 1, NULL),
(25, 0, 4, NULL),
(26, 0, 4, NULL),
(29, 0, 2, NULL),
(30, 0, 2, NULL),
(31, 0, 5, NULL),
(32, 0, NULL, NULL),
(33, 0, NULL, NULL),
(34, 0, 5, NULL),
(36, 0, 6, NULL),
(39, 0, 9, NULL),
(40, 0, 9, NULL),
(41, 0, 9, NULL),
(42, 0, 9, NULL),
(59, 0, 6, NULL),
(66, 0, 3, NULL),
(67, 0, 3, NULL),
(68, 0, 5, NULL),
(69, 0, 5, NULL),
(70, 0, 7, NULL),
(71, 0, 7, NULL),
(72, 0, 8, NULL),
(73, 0, 8, NULL),
(74, 0, 9, NULL),
(75, 0, 9, NULL),
(78, 0, 10, NULL),
(79, 0, 10, NULL),
(80, 0, 7, NULL),
(81, 0, 7, NULL),
(82, 0, 2, NULL),
(83, 0, 2, NULL),
(84, 0, 10, NULL),
(85, 0, 10, NULL),
(86, 0, 1, NULL),
(87, 0, 1, NULL),
(88, 0, 1, NULL),
(89, 0, 1, NULL),
(90, 0, 6, NULL),
(91, 0, 6, NULL),
(92, 0, 10, NULL),
(93, 0, 10, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo`
--

CREATE TABLE `tbl_tipo` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_tipo`
--

INSERT INTO `tbl_tipo` (`id`, `tipo`) VALUES
(1, 'gerentes'),
(2, 'camareros'),
(3, 'personal de mantenimiento');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_camareros`
--
ALTER TABLE `tbl_camareros`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `fk_tipo` (`tipo_id`);

--
-- Indices de la tabla `tbl_mesas`
--
ALTER TABLE `tbl_mesas`
  ADD PRIMARY KEY (`id_mesa`),
  ADD KEY `id_sala` (`id_sala`);

--
-- Indices de la tabla `tbl_registros_mesas`
--
ALTER TABLE `tbl_registros_mesas`
  ADD PRIMARY KEY (`id_registro_mesas`),
  ADD KEY `id_mesa` (`id_mesa`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `tbl_registros_sillas`
--
ALTER TABLE `tbl_registros_sillas`
  ADD PRIMARY KEY (`id_registro_silla`),
  ADD KEY `id_silla` (`id_silla`),
  ADD KEY `id_user` (`id_user`);

--
-- Indices de la tabla `tbl_salas`
--
ALTER TABLE `tbl_salas`
  ADD PRIMARY KEY (`id_sala`);

--
-- Indices de la tabla `tbl_sillas`
--
ALTER TABLE `tbl_sillas`
  ADD PRIMARY KEY (`id_silla`),
  ADD KEY `id_mesa` (`id_mesa`);

--
-- Indices de la tabla `tbl_tipo`
--
ALTER TABLE `tbl_tipo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `tbl_camareros`
--
ALTER TABLE `tbl_camareros`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tbl_mesas`
--
ALTER TABLE `tbl_mesas`
  MODIFY `id_mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `tbl_registros_mesas`
--
ALTER TABLE `tbl_registros_mesas`
  MODIFY `id_registro_mesas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT de la tabla `tbl_registros_sillas`
--
ALTER TABLE `tbl_registros_sillas`
  MODIFY `id_registro_silla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_salas`
--
ALTER TABLE `tbl_salas`
  MODIFY `id_sala` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tbl_sillas`
--
ALTER TABLE `tbl_sillas`
  MODIFY `id_silla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo`
--
ALTER TABLE `tbl_tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_camareros`
--
ALTER TABLE `tbl_camareros`
  ADD CONSTRAINT `fk_tipo` FOREIGN KEY (`tipo_id`) REFERENCES `tbl_tipo` (`id`);

--
-- Filtros para la tabla `tbl_mesas`
--
ALTER TABLE `tbl_mesas`
  ADD CONSTRAINT `tbl_mesas_ibfk_1` FOREIGN KEY (`id_sala`) REFERENCES `tbl_salas` (`id_sala`);

--
-- Filtros para la tabla `tbl_registros_mesas`
--
ALTER TABLE `tbl_registros_mesas`
  ADD CONSTRAINT `tbl_registros_mesas_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `tbl_mesas` (`id_mesa`),
  ADD CONSTRAINT `tbl_registros_mesas_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tbl_camareros` (`id_user`);

--
-- Filtros para la tabla `tbl_registros_sillas`
--
ALTER TABLE `tbl_registros_sillas`
  ADD CONSTRAINT `fk_tbl_registros_sillas_tbl_sillas` FOREIGN KEY (`id_silla`) REFERENCES `tbl_sillas` (`id_silla`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_registros_sillas_ibfk_1` FOREIGN KEY (`id_silla`) REFERENCES `tbl_sillas` (`id_silla`),
  ADD CONSTRAINT `tbl_registros_sillas_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `tbl_camareros` (`id_user`);

--
-- Filtros para la tabla `tbl_sillas`
--
ALTER TABLE `tbl_sillas`
  ADD CONSTRAINT `tbl_sillas_ibfk_1` FOREIGN KEY (`id_mesa`) REFERENCES `tbl_mesas` (`id_mesa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
