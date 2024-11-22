-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2024 a las 22:39:16
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `logisticadistribucion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`) VALUES
(5, 'Almacen de equipo medico', 'Lugar de equipos '),
(6, 'Distribuidara', 'Distribuidora de equipos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centros_logisticos`
--

CREATE TABLE `centros_logisticos` (
  `id_centro` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `longitud` decimal(10,8) DEFAULT NULL,
  `latitud` decimal(10,8) DEFAULT NULL,
  `horario_operacion` varchar(100) DEFAULT NULL,
  `capacidad` int(11) DEFAULT NULL,
  `tipos_recursos` varchar(200) DEFAULT NULL,
  `zona_cobertura` varchar(100) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `centros_logisticos`
--

INSERT INTO `centros_logisticos` (`id_centro`, `nombre`, `id_categoria`, `longitud`, `latitud`, `horario_operacion`, `capacidad`, `tipos_recursos`, `zona_cobertura`, `contacto`) VALUES
(6, 'Centro Logístico P', 6, -64.65432100, -21.67891000, NULL, 300, NULL, 'Zona Sur', 'contactoB@example.com'),
(7, 'Centro Logístico C', 5, -64.11111100, -21.22222200, '09:00-17:00', 700, 'Ropa, Medicinas', 'Zona Este', 'contactoC@example.com'),
(8, 'Centro Logístico D', 6, -64.33333300, -21.44444400, '06:00-14:00', 450, 'Materiales de Construcción', 'Zona Oeste', 'contactoD@example.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `id_ruta` int(11) NOT NULL,
  `id_centro_origen` int(11) NOT NULL,
  `id_centro_destino` int(11) NOT NULL,
  `distancia` float NOT NULL,
  `tiempo_estimado` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutas`
--

INSERT INTO `rutas` (`id_ruta`, `id_centro_origen`, `id_centro_destino`, `distancia`, `tiempo_estimado`) VALUES
(17, 8, 8, 2, '15:05:00'),
(18, 7, 8, 15.5, '00:25:00'),
(19, 8, 6, 30.7, '00:50:00'),
(20, 6, 8, 20, '00:30:00'),
(22, 7, 6, 2, '23:03:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `contrasena`, `rol`) VALUES
(3, 'Visor 12', 'visor1@example.commmm', 'password123456789', 'administrador'),
(4, 'Admin Usuario', 'admin@example.com', '$2y$10$WkU2l.Z8a8GHi5wP7Jt8keDrCdQBd8BgVJ90H7u8dBMhKPyKhLv6K', 'administrador'),
(5, 'Operador Usuario', 'operador@example.com', '$2y$10$rkLG1/t7f02mlhxJzHeAK.qUkLQpgWxP5aJIdYQ/ZMR1oKoaRX8N6', 'operador'),
(6, 'Visor Usuario', 'visor@example.comjnckjan', '$2y$10$vLLYmhONXHh/mGvc6sO5QeNA3o5Kf.6bxt0UShAGKc9pjFfTjIo2u', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `centros_logisticos`
--
ALTER TABLE `centros_logisticos`
  ADD PRIMARY KEY (`id_centro`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`id_ruta`),
  ADD KEY `id_centro_origen` (`id_centro_origen`),
  ADD KEY `id_centro_destino` (`id_centro_destino`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `centros_logisticos`
--
ALTER TABLE `centros_logisticos`
  MODIFY `id_centro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `id_ruta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `centros_logisticos`
--
ALTER TABLE `centros_logisticos`
  ADD CONSTRAINT `centros_logisticos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD CONSTRAINT `rutas_ibfk_1` FOREIGN KEY (`id_centro_origen`) REFERENCES `centros_logisticos` (`id_centro`) ON DELETE CASCADE,
  ADD CONSTRAINT `rutas_ibfk_2` FOREIGN KEY (`id_centro_destino`) REFERENCES `centros_logisticos` (`id_centro`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
