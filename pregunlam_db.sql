-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-10-2024 a las 18:13:32
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
  `cantVistas_pregunta` int(11) NOT NULL,
  `cantCorrectas_pregunta` int(11) NOT NULL,
  `id_usuarioCreador` int(11) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id_pregunta`, `interrogante_pregunta`, `fechaCreacion_pregunta`, `cantVistas_pregunta`, `cantCorrectas_pregunta`, `id_usuarioCreador`, `id_categoria`, `id_estado`) VALUES
(1, '¿Quién fue el primer emperador de China?', '2024-10-22', 0, 0, 1, 1, 2),
(2, '¿En qué año cayó el Muro de Berlín?', '2024-10-22', 0, 0, 2, 1, 2),
(3, '¿Cuál fue la civilización que construyó Machu Picchu?', '2024-10-22', 0, 0, 3, 1, 2),
(4, '¿Quién fue el líder del Imperio Mongol?', '2024-10-22', 0, 0, 4, 1, 2),
(5, '¿Qué evento marcó el inicio de la Revolución Francesa?', '2024-10-22', 8, 0, 5, 1, 2),
(6, '¿Cuál es el deporte nacional de Brasil?', '2024-10-22', 0, 0, 1, 2, 2),
(7, '¿En qué país se originó el rugby?', '2024-10-22', 0, 0, 2, 2, 2),
(8, '¿Qué deporte se juega en la Liga Premier?', '2024-10-22', 0, 0, 3, 2, 2),
(9, '¿Cuál es el evento más importante de ciclismo en Europa?', '2024-10-22', 0, 0, 4, 2, 2),
(10, '¿Quién es el máximo goleador de la historia de la UEFA Champions League?', '2024-10-22', 0, 0, 5, 2, 2),
(11, '¿Cuál es la serie argentina más famosa de Netflix?', '2024-10-22', 0, 0, 1, 3, 2),
(12, '¿Qué película ganó el Oscar a la Mejor Película en 2021?', '2024-10-22', 0, 0, 2, 3, 2),
(13, '¿Quién es el creador de la famosa serie \"The Simpsons\"?', '2024-10-22', 0, 0, 3, 3, 2),
(14, '¿Cuál es la película que ganó el Oscar a la Mejor Película en 2022?', '2024-10-22', 0, 0, 4, 3, 2),
(15, '¿Cuál es la película de Disney que se basa en la historia de un joven llamado Aladino?', '2024-10-22', 0, 0, 5, 3, 2),
(16, '¿Quién pintó \"La noche estrellada\"?', '2024-10-22', 0, 0, 1, 4, 2),
(17, '¿Qué artista es conocido por sus murales en México?', '2024-10-22', 0, 0, 1, 4, 2),
(18, '¿Cuál es la técnica utilizada en la obra \"La creación de Adán\"?', '2024-10-22', 0, 0, 1, 4, 2),
(19, '¿Qué estilo artístico representa \"El grito\"?', '2024-10-22', 0, 0, 1, 4, 2),
(20, '¿Quién es el autor de la escultura \"El pensador\"?', '2024-10-22', 0, 0, 1, 4, 2),
(21, '¿Cuál es el lenguaje de programación más utilizado para desarrollo web del lado del cliente?', '2024-10-22', 0, 0, 1, 5, 2),
(22, '¿Qué tecnología se utiliza para hacer comunicaciones a larga distancia sin cables?', '2024-10-22', 0, 0, 2, 5, 2),
(23, '¿Qué dispositivo se utiliza para almacenar datos de manera permanente?', '2024-10-22', 0, 0, 3, 5, 2),
(24, '¿Cuál es el sistema operativo de código abierto más popular?', '2024-10-22', 0, 0, 4, 5, 2),
(25, '¿Qué red social fue lanzada por Mark Zuckerberg en 2004?', '2024-10-22', 0, 0, 5, 5, 2),
(26, '¿Cuál es la capital de Argentina?', '2024-10-22', 0, 0, 1, 6, 2),
(27, '¿Qué país tiene la mayor extensión territorial del mundo?', '2024-10-22', 0, 0, 2, 6, 2),
(28, '¿Cuál es el río más largo de Argentina?', '2024-10-22', 0, 0, 3, 6, 2),
(29, '¿En qué continente se encuentra el país de Egipto?', '2024-10-22', 0, 0, 4, 6, 2),
(30, '¿Cuál es el océano que baña las costas de Argentina?', '2024-10-22', 0, 0, 5, 6, 2),
(31, '¿Cuál es el elemento químico más abundante en el universo?', '2024-10-22', 0, 0, 1, 7, 2),
(32, '¿Qué planeta es conocido como el planeta rojo?', '2024-10-22', 0, 0, 2, 7, 2),
(33, '¿Cuál es la unidad básica de la vida?', '2024-10-22', 0, 0, 3, 7, 2),
(34, '¿Qué tipo de energía es la del sol?', '2024-10-22', 0, 0, 4, 7, 2),
(35, '¿Quién propuso la teoría de la relatividad?', '2024-10-22', 0, 0, 5, 7, 2);

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

--
-- Volcado de datos para la tabla `pregunta_partida`
--

INSERT INTO `pregunta_partida` (`id_pregunta_partida`, `respondeCorrecto_pregunta_partida`, `fechaHoraEntrega_pregunta_partida`, `id_partida`, `id_pregunta`) VALUES
(26, 0, '2024-10-25 15:30:04', 18, 19),
(27, 0, '2024-10-25 15:30:10', 18, 31),
(28, 0, '2024-10-25 15:31:14', 18, 9),
(29, 0, '2024-10-25 15:31:17', 18, 7),
(30, 0, '2024-10-25 15:31:18', 18, 20),
(31, 0, '2024-10-25 15:31:37', 18, 10),
(32, 0, '2024-10-25 15:31:39', 18, 2),
(33, 0, '2024-10-25 15:31:44', 18, 15),
(34, 0, '2024-10-25 15:33:36', 18, 27),
(35, 0, '2024-10-25 15:33:48', 18, 5),
(36, 0, '2024-10-25 15:34:26', 18, 31),
(37, 0, '2024-10-25 15:35:12', 18, 16),
(38, 0, '2024-10-25 15:35:34', 18, 25),
(39, 0, '2024-10-25 15:36:06', 18, 19),
(40, 0, '2024-10-25 15:36:43', 18, 29),
(41, 0, '2024-10-25 15:37:06', 18, 16),
(42, 0, '2024-10-25 15:37:16', 18, 7),
(43, 0, '2024-10-25 15:37:25', 18, 8),
(44, 0, '2024-10-25 15:37:40', 18, 8),
(45, 0, '2024-10-25 15:37:59', 18, 18),
(46, 0, '2024-10-25 15:38:03', 18, 32),
(47, 0, '2024-10-25 15:38:05', 18, 15),
(48, 0, '2024-10-25 15:38:27', 18, 18),
(49, 0, '2024-10-25 15:38:41', 18, 13),
(50, 0, '2024-10-25 15:39:13', 18, 26),
(51, 0, '2024-10-25 15:39:32', 18, 7),
(52, 0, '2024-10-25 15:39:34', 18, 5),
(53, 0, '2024-10-25 15:39:51', 18, 11),
(54, 0, '2024-10-25 15:40:18', 18, 15),
(55, 0, '2024-10-25 15:40:31', 18, 26),
(56, 0, '2024-10-25 15:40:34', 18, 27),
(57, 0, '2024-10-25 15:41:04', 18, 4),
(58, 0, '2024-10-25 15:41:30', 18, 22),
(59, 0, '2024-10-25 15:41:37', 18, 21),
(60, 0, '2024-10-25 15:41:45', 18, 31),
(61, 0, '2024-10-25 15:42:00', 18, 32),
(62, 0, '2024-10-25 15:42:47', 18, 3),
(63, 0, '2024-10-25 15:42:59', 18, 32),
(64, 0, '2024-10-25 15:43:19', 18, 25),
(65, 0, '2024-10-25 15:43:30', 18, 18),
(66, 0, '2024-10-25 15:43:39', 18, 5),
(67, 0, '2024-10-25 15:43:48', 18, 1),
(68, 0, '2024-10-25 15:44:17', 18, 5),
(69, 0, '2024-10-25 15:44:23', 18, 13),
(70, 0, '2024-10-25 15:44:54', 18, 6),
(71, 0, '2024-10-25 15:45:43', 18, 19),
(72, 0, '2024-10-25 15:46:27', 18, 26),
(73, 0, '2024-10-25 15:47:02', 18, 8),
(74, 0, '2024-10-25 15:47:29', 18, 17),
(75, 0, '2024-10-25 15:47:53', 18, 15),
(76, 0, '2024-10-25 15:48:05', 18, 34),
(77, 0, '2024-10-25 15:48:08', 18, 4),
(78, 0, '2024-10-25 15:48:18', 18, 28),
(79, 0, '2024-10-25 15:51:05', 18, 4),
(80, 0, '2024-10-25 15:51:34', 18, 7),
(81, 0, '2024-10-25 15:51:52', 18, 23),
(82, 0, '2024-10-25 15:52:18', 18, 20),
(83, 0, '2024-10-25 15:52:34', 18, 34),
(84, 0, '2024-10-25 15:52:59', 18, 30),
(85, 0, '2024-10-25 15:53:02', 18, 22),
(86, 0, '2024-10-25 15:53:04', 18, 19),
(87, 0, '2024-10-25 15:53:05', 18, 21),
(88, 0, '2024-10-25 15:53:22', 18, 25),
(89, 0, '2024-10-25 15:53:23', 18, 13),
(90, 0, '2024-10-25 15:54:15', 18, 7),
(91, 0, '2024-10-25 15:54:16', 18, 21),
(92, 0, '2024-10-25 15:54:17', 18, 2),
(93, 0, '2024-10-25 15:54:17', 18, 15),
(94, 0, '2024-10-25 15:54:18', 18, 2),
(95, 0, '2024-10-25 15:54:18', 18, 32),
(96, 0, '2024-10-25 15:54:19', 18, 2),
(97, 0, '2024-10-25 15:54:20', 18, 9),
(98, 0, '2024-10-25 15:54:20', 18, 7),
(99, 0, '2024-10-25 15:54:21', 18, 1),
(100, 0, '2024-10-25 15:54:22', 18, 9),
(101, 0, '2024-10-25 15:54:23', 18, 10),
(102, 0, '2024-10-25 15:54:23', 18, 25),
(103, 0, '2024-10-25 15:54:59', 18, 17),
(104, 0, '2024-10-25 15:55:00', 18, 31),
(105, 0, '2024-10-25 15:55:01', 18, 15),
(106, 0, '2024-10-25 15:55:02', 18, 1),
(107, 0, '2024-10-25 15:55:03', 18, 1),
(108, 0, '2024-10-25 15:55:04', 18, 20),
(109, 0, '2024-10-25 15:55:04', 18, 15),
(110, 0, '2024-10-25 15:55:05', 18, 31),
(111, 0, '2024-10-25 15:55:06', 18, 3),
(112, 0, '2024-10-25 15:55:07', 18, 25),
(113, 0, '2024-10-25 15:55:08', 18, 34),
(114, 0, '2024-10-25 15:55:08', 18, 27),
(115, 0, '2024-10-25 15:55:09', 18, 18),
(116, 0, '2024-10-25 15:55:10', 18, 4),
(117, 0, '2024-10-25 15:55:11', 18, 19),
(118, 0, '2024-10-25 15:55:11', 18, 3),
(119, 0, '2024-10-25 15:55:12', 18, 22),
(120, 0, '2024-10-25 15:55:13', 18, 23),
(121, 0, '2024-10-25 15:55:14', 18, 26),
(122, 0, '2024-10-25 15:55:14', 18, 32),
(123, 0, '2024-10-25 15:55:15', 18, 26),
(124, 0, '2024-10-25 15:55:16', 18, 18),
(125, 0, '2024-10-25 15:55:16', 18, 29),
(126, 0, '2024-10-25 15:55:17', 18, 13),
(127, 0, '2024-10-25 15:55:18', 18, 15),
(128, 0, '2024-10-25 15:55:19', 18, 31),
(129, 0, '2024-10-25 15:55:20', 18, 3),
(130, 0, '2024-10-25 15:55:21', 18, 32),
(131, 0, '2024-10-25 15:55:21', 18, 28),
(132, 0, '2024-10-25 15:55:22', 18, 22),
(133, 0, '2024-10-25 15:55:23', 18, 4),
(134, 0, '2024-10-25 15:55:23', 18, 1),
(135, 0, '2024-10-25 15:55:24', 18, 10),
(136, 0, '2024-10-25 15:55:25', 18, 24),
(137, 0, '2024-10-25 15:55:26', 18, 16),
(138, 0, '2024-10-25 15:55:26', 18, 9),
(139, 0, '2024-10-25 15:55:27', 18, 14),
(140, 0, '2024-10-25 15:55:28', 18, 32),
(141, 0, '2024-10-25 15:55:29', 18, 2),
(142, 0, '2024-10-25 15:55:29', 18, 28),
(143, 0, '2024-10-25 15:55:30', 18, 33),
(144, 0, '2024-10-25 15:55:31', 18, 31),
(145, 0, '2024-10-25 15:55:31', 18, 25),
(146, 0, '2024-10-25 15:55:32', 18, 9),
(147, 0, '2024-10-25 15:55:33', 18, 27),
(148, 0, '2024-10-25 15:55:33', 18, 17),
(149, 0, '2024-10-25 15:55:34', 18, 1),
(150, 0, '2024-10-25 15:55:35', 18, 14),
(151, 0, '2024-10-25 15:55:36', 18, 11),
(152, 0, '2024-10-25 15:55:36', 18, 29),
(153, 0, '2024-10-25 15:55:37', 18, 23),
(154, 0, '2024-10-25 15:55:38', 18, 30),
(155, 0, '2024-10-25 15:55:38', 18, 29),
(156, 0, '2024-10-25 15:55:39', 18, 30),
(157, 0, '2024-10-25 15:55:40', 18, 21),
(158, 0, '2024-10-25 15:55:40', 18, 3),
(159, 0, '2024-10-25 15:55:41', 18, 12),
(160, 0, '2024-10-25 15:55:42', 18, 11),
(161, 0, '2024-10-25 15:55:42', 18, 22),
(162, 0, '2024-10-25 15:55:43', 18, 29),
(163, 0, '2024-10-25 15:55:43', 18, 25),
(164, 0, '2024-10-25 15:55:44', 18, 19),
(165, 0, '2024-10-25 15:55:45', 18, 23),
(166, 0, '2024-10-25 15:55:45', 18, 10),
(167, 0, '2024-10-25 15:58:00', 18, 1),
(168, 0, '2024-10-25 15:58:03', 18, 1),
(169, 0, '2024-10-25 15:58:03', 18, 1),
(170, 0, '2024-10-25 15:58:36', 18, 1),
(171, 0, '2024-10-25 15:58:47', 18, 1),
(172, 0, '2024-10-25 16:00:35', 18, 1),
(173, 0, '2024-10-25 16:01:03', 18, 1),
(174, 0, '2024-10-25 16:01:29', 18, 27),
(175, 0, '2024-10-25 16:01:31', 18, 6),
(176, 0, '2024-10-25 16:01:32', 18, 12),
(177, 0, '2024-10-25 16:01:33', 18, 31),
(178, 0, '2024-10-25 16:01:40', 18, 1),
(179, 0, '2024-10-25 16:01:41', 18, 32),
(180, 0, '2024-10-25 16:01:41', 18, 9),
(181, 0, '2024-10-25 16:01:41', 18, 5),
(182, 0, '2024-10-25 16:03:05', 18, 12),
(183, 0, '2024-10-25 16:03:07', 18, 5),
(184, 0, '2024-10-25 16:03:08', 18, 19),
(185, 0, '2024-10-25 16:03:09', 18, 18),
(186, 0, '2024-10-25 16:03:10', 18, 8),
(187, 0, '2024-10-25 16:03:11', 18, 9),
(188, 0, '2024-10-25 16:04:48', 18, 18),
(189, 0, '2024-10-25 16:04:49', 18, 33),
(190, 0, '2024-10-25 16:04:50', 18, 3),
(191, 0, '2024-10-25 16:05:45', 18, 35),
(192, 0, '2024-10-25 16:08:44', 18, 19),
(193, 0, '2024-10-25 16:08:45', 18, 7),
(194, 0, '2024-10-25 16:08:45', 18, 24),
(195, 0, '2024-10-25 16:08:46', 18, 24),
(196, 0, '2024-10-25 16:08:46', 18, 7),
(197, 0, '2024-10-25 16:08:47', 18, 12),
(198, 0, '2024-10-25 16:08:47', 18, 14),
(199, 0, '2024-10-25 16:08:48', 18, 20),
(200, 0, '2024-10-25 16:08:48', 18, 15),
(201, 0, '2024-10-25 16:08:48', 18, 4),
(202, 0, '2024-10-25 16:08:49', 18, 20),
(203, 0, '2024-10-25 16:08:49', 18, 16),
(204, 0, '2024-10-25 16:08:50', 18, 7),
(205, 0, '2024-10-25 16:08:50', 18, 19),
(206, 0, '2024-10-25 16:08:50', 18, 20),
(207, 0, '2024-10-25 16:08:51', 18, 1),
(208, 0, '2024-10-25 16:08:51', 18, 15),
(209, 0, '2024-10-25 16:08:52', 18, 32),
(210, 0, '2024-10-25 16:08:52', 18, 20),
(211, 0, '2024-10-25 16:08:53', 18, 29),
(212, 0, '2024-10-25 16:08:53', 18, 3),
(213, 0, '2024-10-25 16:08:54', 18, 27),
(214, 0, '2024-10-25 16:08:54', 18, 12),
(215, 0, '2024-10-25 16:08:55', 18, 33),
(216, 0, '2024-10-25 16:08:55', 18, 8),
(217, 0, '2024-10-25 16:08:56', 18, 25),
(218, 0, '2024-10-25 16:08:56', 18, 4),
(219, 0, '2024-10-25 16:08:57', 18, 10),
(220, 0, '2024-10-25 16:08:57', 18, 24),
(221, 0, '2024-10-25 16:08:58', 18, 23),
(222, 0, '2024-10-25 16:08:58', 18, 29),
(223, 0, '2024-10-25 16:08:59', 18, 8),
(224, 0, '2024-10-25 16:08:59', 18, 24),
(225, 0, '2024-10-25 16:09:00', 18, 15),
(226, 0, '2024-10-25 16:09:01', 18, 5),
(227, 0, '2024-10-25 16:09:01', 18, 27),
(228, 0, '2024-10-25 16:09:02', 18, 25),
(229, 0, '2024-10-25 16:09:03', 18, 29),
(230, 0, '2024-10-25 16:09:03', 18, 23),
(231, 0, '2024-10-25 16:09:04', 18, 18),
(232, 0, '2024-10-25 16:09:04', 18, 23),
(233, 0, '2024-10-25 16:09:05', 18, 14),
(234, 0, '2024-10-25 16:09:05', 18, 2),
(235, 0, '2024-10-25 16:09:06', 18, 17),
(236, 0, '2024-10-25 16:09:07', 18, 13),
(237, 0, '2024-10-25 16:09:07', 18, 3),
(238, 0, '2024-10-25 16:09:08', 18, 30),
(239, 0, '2024-10-25 16:09:08', 18, 5),
(240, 0, '2024-10-25 16:10:11', 18, 2),
(241, 0, '2024-10-25 16:10:11', 18, 17),
(242, 0, '2024-10-25 16:10:11', 18, 32),
(243, 0, '2024-10-25 16:10:11', 18, 6),
(244, 0, '2024-10-25 16:10:12', 18, 23),
(245, 0, '2024-10-25 16:10:12', 18, 25),
(246, 0, '2024-10-25 16:10:12', 18, 32),
(247, 0, '2024-10-25 16:10:12', 18, 6),
(248, 0, '2024-10-25 16:10:12', 18, 8),
(249, 0, '2024-10-25 16:10:12', 18, 20),
(250, 0, '2024-10-25 16:10:13', 18, 19),
(251, 0, '2024-10-25 16:10:13', 18, 26),
(252, 0, '2024-10-25 16:10:13', 18, 31),
(253, 0, '2024-10-25 16:10:13', 18, 7),
(254, 0, '2024-10-25 16:10:13', 18, 13),
(255, 0, '2024-10-25 16:10:13', 18, 10),
(256, 0, '2024-10-25 16:10:14', 18, 31),
(257, 0, '2024-10-25 16:10:14', 18, 14),
(258, 0, '2024-10-25 16:10:14', 18, 16),
(259, 0, '2024-10-25 16:10:14', 18, 34),
(260, 0, '2024-10-25 16:10:14', 18, 5),
(261, 0, '2024-10-25 16:10:14', 18, 2),
(262, 0, '2024-10-25 16:10:15', 18, 29),
(263, 0, '2024-10-25 16:10:15', 18, 4),
(264, 0, '2024-10-25 16:10:15', 18, 17),
(265, 0, '2024-10-25 16:10:15', 18, 1),
(266, 0, '2024-10-25 16:10:15', 18, 28),
(267, 0, '2024-10-25 16:10:16', 18, 16),
(268, 0, '2024-10-25 16:10:16', 18, 32),
(269, 0, '2024-10-25 16:10:16', 18, 11),
(270, 0, '2024-10-25 16:10:16', 18, 13),
(271, 0, '2024-10-25 16:10:16', 18, 33),
(272, 0, '2024-10-25 16:10:17', 18, 16),
(273, 0, '2024-10-25 16:10:17', 18, 20),
(274, 0, '2024-10-25 16:10:17', 18, 30),
(275, 0, '2024-10-25 16:10:17', 18, 11),
(276, 0, '2024-10-25 16:10:17', 18, 9),
(277, 0, '2024-10-25 16:10:17', 18, 26),
(278, 0, '2024-10-25 16:10:18', 18, 2),
(279, 0, '2024-10-25 16:10:18', 18, 9),
(280, 0, '2024-10-25 16:10:18', 18, 7),
(281, 0, '2024-10-25 16:10:18', 18, 11),
(282, 0, '2024-10-25 16:10:18', 18, 20),
(283, 0, '2024-10-25 16:10:19', 18, 23),
(284, 0, '2024-10-25 16:10:19', 18, 5),
(285, 0, '2024-10-25 16:10:19', 18, 15),
(286, 0, '2024-10-25 16:10:19', 18, 5),
(287, 0, '2024-10-25 16:10:19', 18, 32),
(288, 0, '2024-10-25 16:10:19', 18, 14),
(289, 0, '2024-10-25 16:10:20', 18, 13),
(290, 0, '2024-10-25 16:10:20', 18, 19),
(291, 0, '2024-10-25 16:10:20', 18, 23),
(292, 0, '2024-10-25 16:10:20', 18, 24),
(293, 0, '2024-10-25 16:10:20', 18, 33),
(294, 0, '2024-10-25 16:10:30', 18, 31),
(295, 0, '2024-10-25 16:10:50', 18, 19);

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

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`id_respuesta`, `descripcion_respuesta`, `esCorrecta_respuesta`, `id_pregunta`) VALUES
(1, 'Qin Shi Huang', 1, 1),
(2, 'Confucio', 0, 1),
(3, 'Kublai Kan', 0, 1),
(4, 'Sun Tzu', 0, 1),
(5, '1989', 1, 2),
(6, '1991', 0, 2),
(7, '1985', 0, 2),
(8, '1990', 0, 2),
(9, 'Los incas', 1, 3),
(10, 'Los aztecas', 0, 3),
(11, 'Los mayas', 0, 3),
(12, 'Los romanos', 0, 3),
(13, 'Gengis Kan', 1, 4),
(14, 'Atila', 0, 4),
(15, 'Julio César', 0, 4),
(16, 'Carlos Magno', 0, 4),
(17, 'La toma de la Bastilla', 1, 5),
(18, 'La declaración de los Derechos del Hombre', 0, 5),
(19, 'La ejecución de Luis XVI', 0, 5),
(20, 'El inicio de la guerra contra Prusia', 0, 5),
(21, 'Fútbol', 1, 6),
(22, 'Voleibol', 0, 6),
(23, 'Baloncesto', 0, 6),
(24, 'Tenis', 0, 6),
(25, 'Inglaterra', 1, 7),
(26, 'Escocia', 0, 7),
(27, 'Francia', 0, 7),
(28, 'Australia', 0, 7),
(29, 'Fútbol', 1, 8),
(30, 'Rugby', 0, 8),
(31, 'Baloncesto', 0, 8),
(32, 'Cricket', 0, 8),
(33, 'El Tour de Francia', 1, 9),
(34, 'La Vuelta a España', 0, 9),
(35, 'El Giro de Italia', 0, 9),
(36, 'El Campeonato Mundial', 0, 9),
(37, 'Cristiano Ronaldo', 1, 10),
(38, 'Lionel Messi', 0, 10),
(39, 'Raúl González', 0, 10),
(40, 'Thierry Henry', 0, 10),
(41, 'La Casa de Papel', 0, 11),
(42, 'Élite', 0, 11),
(43, 'Los Espookys', 1, 11),
(44, 'Merlí', 0, 11),
(45, 'Nomadland', 1, 12),
(46, 'The Father', 0, 12),
(47, 'Promising Young Woman', 0, 12),
(48, 'Mank', 0, 12),
(49, 'Matt Groening', 1, 13),
(50, 'Seth MacFarlane', 0, 13),
(51, 'Trey Parker', 0, 13),
(52, 'Dan Harmon', 0, 13),
(53, 'CODA', 1, 14),
(54, 'Dune', 0, 14),
(55, 'West Side Story', 0, 14),
(56, 'Belfast', 0, 14),
(57, 'El Rey León', 0, 15),
(58, 'Mulan', 0, 15),
(59, 'Aladino', 1, 15),
(60, 'La Sirenita', 0, 15),
(61, 'Vincent van Gogh', 1, 16),
(62, 'Pablo Picasso', 0, 16),
(63, 'Claude Monet', 0, 16),
(64, 'Henri Matisse', 0, 16),
(65, 'Diego Rivera', 1, 17),
(66, 'Frida Kahlo', 0, 17),
(67, 'David Alfaro Siqueiros', 0, 17),
(68, 'José Clemente Orozco', 0, 17),
(69, 'Fresco', 1, 18),
(70, 'Óleo', 0, 18),
(71, 'Acuarela', 0, 18),
(72, 'Tempera', 0, 18),
(73, 'Expresionismo', 1, 19),
(74, 'Impresionismo', 0, 19),
(75, 'Cubismo', 0, 19),
(76, 'Surrealismo', 0, 19),
(77, 'Auguste Rodin', 1, 20),
(78, 'Gustave Courbet', 0, 20),
(79, 'Henry Moore', 0, 20),
(80, 'Alberto Giacometti', 0, 20),
(81, 'JavaScript', 1, 21),
(82, 'Python', 0, 21),
(83, 'Java', 0, 21),
(84, 'C++', 0, 21),
(85, 'Bluetooth', 0, 22),
(86, 'Wi-Fi', 1, 22),
(87, 'NFC', 0, 22),
(88, 'Ethernet', 0, 22),
(89, 'SSD', 0, 23),
(90, 'HDD', 1, 23),
(91, 'RAM', 0, 23),
(92, 'USB', 0, 23),
(93, 'Windows', 0, 24),
(94, 'Linux', 1, 24),
(95, 'macOS', 0, 24),
(96, 'Unix', 0, 24),
(97, 'Instagram', 0, 25),
(98, 'Twitter', 0, 25),
(99, 'Facebook', 1, 25),
(100, 'LinkedIn', 0, 25),
(101, 'Buenos Aires', 1, 26),
(102, 'Córdoba', 0, 26),
(103, 'La Plata', 0, 26),
(104, 'Mendoza', 0, 26),
(105, 'Rusia', 1, 27),
(106, 'Canadá', 0, 27),
(107, 'China', 0, 27),
(108, 'Estados Unidos', 0, 27),
(109, 'Paraná', 1, 28),
(110, 'Uruguay', 0, 28),
(111, 'Tigre', 0, 28),
(112, 'Colorado', 0, 28),
(113, 'África', 1, 29),
(114, 'Asia', 0, 29),
(115, 'Europa', 0, 29),
(116, 'América', 0, 29),
(117, 'Atlántico', 1, 30),
(118, 'Pacífico', 0, 30),
(119, 'Índico', 0, 30),
(120, 'Ártico', 0, 30),
(121, 'Hidrógeno', 1, 31),
(122, 'Helio', 0, 31),
(123, 'Oxígeno', 0, 31),
(124, 'Carbono', 0, 31),
(125, 'Marte', 1, 32),
(126, 'Júpiter', 0, 32),
(127, 'Venus', 0, 32),
(128, 'Mercurio', 0, 32),
(129, 'Célula', 1, 33),
(130, 'Átomo', 0, 33),
(131, 'Tejido', 0, 33),
(132, 'Órgano', 0, 33),
(133, 'Energía solar', 1, 34),
(134, 'Energía eólica', 0, 34),
(135, 'Energía hidráulica', 0, 34),
(136, 'Energía térmica', 0, 34),
(137, 'Albert Einstein', 1, 35),
(138, 'Isaac Newton', 0, 35),
(139, 'Galileo Galilei', 0, 35),
(140, 'Niels Bohr', 0, 35);

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
  `cantPreguntasJugadas_usuario` int(11) NOT NULL,
  `cantPreguntasCorrectas_usuario` int(11) NOT NULL,
  `id_tipo_usuario` int(11) NOT NULL,
  `id_sexo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `userName_usuario`, `password_usuario`, `email_usuario`, `img_usuario`, `maxPuntaje_usuario`, `nombreCompleto_usuario`, `fechaNacimiento_usuario`, `pais_usuario`, `fechaRegistro_usuario`, `estado_usuario`, `token_usuario`, `cantPreguntasJugadas_usuario`, `cantPreguntasCorrectas_usuario`, `id_tipo_usuario`, `id_sexo`) VALUES
(1, 'kvnrot03', '$2y$10$E876Xs/IYsR1A./UVgxlrOcDUk5F2CUaOtkW74VAnRvlxsW33SiIW', 'kvnrotela@gmail.com', 'public/images/fotoDePerfil/triangle-dancing.gif', NULL, 'Kevin', '2024-10-16', 'Argentina', '2024-10-20', 'a', 126085, 7, 0, 3, 1),
(2, 'Ernesto01', '$2y$10$AAdI21YZNK6o6J382gEhf.aHt4s86WkzZ7TzkUwsMTWsfFLqXLWce', 'ernesto@gmail.com', 'public/images/fotoDePerfil/triangle-dancing.gif', NULL, 'Ernesto', '2024-10-14', 'Argentina', '2024-10-20', 'a', 273684, 0, 0, 3, 1),
(3, 'alex09', '$2y$10$ue3cU5A5ZPNY8GgsrXwPNukdy.SrvGJq84igb2hplGEx/532YaYla', 'alexis@gmail.com', 'public/images/fotoDePerfil/triangle-dancing.gif', NULL, 'alexis', '2024-10-08', 'Argentina', '2024-10-20', 'a', 852260, 0, 0, 3, 1),
(4, 'pablo01', '$2y$10$z42HPSOFsaq8a2uQmgV7X.Ns1MHRfttJEoyVMcs75FK/cqZX7oT4q', 'pablo@gmail.com', '/public/images/fotoDePerfil/triangle-dancing.gif', NULL, 'pablo', '2024-10-08', 'Argentina', '2024-10-20', 'a', 166403, 0, 0, 3, 1),
(5, 'ivan01', '$2y$10$b7UN26.ZW.tS3D67OJcOuOM6RrDwrODIf5qitKQDrMdVAyv8PSVWG', 'ivan@gmail.com', 'public/images/fotoDePerfil/portrait-german-shepherd-head-years-old-front-white-background-copy-space-171994255.jpg', NULL, 'Ivan', '2024-10-03', 'x', '2024-10-21', 'a', 893743, 0, 0, 3, 1),
(6, 'elias04', '$2y$10$6mZqIfdfJEn/axf8ntPdpOgLdVe9OZkjD4aIZI4HWbtUY1/AtPqqO', 'elias@gmail.com', 'public/images/fotoDePerfil/portrait-german-shepherd-head-years-old-front-white-background-copy-space-171994255.jpg', NULL, 'Elias', '2024-10-01', 'Argentina', '2024-10-21', 'a', 296399, 0, 0, 3, 1),
(7, 'wolverine04', '$2y$10$WorEezbFgMOyKDJ1IvfIOeUEf7iWbukrsueIHT7N/OhbVC8mS21Ny', 'wolverine@gmail.com', 'public/images/fotoDePerfil/portrait-german-shepherd-head-years-old-front-white-background-copy-space-171994255.jpg', NULL, 'wolverine', '2024-10-09', 'Argentina', '2024-10-21', 'a', 508803, 0, 0, 3, 1),
(8, 'usuario1', '$2y$10$Fq9ZhU/8qnp1tnpSjD5RBe8B3H8aBzzrIfdp5GD9psg4FVXmS27Ki', 'usuario1@gmail.com', 'public/images/default.jpg', NULL, 'Usuario Uno', '2000-01-01', 'Argentina', '2024-10-20', 'a', 206740, 0, 0, 3, 1),
(9, 'usuario2', '$2y$10$Fq9ZhU/8qnp1tnpSjD5RBe8B3H8aBzzrIfdp5GD9psg4FVXmS27Ki', 'usuario2@gmail.com', 'public/images/default.jpg', NULL, 'Usuario Dos', '2000-02-02', 'Argentina', '2024-10-20', 'a', 936270, 0, 0, 3, 1),
(10, 'usuario3', '$2y$10$Fq9ZhU/8qnp1tnpSjD5RBe8B3H8aBzzrIfdp5GD9psg4FVXmS27Ki', 'usuario3@gmail.com', 'public/images/default.jpg', NULL, 'Usuario Tres', '2000-03-03', 'Argentina', '2024-10-20', 'a', 361128, 0, 0, 3, 1),
(11, 'usuario4', '$2y$10$Fq9ZhU/8qnp1tnpSjD5RBe8B3H8aBzzrIfdp5GD9psg4FVXmS27Ki', 'usuario4@gmail.com', 'public/images/default.jpg', NULL, 'Usuario Cuatro', '2000-04-04', 'Argentina', '2024-10-20', 'a', 696831, 0, 0, 3, 1),
(12, 'usuario5', '$2y$10$Fq9ZhU/8qnp1tnpSjD5RBe8B3H8aBzzrIfdp5GD9psg4FVXmS27Ki', 'usuario5@gmail.com', 'public/images/default.jpg', NULL, 'Usuario Cinco', '2000-05-05', 'Argentina', '2024-10-20', 'a', 500770, 0, 0, 3, 1),
(13, 'usuario6', '$2y$10$Fq9ZhU/8qnp1tnpSjD5RBe8B3H8aBzzrIfdp5GD9psg4FVXmS27Ki', 'usuario6@gmail.com', 'public/images/default.jpg', NULL, 'Usuario Seis', '2000-06-06', 'Argentina', '2024-10-20', 'a', 313359, 0, 0, 3, 1),
(14, 'usuario7', '$2y$10$Fq9ZhU/8qnp1tnpSjD5RBe8B3H8aBzzrIfdp5GD9psg4FVXmS27Ki', 'usuario7@gmail.com', 'public/images/default.jpg', NULL, 'Usuario Siete', '2000-07-07', 'Argentina', '2024-10-20', 'a', 864485, 0, 0, 3, 1),
(15, 'usuario8', '$2y$10$Fq9ZhU/8qnp1tnpSjD5RBe8B3H8aBzzrIfdp5GD9psg4FVXmS27Ki', 'usuario8@gmail.com', 'public/images/default.jpg', NULL, 'Usuario Ocho', '2000-08-08', 'Argentina', '2024-10-20', 'a', 582348, 0, 0, 3, 1),
(16, 'usuario9', '$2y$10$Fq9ZhU/8qnp1tnpSjD5RBe8B3H8aBzzrIfdp5GD9psg4FVXmS27Ki', 'usuario9@gmail.com', 'public/images/default.jpg', NULL, 'Usuario Nueve', '2000-09-09', 'Argentina', '2024-10-20', 'a', 218286, 0, 0, 3, 1),
(17, 'usuario10', '$2y$10$Fq9ZhU/8qnp1tnpSjD5RBe8B3H8aBzzrIfdp5GD9psg4FVXmS27Ki', 'usuario10@gmail.com', 'public/images/default.jpg', NULL, 'Usuario Diez', '2000-10-10', 'Argentina', '2024-10-20', 'a', 144385, 0, 0, 3, 1),
(18, 'ivan', '$2y$10$YGQNKdVsgZCt74FKpNlqHevz1SPavnJqZ3udAbfJX1HCICSir6xda', 'ivan@gmail.com', 'public/images/fotoDePerfil/cheems.jpg', NULL, 'Ivan', '1997-04-02', 'Argentina', '2024-10-25', 'a', 312325, 0, 0, 3, 1);

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
  MODIFY `id_partida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `pregunta_partida`
--
ALTER TABLE `pregunta_partida`
  MODIFY `id_pregunta_partida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=296;

--
-- AUTO_INCREMENT de la tabla `pregunta_vista`
--
ALTER TABLE `pregunta_vista`
  MODIFY `id_pregunta_vista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `reporte_pregunta`
--
ALTER TABLE `reporte_pregunta`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id_respuesta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
