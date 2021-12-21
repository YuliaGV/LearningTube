-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2021 a las 00:49:11
-- Versión del servidor: 8.0.23
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_learning`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `cat_id` int NOT NULL,
  `cat_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(1, 'Programación'),
(2, 'Matemáticas'),
(3, 'Física'),
(4, 'Química');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `comment_id` int NOT NULL,
  `users_user_id` int NOT NULL,
  `videos_video_id` int NOT NULL,
  `comment_mensaje` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `user_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_email` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_photo` varchar(200) DEFAULT NULL,
  `user_password` varchar(150) NOT NULL,
  `user_ip` varchar(30) NOT NULL,
  `user_last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `user_date`, `user_email`, `user_name`, `user_photo`, `user_password`, `user_ip`, `user_last_login`) VALUES
(4, '2021-05-17 18:47:56', 'left1308@gmail.com', 'YulianaGV', '8762-IMG0667A.jpg', 'a80fbbc96d87c718fa187edec9653aa69bdb4ebe', '::1', '2021-06-01 17:25:16'),
(5, '2021-06-01 22:09:43', 'tecnologiasedu2017@gmail.com', 'Daniel García', 'ProfileImageDefault.PNG', '7c222fb2927d828af22f592134e8932480637c0d', '::1', '2021-06-02 00:09:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videos`
--

CREATE TABLE `videos` (
  `video_id` int NOT NULL,
  `users_user_id` int NOT NULL,
  `categories_cat_id` int NOT NULL,
  `video_date` datetime NOT NULL,
  `video_title` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `video_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `videos`
--

INSERT INTO `videos` (`video_id`, `users_user_id`, `categories_cat_id`, `video_date`, `video_title`, `video_url`) VALUES
(3, 4, 1, '2021-06-01 04:03:30', 'Python: primeros pasos', '9521-AprendePython.mp4'),
(5, 4, 2, '2021-06-01 23:46:31', 'Ecuaciones de primer grado', '1837-EcuacionesPrimerGrado.mp4'),
(6, 5, 3, '2021-06-02 00:12:55', 'Movimiento Rectilíneo Uniforme', '5423-Movimiento Rectilíneo Uniforme (MRU) _ Características, gráficas, análisis y fórmulas.mp4');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `fk_comments_users1_idx` (`users_user_id`),
  ADD KEY `fk_comments_videos1_idx` (`videos_video_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`video_id`),
  ADD KEY `fk_videos_categories_idx` (`categories_cat_id`),
  ADD KEY `fk_videos_users1_idx` (`users_user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `videos`
--
ALTER TABLE `videos`
  MODIFY `video_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_users1` FOREIGN KEY (`users_user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_comments_videos1` FOREIGN KEY (`videos_video_id`) REFERENCES `videos` (`video_id`);

--
-- Filtros para la tabla `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `fk_videos_categories` FOREIGN KEY (`categories_cat_id`) REFERENCES `categories` (`cat_id`),
  ADD CONSTRAINT `fk_videos_users1` FOREIGN KEY (`users_user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
