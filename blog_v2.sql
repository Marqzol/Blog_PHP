-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2019 a las 16:35:48
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `blog_v2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_publicacion` int(11) NOT NULL,
  `text` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `id_usuario`, `id_publicacion`, `text`, `fecha`) VALUES
(27, 4, 53, ':D', '2019-04-29 13:33:02'),
(28, 4, 5, 'jeje', '2019-04-29 13:33:08'),
(29, 4, 5, 'gfgf', '2019-04-29 13:33:25'),
(30, 4, 5, 'sd', '2019-04-29 13:33:48'),
(31, 4, 46, 'ds', '2019-04-29 13:33:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `text` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id`, `id_usuario`, `text`, `fecha`) VALUES
(5, 3, 'Hola holita vecinillous 👻🙊💋🔌❤️🆚😘😍👍', '2019-04-17 15:24:14'),
(8, 3, 'Este es otro mensaje 🐴🐑🐥🐧', '2019-04-17 15:38:13'),
(39, 3, 'Hola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita vecinillousHola holita', '2019-04-22 13:33:08'),
(41, 3, 'Ahí va otro mensaje 😅😅', '2019-04-23 12:28:10'),
(42, 3, 'ffs fsdfsdfsd', '2019-04-23 12:28:29'),
(43, 3, 'ffsdfsdfsdfsdfsdfsfsdfdsfsd', '2019-04-23 12:28:34'),
(44, 3, 'dsadasdsdsdsdasds', '2019-04-23 15:45:17'),
(45, 3, 'dsdadadasdadadasdasdadasdasdsadasd', '2019-04-23 15:45:22'),
(46, 3, 'vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv', '2019-04-23 15:45:26'),
(47, 3, '5555555555555555555555555555555555555555', '2019-04-23 15:45:29'),
(48, 3, 'dffdfd fdwf w we', '2019-04-23 15:45:32'),
(49, 3, '🏢🏪🏬⛺️⛪️', '2019-04-23 15:45:38'),
(50, 4, 'JAJA LOL 🐸', '2019-04-23 15:52:44'),
(52, 3, 'test 🐸🐸', '2019-04-23 23:26:50'),
(53, 4, '❤️❤️❤️', '2019-04-29 13:30:31'),
(54, 4, 'another', '2019-04-29 13:32:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `image` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `name`, `password`, `email`, `gender`, `birthdate`, `image`) VALUES
(3, 'Tete', '$2y$10$3iooTprCnlywPm406wyMNOom8OpyLyTQnsMyPk04ayDLlXwBCfdZ6', 'tete@tete.es', 'Ewok', '2019-04-01', 'https://i.ytimg.com/vi/VZPdbpX7lF8/maxresdefault.jpg'),
(4, 'Pedrito', '$2y$10$53kJVEWdKOFRSwb8W.9oCuxt3o6PSEUAJ88BSIfd1aOIlQOuR3rCi', 'pedrito@pedrito.es', 'Masculino', '2019-05-24', 'https://qrius.com/wp-content/uploads/2018/06/pepe-the-frog-1272162_1280.jpg'),
(6, 'María', '$2y$10$mppxrFgj2DebrI9yeBdbEeQ78QIcsfamargRtAjUuCN4crQl3Z5PS', 'maria@maria.es', 'Masculino', '2019-04-06', 'Sin especificar');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comentario_usuario` (`id_usuario`),
  ADD KEY `fk_comentario_publi` (`id_publicacion`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_publi_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `fk_comentario_publi` FOREIGN KEY (`id_publicacion`) REFERENCES `publicaciones` (`id`),
  ADD CONSTRAINT `fk_comentario_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `fk_publi_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
