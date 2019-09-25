-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-05-2019 a las 12:16:39
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `particulares-bbdd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id` int(11) NOT NULL,
  `id_profesor` int(11) DEFAULT NULL,
  `materia` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nivel` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idioma` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` text COLLATE utf8_spanish_ci,
  `zona` text COLLATE utf8_spanish_ci,
  `coords` text COLLATE utf8_spanish_ci NOT NULL,
  `precio` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id`, `id_profesor`, `materia`, `nivel`, `idioma`, `descripcion`, `zona`, `coords`, `precio`, `fecha`) VALUES
(5, 23, 'Matemáticas', 'Bachillerato', 'Español', 'Profesor experimentado ofrece clases de mátemáticas a nivel de bachillerato.', 'Vallecas, Provincia de Madrid, Madrid', '40.38333000000006,-3.6166699999999423', 15, '2019-05-19 09:49:03'),
(6, 23, 'Lengua', 'Secundaria', 'Español', 'Literatura de 1º a 4º de la ESO.', 'Vallecas, Provincia de Madrid, Madrid', '40.38333000000006,-3.6166699999999423', 10, '2019-05-19 09:49:03'),
(7, 25, 'Matemática Discreta', 'Universidad', 'Español', 'Profesor universitario con 10 años de experiencia.', 'Avenida Complutense, 28040, Ciudad Universitaria, Madrid, Comunidad de Madrid', '40.44370950000002,-3.7273072499999955', 20, '2019-05-19 09:49:03'),
(8, 25, 'Fundamentos de la programación', 'Primaria', 'Español', 'Programación en C++.', 'Moncloa-Aravaca, Provincia de Madrid, Madrid, ESP', '40.435470000000066,-3.7316999999999325', 20, '2019-05-19 09:49:03'),
(12, 30, 'Programación Web', 'Universidad', 'Español', 'Progrmación web desde 0.', 'Londres, Ingalaterra', '51.50642000000005,-0.1272099999999341', 25, '2019-05-19 09:49:03'),
(13, 30, 'Física', 'Primaria', 'Español', 'Física sobre lo que recuerdo de bachillerato.', 'London, England', '51.50642000000005,-0.1272099999999341', 10, '2019-05-19 09:55:22'),
(14, 23, 'Inglés para manchegos', 'Primaria', 'Español', 'Inglés, nivel muy básico. También se enseña a escribir.', 'San Blas, Provincia de Madrid, Madrid', '40.43893000000003,-3.6153699999999276', 5, '2019-05-19 10:02:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios_usuarios`
--

CREATE TABLE `comentarios_usuarios` (
  `id` int(11) NOT NULL,
  `id_emisor` int(11) DEFAULT NULL,
  `id_receptor` int(11) DEFAULT NULL,
  `texto` text COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `comentarios_usuarios`
--

INSERT INTO `comentarios_usuarios` (`id`, `id_emisor`, `id_receptor`, `texto`) VALUES
(1, 26, 25, 'Geniales las clases, no he tenido problema.\r\n'),
(2, 25, 23, 'Me cae mal.'),
(3, 24, 25, 'Muy buen profesor.'),
(4, 24, 30, 'Se le va majo'),
(5, 26, 30, 'Simpático');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fecha_clases`
--

CREATE TABLE `fecha_clases` (
  `id` int(11) NOT NULL,
  `id_clase` int(11) NOT NULL,
  `fecha_ini` date NOT NULL,
  `hora_ini` time NOT NULL,
  `fecha_fin` date NOT NULL,
  `dia` varchar(5) COLLATE utf8_spanish_ci NOT NULL,
  `intervalo` int(5) NOT NULL DEFAULT '1',
  `duracion` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `fecha_clases`
--

INSERT INTO `fecha_clases` (`id`, `id_clase`, `fecha_ini`, `hora_ini`, `fecha_fin`, `dia`, `intervalo`, `duracion`) VALUES
(1, 7, '2019-05-06', '12:12:00', '2019-06-20', 'mo', 2, '02:00:00'),
(2, 6, '2019-05-15', '09:00:00', '2019-06-13', 'fr', 1, '22:00:00'),
(6, 8, '2019-04-08', '10:00:00', '2019-06-05', 'we', 1, '00:45:00'),
(7, 5, '2019-05-05', '17:00:00', '2019-05-31', 'th', 1, '01:00:00'),
(8, 12, '2019-05-22', '17:00:00', '2019-07-31', 'th', 1, '02:00:00'),
(9, 12, '2019-05-22', '17:00:00', '2019-07-31', 'su', 1, '02:00:00'),
(10, 13, '2019-05-22', '19:30:00', '2019-07-31', 'su', 1, '02:00:00'),
(11, 14, '2019-05-20', '17:00:00', '2019-10-31', 'tu', 1, '02:00:00'),
(12, 14, '2019-05-20', '12:00:00', '2019-10-31', 'th', 2, '03:00:00'),
(13, 14, '2019-05-20', '18:00:00', '2019-10-31', 'sa', 1, '02:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `id_emisor` int(11) DEFAULT NULL,
  `id_receptor` int(11) DEFAULT NULL,
  `texto` text COLLATE utf8_spanish_ci,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `id_emisor`, `id_receptor`, `texto`, `fecha`) VALUES
(29, 26, 25, 'Buenas tardes', '2019-04-10 21:13:57'),
(30, 26, 25, 'Me preguntaba si estás disponible para este viernes.', '2019-04-10 21:14:35'),
(31, 25, 26, 'Este viernes no puedo, pero la semana que viene estoy disponible.', '2019-04-10 21:15:47'),
(32, 23, 24, 'Hola, ¿quieres clases?', '2019-04-12 07:51:57'),
(33, 23, 26, 'Hola, ¿quieres clases?', '2019-04-12 07:52:04'),
(34, 24, 23, 'No gracias', '2019-05-19 09:45:55'),
(35, 30, 24, 'Aquí tienes el material', '2019-05-19 09:56:37'),
(36, 30, 27, 'Hola admin, mira un archivo.', '2019-05-19 09:57:17'),
(37, 26, 23, 'Mira esto', '2019-05-19 09:58:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_datos`
--

CREATE TABLE `profesor_datos` (
  `id` int(11) NOT NULL,
  `IBAN` varchar(40) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `profesor_datos`
--

INSERT INTO `profesor_datos` (`id`, `IBAN`) VALUES
(30, 'ES310487444610614347');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuaciones`
--

CREATE TABLE `puntuaciones` (
  `id_puntua` int(11) NOT NULL,
  `id_puntuado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_spanish_ci;

--
-- Volcado de datos para la tabla `puntuaciones`
--

INSERT INTO `puntuaciones` (`id_puntua`, `id_puntuado`) VALUES
(24, 23),
(24, 30),
(26, 23),
(26, 25),
(26, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripciones`
--

CREATE TABLE `suscripciones` (
  `id_alumno` int(11) NOT NULL,
  `id_fecha_clase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `suscripciones`
--

INSERT INTO `suscripciones` (`id_alumno`, `id_fecha_clase`) VALUES
(24, 1),
(24, 8),
(24, 9),
(25, 10),
(26, 11),
(26, 12),
(26, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `movil` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `es_admin` tinyint(1) NOT NULL DEFAULT '0',
  `es_profesor` tinyint(1) DEFAULT '0',
  `descripcion` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `puntuacion_media` decimal(3,2) DEFAULT NULL,
  `num_puntuaciones` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `pass`, `email`, `movil`, `nombre`, `apellidos`, `edad`, `es_admin`, `es_profesor`, `descripcion`, `puntuacion_media`, `num_puntuaciones`) VALUES
(23, 'profesor', '$2y$10$d04RxFmWcRnTqWYKUEma7u81Je.5JBUsOZpwenIpER0ydWgKJtGj6', 'profesor@gmail.com', '693827428', 'Fernando', 'Jiménez', 34, 0, 1, 'Soy un profesor desde hace varios años.', '3.00', 2),
(24, 'usuario1', '$2y$10$zJxEkSYnQmOdtFth2wNFR.oz9OSpRChNlSFrwQ6OGxXaplI3RP9Ka', 'usuario1@gmail.com', '683274273', 'Paco', 'García', 18, 0, 0, 'Majo, a veces. Suelo pagar también.', '0.00', 0),
(25, 'profesor2', '$2y$10$xxyM1bWdVNRAYqLdGQxoIOhY2ekeqiP/NM8RsNLus2RXjbxAdPvA2', 'profesor2@gmail.es', '645223154', 'Juan José', 'López', 55, 0, 1, 'Existo.', '4.00', 1),
(26, 'usuario2', '$2y$10$WQpu6L9j4Dm6NWP80yRs8.VqdX4WwUdWJ6Kt9N7DB0eJPizTtqima', 'usuario2@hotmail.com', '684555564', 'Rosario', 'Foncillas', 20, 0, 0, '', '0.00', 0),
(27, 'admin', '$2y$10$hd7IPrwXfJb49soQO2BoJuncMNWu03144Q7xsbHaZSk/dE/lVxBlO', 'admin@gmail.com', '123123123', 'admin', 'aaaaa', 20, 1, 0, 'Hola, soy el admin.', '0.00', 0),
(30, 'profesor3', '$2y$10$10Dt7f2HG/B2yOm4kUTKneKnky5Iu1D7j80Bw2T9QKbLb/eQF/jLW', 'profesor3@gmail.com', '694343223', 'Alonso', 'Gómez', 23, 0, 1, 'Profesor en Inglaterra.', '3.50', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_profesor` (`id_profesor`);

--
-- Indices de la tabla `comentarios_usuarios`
--
ALTER TABLE `comentarios_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_emisor` (`id_emisor`),
  ADD KEY `id_receptor` (`id_receptor`);

--
-- Indices de la tabla `fecha_clases`
--
ALTER TABLE `fecha_clases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_clase` (`id_clase`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_emisor` (`id_emisor`),
  ADD KEY `id_receptor` (`id_receptor`);

--
-- Indices de la tabla `profesor_datos`
--
ALTER TABLE `profesor_datos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `puntuaciones`
--
ALTER TABLE `puntuaciones`
  ADD PRIMARY KEY (`id_puntua`,`id_puntuado`),
  ADD KEY `id_puntuado` (`id_puntuado`);

--
-- Indices de la tabla `suscripciones`
--
ALTER TABLE `suscripciones`
  ADD PRIMARY KEY (`id_alumno`,`id_fecha_clase`),
  ADD KEY `id_clase` (`id_fecha_clase`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `comentarios_usuarios`
--
ALTER TABLE `comentarios_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `fecha_clases`
--
ALTER TABLE `fecha_clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `profesor_datos`
--
ALTER TABLE `profesor_datos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clases`
--
ALTER TABLE `clases`
  ADD CONSTRAINT `clases_ibfk_1` FOREIGN KEY (`id_profesor`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `comentarios_usuarios`
--
ALTER TABLE `comentarios_usuarios`
  ADD CONSTRAINT `comentarios_usuarios_ibfk_1` FOREIGN KEY (`id_emisor`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `comentarios_usuarios_ibfk_2` FOREIGN KEY (`id_receptor`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `fecha_clases`
--
ALTER TABLE `fecha_clases`
  ADD CONSTRAINT `fecha_clases_ibfk_1` FOREIGN KEY (`id_clase`) REFERENCES `clases` (`id`);

--
-- Filtros para la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`id_emisor`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`id_receptor`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `profesor_datos`
--
ALTER TABLE `profesor_datos`
  ADD CONSTRAINT `profesor_datos_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `puntuaciones`
--
ALTER TABLE `puntuaciones`
  ADD CONSTRAINT `puntuaciones_ibfk_1` FOREIGN KEY (`id_puntua`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `puntuaciones_ibfk_2` FOREIGN KEY (`id_puntuado`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `suscripciones`
--
ALTER TABLE `suscripciones`
  ADD CONSTRAINT `suscripciones_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `suscripciones_ibfk_2` FOREIGN KEY (`id_fecha_clase`) REFERENCES `fecha_clases` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
