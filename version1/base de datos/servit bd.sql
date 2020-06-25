-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2020 a las 16:43:20
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `servit`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alergia`
--

CREATE TABLE `alergia` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alergia`
--

INSERT INTO `alergia` (`id`, `nombre`) VALUES
(1, 'mostaza'),
(2, 'altramuz'),
(3, 'apio'),
(4, 'cacahuetes'),
(5, 'cerealgluten'),
(6, 'crustaceos'),
(7, 'frutossecos'),
(8, 'huevos'),
(9, 'lacteos'),
(10, 'sulfitos'),
(11, 'moluscos'),
(12, 'pescados'),
(13, 'sesamo'),
(14, 'soja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(10) NOT NULL,
  `id_restaurante` int(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `id_restaurante`, `nombre`, `visible`) VALUES
(2, 16, 'Primero', 1),
(4, 16, 'Postre', 1),
(5, 16, 'Segundo', 1),
(7, 16, 'Pizzas', 1),
(8, 40, 'Bocadillos', 1),
(9, 40, 'Hamburguesas', 0),
(10, 40, 'Bebidas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasifica`
--

CREATE TABLE `clasifica` (
  `id_restaurante` int(10) NOT NULL,
  `nombre` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='relación entre restaurantes y etiquetas';

--
-- Volcado de datos para la tabla `clasifica`
--

INSERT INTO `clasifica` (`id_restaurante`, `nombre`) VALUES
(16, 'Española'),
(16, 'Italiana'),
(40, 'Bocadillos'),
(40, 'Española'),
(40, 'Hamburguesas'),
(41, 'Vegetariana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componente_menu`
--

CREATE TABLE `componente_menu` (
  `nombre` varchar(20) NOT NULL,
  `id_menu` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contiene`
--

CREATE TABLE `contiene` (
  `id_menu` int(10) NOT NULL,
  `nombre_componente` varchar(20) NOT NULL,
  `id_producto` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `usuario` varchar(15) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `apellido1` varchar(20) NOT NULL,
  `apellido2` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `rol` varchar(20) NOT NULL,
  `id_restaurante` int(10) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`usuario`, `dni`, `nombre`, `apellido1`, `apellido2`, `password`, `rol`, `id_restaurante`, `visible`) VALUES
('75943944', '75943944Y', 'Laura', 'Jiménez', 'González', '$2y$10$GK1avrQLon8ELBAsP3HBp.NxErD.vUNLQye./VvEW/2f1IbmXGfWW', 'Camarero', 16, 1),
('75943955', '75943955X', 'Fernando', 'Izquierdo', 'Romera', '$2y$10$pxKr59eCHaZtIk.CKlvcWOOGbBpJHOHalZN32U3GgAvkVsSiZqjSS', 'Camarero', 40, 1),
('77993366', '77993366O', 'Alejandro', 'Martínez', 'Fernández', '$2y$10$KsAub7OOSrRojwRyV0HQIOKXAQvmqHgKhcSYrdhWeSkXSnTKuvCOK', 'Camarero', 40, 1),
('88551144', '88551144P', 'María', 'Sánchez', 'Moreno', '$2y$10$XbBRvqyDtzFdg.oMcR1oyunX5Ajn7F9rhKChLXN.uHGCd8/h3JJei', 'Camarero', 40, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiqueta`
--

CREATE TABLE `etiqueta` (
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `etiqueta`
--

INSERT INTO `etiqueta` (`nombre`) VALUES
('Bocadillos'),
('China'),
('Española'),
('Hamburguesas'),
('Italiana'),
('Kebab'),
('Mexicana'),
('Pizza'),
('Sushi'),
('Tailandesa'),
('Vegana'),
('Vegetariana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `id_ingrediente` int(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `id_producto` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ingrediente`
--

INSERT INTO `ingrediente` (`id_ingrediente`, `nombre`, `id_producto`) VALUES
(33, 'pimiento', 14),
(36, 'huevo', 15),
(37, 'jamón', 15),
(38, 'lomo', 16),
(39, 'tomate', 16),
(40, 'lechuga', 16),
(41, 'huevo', 16),
(42, 'mayonesa', 16),
(43, 'pollo', 17),
(44, 'lechuga', 17),
(45, 'tomate', 17),
(46, 'mayonesa', 17),
(47, 'huevo', 17),
(48, 'cerdo', 18),
(49, 'queso', 18),
(50, 'bacon', 18),
(51, 'lechuga', 19),
(52, 'tomate', 19),
(53, 'queso', 19),
(54, 'ternera', 7),
(55, 'salsa de almendras', 7),
(56, 'Emperador', 6),
(57, 'Salsa de perejil', 6),
(58, '4 tipos de queso', 23),
(59, 'Ternera', 24),
(60, 'Bacon', 24),
(61, 'Mostaza', 24),
(62, 'Pollo', 24),
(63, 'leche', 25),
(64, 'arroz', 25),
(65, 'canela', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(10) NOT NULL,
  `id_restaurante` int(10) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(10) NOT NULL,
  `id_restaurante` int(20) NOT NULL,
  `precio` float NOT NULL,
  `id_categoria` int(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `id_restaurante`, `precio`, `id_categoria`, `nombre`, `visible`) VALUES
(6, 16, 16, 5, 'Pescado a la plancha', 0),
(7, 16, 15, 5, 'Carne en salsa', 1),
(14, 16, 5, 2, 'Pimientos asados', 1),
(15, 16, 8, 2, 'Huevos rotos', 1),
(16, 40, 7, 8, 'Bocadillo de lomo', 1),
(17, 40, 7, 8, 'Bocadillo de pollo', 1),
(18, 40, 5, 9, 'Hamburguesa grande', 1),
(19, 40, 5, 9, 'Hamburguesa vegetal', 1),
(20, 40, 2, 10, 'Agua', 1),
(21, 40, 2, 10, 'Tinto de verano', 1),
(22, 40, 2, 10, 'Cerveza', 1),
(23, 16, 10, 7, 'Pizza 4 quesos', 1),
(24, 16, 12, 7, 'Pizza burguer', 1),
(25, 16, 3, 4, 'Arroz con leche', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propietario`
--

CREATE TABLE `propietario` (
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `restaurante` int(20) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL,
  `correo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `propietario`
--

INSERT INTO `propietario` (`nombre`, `apellidos`, `username`, `password`, `restaurante`, `visible`, `correo`) VALUES
('administrador', 'administrador', 'administrador', '$2y$10$6QdAr1Kfq58owFlIJyYeP.ImToCqRHg4On/gkrN26Rb5yFuHTZ8Je', NULL, 0, ''),
('Fernando', 'Izquierdo Romera', 'usuario', '$2y$10$FCll90W4T.41SPLY7vzjl.6OmbRS1PWNYFaPZpDnnY1EMUgt5SjUm', 40, 1, '227fer@gmail.com'),
('Antonio', 'López Alonso', 'usuario2', '$2y$10$TGJJ9eN/W10iBkuDlUVJUOxFQfIsIwtondtOxb9m2v2HT6mE34TE6', 16, 1, '227fer@gmail.com'),
('Olga', 'Blanco Ruíz', 'usuario3', '$2y$10$CcvHD/0X9PWu4b/06JwyXOptrDw74.3BPgtsTO4J7OvMBp.Gl4W9a', 41, 1, '227fer@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurante`
--

CREATE TABLE `restaurante` (
  `id` int(10) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` int(15) NOT NULL,
  `ruta` varchar(100) DEFAULT NULL,
  `provincia` varchar(20) NOT NULL,
  `localidad` varchar(20) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `hora_apertura` time NOT NULL,
  `hora_cierre` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `restaurante`
--

INSERT INTO `restaurante` (`id`, `direccion`, `telefono`, `ruta`, `provincia`, `localidad`, `nombre`, `hora_apertura`, `hora_cierre`) VALUES
(16, 'Calle Sierra Nevada, nº3', 666777888, 'uploads/Restaurante la Luna.jpg', 'Málaga', 'Marbella', 'Restaurante la Luna', '13:30:00', '20:00:00'),
(40, 'Calle La Costa, nº37', 666333999, 'uploads/Bar la Costa.jpg', 'Granada', 'Granada', 'Bar la Costa', '12:00:00', '22:15:00'),
(41, 'Calle Ronda, nº8', 666444111, 'uploads/La rueda.jpg', 'Valencia', 'Benidorm', 'La rueda', '10:00:00', '17:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `numero` int(10) NOT NULL,
  `id_zona` int(10) NOT NULL,
  `estado` int(1) NOT NULL,
  `plazas` int(5) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL,
  `usuario_empleado` varchar(15) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`numero`, `id_zona`, `estado`, `plazas`, `visible`, `usuario_empleado`) VALUES
(1, 4, 2, 3, 0, NULL),
(1, 7, 0, NULL, 0, NULL),
(1, 10, 0, NULL, 1, NULL),
(1, 11, 0, 4, 1, '75943955'),
(1, 12, 0, 3, 1, '75943955'),
(2, 6, 0, NULL, 1, NULL),
(2, 7, 0, NULL, 0, NULL),
(2, 8, 0, NULL, 0, NULL),
(2, 10, 0, NULL, 1, NULL),
(2, 11, 0, NULL, 1, '77993366'),
(2, 12, 0, 2, 1, '75943955'),
(3, 6, 0, NULL, 1, NULL),
(3, 7, 0, NULL, 0, NULL),
(3, 11, 0, 5, 1, '88551144'),
(3, 12, 0, NULL, 1, '88551144'),
(4, 4, 1, NULL, 0, NULL),
(4, 11, 0, NULL, 0, '88551144'),
(4, 12, 0, NULL, 0, NULL),
(5, 4, 0, NULL, 0, NULL),
(5, 11, 0, NULL, 1, NULL),
(5, 12, 0, NULL, 0, NULL),
(6, 4, 0, NULL, 0, NULL),
(6, 11, 0, 2, 1, '77993366');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supone`
--

CREATE TABLE `supone` (
  `id_alergia` int(10) NOT NULL,
  `id_producto` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `supone`
--

INSERT INTO `supone` (`id_alergia`, `id_producto`) VALUES
(1, 24),
(5, 7),
(5, 16),
(5, 17),
(5, 18),
(5, 23),
(5, 24),
(7, 7),
(8, 15),
(8, 16),
(8, 17),
(9, 25),
(12, 6),
(13, 18),
(13, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `provincia` varchar(20) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(20) NOT NULL,
  `anioNacimiento` varchar(20) NOT NULL,
  `rol` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`username`, `password`, `provincia`, `nombre`, `apellidos`, `anioNacimiento`, `rol`) VALUES
('75943917', '$2y$10$S39aY/P/Z4bxuoxIIBngf.CcCtVDQLTfRjkTV6UWYn5Zwyxy6n9iS', '-', 'Fernando', 'Izquierdo Romera', '0', 1),
('75943944', '$2y$10$GK1avrQLon8ELBAsP3HBp.NxErD.vUNLQye./VvEW/2f1IbmXGfWW', '-', 'Laura', 'Jiménez González', '0', 1),
('75943955', '$2y$10$pxKr59eCHaZtIk.CKlvcWOOGbBpJHOHalZN32U3GgAvkVsSiZqjSS', '-', 'Fernando', 'Izquierdo Romera', '0', 1),
('77993366', '$2y$10$KsAub7OOSrRojwRyV0HQIOKXAQvmqHgKhcSYrdhWeSkXSnTKuvCOK', '-', 'Alejandro', 'Martínez Fernández', '0', 1),
('88551144', '$2y$10$XbBRvqyDtzFdg.oMcR1oyunX5Ajn7F9rhKChLXN.uHGCd8/h3JJei', '-', 'María', 'Sánchez Moreno', '0', 1),
('fer', 'fer', 'fer', 'fer', 'fer', '1998', 0),
('pepa', 'pepa', '-', '-', '-', '1998', 1),
('pepe', 'pepe', 'pepe', 'pepe', 'pepe', '1998', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona`
--

CREATE TABLE `zona` (
  `id` int(10) NOT NULL,
  `id_restaurante` int(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `es_barra` tinyint(1) NOT NULL,
  `num_secciones` int(10) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `zona`
--

INSERT INTO `zona` (`id`, `id_restaurante`, `nombre`, `es_barra`, `num_secciones`, `visible`) VALUES
(4, 16, 'Salón 1', 0, 6, 0),
(6, 16, 'barra', 1, 3, 1),
(7, 16, 'hola1', 0, 3, 1),
(8, 16, 'barra 2', 1, 2, 1),
(10, 16, 'barra3', 1, 2, 1),
(11, 40, 'Terraza', 0, 6, 1),
(12, 40, 'Barra', 1, 5, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alergia`
--
ALTER TABLE `alergia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`) USING BTREE,
  ADD KEY `fk_categoria_restaurante` (`id_restaurante`);

--
-- Indices de la tabla `clasifica`
--
ALTER TABLE `clasifica`
  ADD PRIMARY KEY (`id_restaurante`,`nombre`),
  ADD KEY `fk_etiqueta` (`nombre`),
  ADD KEY `fk_restaurante` (`id_restaurante`);

--
-- Indices de la tabla `componente_menu`
--
ALTER TABLE `componente_menu`
  ADD PRIMARY KEY (`nombre`,`id_menu`),
  ADD KEY `fk_componente_menu` (`id_menu`) USING BTREE;

--
-- Indices de la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD PRIMARY KEY (`id_menu`,`nombre_componente`,`id_producto`),
  ADD KEY `fk_menuproductos_componente` (`nombre_componente`),
  ADD KEY `fk_menuproductos_producto` (`id_producto`),
  ADD KEY `fk_menuproductos_menu` (`id_menu`) USING BTREE;

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`usuario`),
  ADD KEY `fk_empleado_restaurante` (`id_restaurante`);

--
-- Indices de la tabla `etiqueta`
--
ALTER TABLE `etiqueta`
  ADD PRIMARY KEY (`nombre`);

--
-- Indices de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`id_ingrediente`),
  ADD KEY `fk_ingrediente_producto` (`id_producto`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `fk_menu_restaurante` (`id_restaurante`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_producto_restaurante` (`id_restaurante`),
  ADD KEY `fk_producto_categoria` (`id_categoria`);

--
-- Indices de la tabla `propietario`
--
ALTER TABLE `propietario`
  ADD PRIMARY KEY (`username`),
  ADD KEY `fk_propietario_restaurante` (`restaurante`);

--
-- Indices de la tabla `restaurante`
--
ALTER TABLE `restaurante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`numero`,`id_zona`),
  ADD KEY `fk_seccion_zona` (`id_zona`),
  ADD KEY `fk_seccion_empleado` (`usuario_empleado`);

--
-- Indices de la tabla `supone`
--
ALTER TABLE `supone`
  ADD PRIMARY KEY (`id_alergia`,`id_producto`),
  ADD KEY `fk_supone_producto` (`id_producto`),
  ADD KEY `fk_supone_alergia` (`id_alergia`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_zona_restaurante` (`id_restaurante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alergia`
--
ALTER TABLE `alergia`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `id_ingrediente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `restaurante`
--
ALTER TABLE `restaurante`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `zona`
--
ALTER TABLE `zona`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `fk_categoria_restaurante` FOREIGN KEY (`id_restaurante`) REFERENCES `restaurante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `clasifica`
--
ALTER TABLE `clasifica`
  ADD CONSTRAINT `fk_etiqueta` FOREIGN KEY (`nombre`) REFERENCES `etiqueta` (`nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_restaurante` FOREIGN KEY (`id_restaurante`) REFERENCES `restaurante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `componente_menu`
--
ALTER TABLE `componente_menu`
  ADD CONSTRAINT `componente_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD CONSTRAINT `fk_menuproductos_componente` FOREIGN KEY (`nombre_componente`) REFERENCES `componente_menu` (`nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_menuproductos_menu` FOREIGN KEY (`id_menu`) REFERENCES `componente_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_menuproductos_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `fk_empleado_restaurante` FOREIGN KEY (`id_restaurante`) REFERENCES `restaurante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD CONSTRAINT `fk_ingrediente_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_menu_restaurante` FOREIGN KEY (`id_restaurante`) REFERENCES `restaurante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_restaurante` FOREIGN KEY (`id_restaurante`) REFERENCES `restaurante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `propietario`
--
ALTER TABLE `propietario`
  ADD CONSTRAINT `fk_propietario_restaurante` FOREIGN KEY (`restaurante`) REFERENCES `restaurante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD CONSTRAINT `fk_seccion_empleado` FOREIGN KEY (`usuario_empleado`) REFERENCES `empleado` (`usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_seccion_zona` FOREIGN KEY (`id_zona`) REFERENCES `zona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `supone`
--
ALTER TABLE `supone`
  ADD CONSTRAINT `fk_supone_alergia` FOREIGN KEY (`id_alergia`) REFERENCES `alergia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_supone_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `zona`
--
ALTER TABLE `zona`
  ADD CONSTRAINT `fk_zona_restaurante` FOREIGN KEY (`id_restaurante`) REFERENCES `restaurante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
