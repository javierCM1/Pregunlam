-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2024 a las 00:05:18
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pregunlam_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `descripcion_categoria` varchar(50) NOT NULL,
  `img_categoria` varchar(255) NOT NULL,
  `color_categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `descripcion_categoria`, `img_categoria`, `color_categoria`) VALUES
(1, 'Historia', 'public/images/img-categoria/historia.png', '#F2D31F'),
(2, 'Deporte', 'public/images/img-categoria/deporte.png', '#EC2E35'),
(3, 'Entretenimiento', 'public/images/img-categoria/entretenimiento.png', '#ED4CAD'),
(4, 'Arte', 'public/images/img-categoria/arte.png', '#9025EC'),
(5, 'Tecnología', 'public/images/img-categoria/tecnologia.png', '#3343EC'),
(6, 'Geografía', 'public/images/img-categoria/geografia.png', '#39C1F1'),
(7, 'Ciencia', 'public/images/img-categoria/ciencia.png', '#36EC4B');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL,
  `descripcion_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `descripcion_estado`) VALUES
(1, 'pendiente'),
(2, 'aprobada'),
(3, 'reportada'),
(4, 'rechazada'),
(5, 'desactivada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `id_partida` int(11) NOT NULL,
  `fechaHora_partida` datetime NOT NULL,
  `puntaje_partida` int(11) NOT NULL,
  `estado_partida` char(1) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id_pregunta` int(11) NOT NULL,
  `interrogante_pregunta` varchar(255) NOT NULL,
  `fechaCreacion_pregunta` date NOT NULL,
  `cantVistas_pregunta` int(11) DEFAULT NULL,
  `cantCorrectas_pregunta` int(11) DEFAULT NULL,
  `id_usuarioCreador` int(11) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_partida`
--

CREATE TABLE `pregunta_partida` (
  `id_pregunta_partida` int(11) NOT NULL,
  `respondeCorrecto_pregunta_partida` tinyint(1) NOT NULL,
  `fechaHoraEntrega_pregunta_partida` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_partida` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta_vista`
--

CREATE TABLE `pregunta_vista` (
  `id_pregunta_vista` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_pregunta`
--

CREATE TABLE `reporte_pregunta` (
  `id_reporte` int(11) NOT NULL,
  `motivo_reporte` varchar(255) NOT NULL,
  `fecha_reporte` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id_respuesta` int(11) NOT NULL,
  `descripcion_respuesta` varchar(50) NOT NULL,
  `esCorrecta_respuesta` tinyint(1) NOT NULL,
  `id_pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sexo`
--

CREATE TABLE `sexo` (
  `id_sexo` int(11) NOT NULL,
  `descripcion_sexo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sexo`
--

INSERT INTO `sexo` (`id_sexo`, `descripcion_sexo`) VALUES
(1, 'masculino'),
(2, 'femenino'),
(3, 'x');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `descripcion_tipo_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `descripcion_tipo_usuario`) VALUES
(1, 'admin'),
(2, 'editor'),
(3, 'jugador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `userName_usuario` varchar(32) NOT NULL,
  `password_usuario` varchar(255) NOT NULL,
  `email_usuario` varchar(254) NOT NULL,
  `img_usuario` varchar(255) NOT NULL,
  `maxPuntaje_usuario` int(11) DEFAULT NULL,
  `nombreCompleto_usuario` varchar(128) NOT NULL,
  `fechaNacimiento_usuario` date NOT NULL,
  `pais_usuario` varchar(255) NOT NULL,
  `fechaRegistro_usuario` date NOT NULL,
  `estado_usuario` char(1) NOT NULL,
  `token_usuario` int(11) NOT NULL,
  `cantPreguntasJugadas_usuario` int(11) DEFAULT NULL,
  `cantPreguntasCorrectas_usuario` int(11) DEFAULT NULL,
  `id_tipo_usuario` int(11) NOT NULL,
  `id_sexo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id_partida`),
  ADD KEY `FK_usuario` (`id_usuario`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `FK_usuario_creador` (`id_usuarioCreador`),
  ADD KEY `FK_categoria` (`id_categoria`),
  ADD KEY `FK_estado` (`id_estado`);

--
-- Indices de la tabla `pregunta_partida`
--
ALTER TABLE `pregunta_partida`
  ADD PRIMARY KEY (`id_pregunta_partida`),
  ADD KEY `FK_pregunta` (`id_pregunta`),
  ADD KEY `FK_partida` (`id_partida`);

--
-- Indices de la tabla `pregunta_vista`
--
ALTER TABLE `pregunta_vista`
  ADD PRIMARY KEY (`id_pregunta_vista`),
  ADD KEY `FK_pregunta1` (`id_pregunta`),
  ADD KEY `FK_usuario1` (`id_usuario`);

--
-- Indices de la tabla `reporte_pregunta`
--
ALTER TABLE `reporte_pregunta`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `FK_usuario2` (`id_usuario`),
  ADD KEY `FK_pregunta2` (`id_pregunta`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id_respuesta`),
  ADD KEY `FK_pregunta3` (`id_pregunta`);

--
-- Indices de la tabla `sexo`
--
ALTER TABLE `sexo`
  ADD PRIMARY KEY (`id_sexo`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `FK_tipo_usuario` (`id_tipo_usuario`),
  ADD KEY `FK_sexo` (`id_sexo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id_partida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pregunta_partida`
--
ALTER TABLE `pregunta_partida`
  MODIFY `id_pregunta_partida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pregunta_vista`
--
ALTER TABLE `pregunta_vista`
  MODIFY `id_pregunta_vista` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte_pregunta`
--
ALTER TABLE `reporte_pregunta`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sexo`
--
ALTER TABLE `sexo`
  MODIFY `id_sexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `FK_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `FK_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `FK_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `FK_usuario_creador` FOREIGN KEY (`id_usuarioCreador`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `pregunta_partida`
--
ALTER TABLE `pregunta_partida`
  ADD CONSTRAINT `FK_partida` FOREIGN KEY (`id_partida`) REFERENCES `partida` (`id_partida`),
  ADD CONSTRAINT `FK_pregunta` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id_pregunta`);

--
-- Filtros para la tabla `pregunta_vista`
--
ALTER TABLE `pregunta_vista`
  ADD CONSTRAINT `FK_pregunta1` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id_pregunta`),
  ADD CONSTRAINT `FK_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `reporte_pregunta`
--
ALTER TABLE `reporte_pregunta`
  ADD CONSTRAINT `FK_pregunta2` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id_pregunta`),
  ADD CONSTRAINT `FK_usuario2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `FK_pregunta3` FOREIGN KEY (`id_pregunta`) REFERENCES `pregunta` (`id_pregunta`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_sexo` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id_sexo`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_tipo_usuario` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
