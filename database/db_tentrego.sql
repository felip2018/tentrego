-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2020 a las 05:03:49
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_tentrego`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atributos`
--

CREATE TABLE `atributos` (
  `id_atributo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `atributos`
--

INSERT INTO `atributos` (`id_atributo`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'COLORES', 'COLOR DEL PRODUCTO', 'Activo'),
(2, 'TALLAS', 'TALLAS DEL PRODUCTO', 'Activo'),
(3, 'GENERO', 'GENERO DEL PUBLICO QUE USARA EL PRODUCTO', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambio_clave`
--

CREATE TABLE `cambio_clave` (
  `id_cambio` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `desde` datetime NOT NULL,
  `hasta` datetime NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`, `fecha`, `estado`) VALUES
(1, 'ROPA Y ACCESORIOS', 'ROPA Y ACCESORIOS DE TODO TIPO', '2018-07-06', 'Activo'),
(2, 'CALZADO', 'CALZADO', '2018-07-06', 'Activo'),
(3, 'BELLEZA', 'CATEGORIA LINEA DE BELLEZA', '2018-07-08', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id_ciudad` int(11) NOT NULL,
  `id_dpto` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasificacion`
--

CREATE TABLE `clasificacion` (
  `id_clasificacion` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clasificacion`
--

INSERT INTO `clasificacion` (`id_clasificacion`, `id_categoria`, `nombre`, `estado`) VALUES
(1, 2, 'TENNIS DEPORTIVOS', 'Activo'),
(2, 1, 'PANTALONES', 'Activo'),
(3, 2, 'TENNIS SKATE', 'Activo'),
(4, 3, 'PLANCHAS', 'Activo'),
(5, 3, 'CEPILLOS', 'Activo'),
(6, 1, 'CHAQUETAS', 'Activo'),
(7, 3, 'PERFUMES Y FRAGANCIAS', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_dpto` int(11) NOT NULL DEFAULT 0,
  `id_pais` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emails`
--

CREATE TABLE `emails` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `asunto` varchar(100) NOT NULL,
  `plantilla` varchar(100) NOT NULL,
  `parametros` varchar(1000) NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_envio` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marca`, `nombre`, `logo`, `estado`) VALUES
(1, 'ADIDAS', 'Adidas_Logo_Flower__83153.1337144903.380.380.jpg', 'Activo'),
(2, 'NIKE', 'logo_nike_principal.jpg', 'Activo'),
(3, 'THE NORTH FACE', 'TheNorthFace_logo.png', 'Activo'),
(4, 'REMINGTON', 'remington.jpg', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` int(11) NOT NULL,
  `envia` int(11) NOT NULL,
  `recibe` int(11) NOT NULL,
  `asunto` varchar(100) NOT NULL,
  `notificacion` varchar(300) NOT NULL,
  `fecha_notificacion` datetime NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id_pais` int(11) NOT NULL,
  `nombre` varchar(20) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL DEFAULT 0,
  `id_usuario` int(11) NOT NULL,
  `codigo_pedido` varchar(128) NOT NULL,
  `total` double NOT NULL,
  `dcto` int(11) NOT NULL,
  `transporte` double NOT NULL,
  `total_pagar` double NOT NULL,
  `observaciones` varchar(1000) NOT NULL COMMENT 'observaciones del pedido',
  `fecha` datetime NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalle`
--

CREATE TABLE `pedido_detalle` (
  `id_pdetalle` int(11) NOT NULL DEFAULT 0,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_promocion` int(11) DEFAULT NULL,
  `valor_unitario` double NOT NULL,
  `cantidad` int(11) NOT NULL,
  `valor_total` double NOT NULL,
  `origen` varchar(45) NOT NULL,
  `recomienda` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id_perfil` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id_perfil`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'ADMINISTRADOR', 'CONTROL GENERAL DE PRODUCTOS, USUARIOS Y PEDIDOS', 'Activo'),
(2, 'ASESOR COMERCIAL', 'REGISTRO DE USUARIOS Y PEDIDOS', 'Activo'),
(3, 'USUARIO', 'CLIENTE FINAL DEL SISTEMA', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `id_clasificacion` int(11) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `costo` double NOT NULL,
  `utilidad` double NOT NULL,
  `venta` double NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `id_clasificacion`, `id_marca`, `id_unidad`, `nombre`, `cantidad`, `imagen`, `descripcion`, `costo`, `utilidad`, `venta`, `fecha`, `estado`) VALUES
(1, 1, 1, 1, 'DRAGON', 1, 'adidas_dragon_rojoazul.jpg', 'UN DISEÃ±O AUDAZ INSPIRADO EN AL ADN DEL RUNNING DE LOS AÃ±OS 70, ESTOS TENIS MANTIENEN VIVO EL ESPÃ­RITU DE LOS DRAGON ORIGINALES. TRAEN UN CÃ³MODO EXTERIOR EN MALLA CON REVESTIMIENTOS EN GAMUZA SINTÃ©TICA Y UNA MEDIASUELA ACOLCHADA DE EVA. EL REFUERZO DE TALÃ³N Y LAS 3 RAYAS EN CUERO SINTÃ©TICO LES PONEN EL TOQUE FINAL.', 90000, 70, 153000, '2018-07-07', 'Activo'),
(2, 1, 1, 1, 'SAMBA', 1, 'adidas_samba.jpg', '', 85000, 50, 127500, '2018-07-07', 'Activo'),
(3, 1, 1, 1, 'GAZELLE', 1, 'adidas_gazelle.jpg', '', 95000, 60, 152000, '2018-07-07', 'Activo'),
(4, 4, 4, 1, 'PLANCHA CABELLO', 1, 'plancha_cabello.jpg', 'PLANCHA CON SENSOR INTELIGENTE\r\nPLACAS DE CERÃ¡MICA DE ÃºLTIMA TECNOLOGÃ­A\r\nLIVIANA, AGRADABE DISEÃ±O Y FÃ¡CIL DE MANEJAR\r\nLISTA PARA USARSE EN 30 SEGUNDOS GRACIAS A SU FUNCIÃ³N TURBO\r\nCABLE GIRATORIO PERMITE TRABAJAR SIN PROBLEMAS', 50000, 70, 85000, '2018-07-08', 'Activo'),
(5, 6, 3, 1, 'CHAQUETA', 1, 'The_North_Face_1hWXi2hc.jpg', '', 90000, 67, 150000, '2018-07-08', 'Activo'),
(6, 1, 1, 1, 'NEO', 1, 'adidas_neo.jpg', 'ADIDAS NEO ULTIMA EDICION', 78000, 100, 156000, '2018-07-23', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_atributo`
--

CREATE TABLE `producto_atributo` (
  `id_atributo` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `valor` varchar(100) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_atributo`
--

INSERT INTO `producto_atributo` (`id_atributo`, `id_producto`, `valor`, `estado`) VALUES
(1, 1, 'VINO TINTO, AZUL, NARANJA', 'Activo'),
(1, 2, 'NEGRO, BLANCO', 'Activo'),
(1, 3, 'NEGRO, BLANCO, VINO TINTO', 'Activo'),
(1, 4, 'ROSA, AZUL', 'Activo'),
(1, 5, 'NEGRO, BLANCO', 'Activo'),
(1, 6, 'NEGRO, BLANCO', 'Activo'),
(2, 1, '40,41', 'Activo'),
(2, 2, '40,41', 'Activo'),
(2, 3, '36,37,38,39,40,41,42', 'Activo'),
(2, 5, 'S,M,L,X,XL', 'Activo'),
(2, 6, '39, 40, 41', 'Activo'),
(3, 1, 'HOMBRE Y MUJER', 'Activo'),
(3, 2, 'HOMBRE', 'Activo'),
(3, 3, 'UNISEX', 'Activo'),
(3, 5, 'HOMBRE', 'Activo'),
(3, 6, 'HOMBRE', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_casos`
--

CREATE TABLE `producto_casos` (
  `id_caso` int(11) NOT NULL DEFAULT 0,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `motivo` varchar(45) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_casos_proceso`
--

CREATE TABLE `producto_casos_proceso` (
  `id_proceso` int(11) NOT NULL DEFAULT 0,
  `id_caso` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_imagenes`
--

CREATE TABLE `producto_imagenes` (
  `id_imagen` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_resena`
--

CREATE TABLE `producto_resena` (
  `id_resena` int(11) NOT NULL DEFAULT 0,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `calificacion` int(11) NOT NULL,
  `comentarios` varchar(1000) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

CREATE TABLE `promociones` (
  `id_promocion` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `venta` double NOT NULL,
  `dcto` int(11) NOT NULL,
  `precio_promo` double NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_identi`
--

CREATE TABLE `tipo_identi` (
  `id_tipo_identi` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_identi`
--

INSERT INTO `tipo_identi` (`id_tipo_identi`, `nombre`, `estado`) VALUES
(1, 'CEDULA DE CIUDADANIA', 'Activo'),
(2, 'CEDULA DE EXTRANEJRIA', 'Activo'),
(3, 'PASAPORTE', 'Activo'),
(4, 'NIT', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id_unidad` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id_unidad`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'U', 'UNIDAD', 'Activo'),
(2, 'GR', 'GRAMO', 'Activo'),
(3, 'LB', 'LIBRA', 'Activo'),
(4, 'KG', 'KILOGRAMO', 'Activo'),
(5, 'ML', 'MILILITRO', 'Activo'),
(6, 'LT', 'LITRO', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_perfil` int(11) NOT NULL,
  `id_tipo_identi` int(11) NOT NULL,
  `num_identi` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `telefono` varchar(100) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `clave` varchar(200) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `intentos` int(11) NOT NULL DEFAULT 0,
  `sesion` varchar(45) NOT NULL,
  `codigo_validacion` varchar(128) NOT NULL,
  `notificaciones` int(1) NOT NULL,
  `terminos_condiciones` int(1) NOT NULL,
  `registrado_por` int(11) DEFAULT NULL,
  `fecha_usuario` datetime NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_perfil`, `id_tipo_identi`, `num_identi`, `nombre`, `apellido`, `email`, `telefono`, `direccion`, `clave`, `foto`, `intentos`, `sesion`, `codigo_validacion`, `notificaciones`, `terminos_condiciones`, `registrado_por`, `fecha_usuario`, `estado`) VALUES
(1, 1, 1, 1069753422, 'MIGUEL FELIPE', 'PEÑUELA GARZON', 'felipegarxon@hotmail.com', '3144352585', 'Cll 61 # 13 - 38 Chapinero', '12', '', 0, 'Desconectado', 'CODIGO', 0, 1, NULL, '2020-11-03 23:15:52', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_direcciones`
--

CREATE TABLE `usuarios_direcciones` (
  `id_direccion` int(11) NOT NULL DEFAULT 0,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `barrio` varchar(100) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `id_dpto` int(11) NOT NULL,
  `id_ciudad` int(11) NOT NULL,
  `indicaciones` varchar(1000) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas_pagina`
--

CREATE TABLE `visitas_pagina` (
  `id_visita` int(11) NOT NULL,
  `origen` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `atributos`
--
ALTER TABLE `atributos`
  ADD PRIMARY KEY (`id_atributo`);

--
-- Indices de la tabla `cambio_clave`
--
ALTER TABLE `cambio_clave`
  ADD PRIMARY KEY (`id_cambio`),
  ADD KEY `FK_cambio_clave_1` (`email`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id_ciudad`),
  ADD KEY `fk_ciudad_departamento1_idx` (`id_dpto`);

--
-- Indices de la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  ADD PRIMARY KEY (`id_clasificacion`),
  ADD KEY `FK_clasificacion_1` (`id_categoria`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_dpto`),
  ADD KEY `fk_departamento_pais1_idx` (`id_pais`);

--
-- Indices de la tabla `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_emails_1` (`email`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `fk_notificaciones_usuarios1_idx` (`envia`),
  ADD KEY `fk_notificaciones_usuarios2_idx` (`recibe`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id_pais`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedido_usuarios1_idx` (`id_usuario`);

--
-- Indices de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD PRIMARY KEY (`id_pdetalle`),
  ADD KEY `FK_pedido_detalle_2` (`id_producto`),
  ADD KEY `fk_pedido_detalle_pedido1_idx` (`id_pedido`),
  ADD KEY `fk_pedido_detalle_promociones1_idx` (`id_promocion`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id_perfil`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `FK_producto_2` (`id_marca`),
  ADD KEY `FK_producto_3` (`id_clasificacion`),
  ADD KEY `fk_producto_unidades1_idx` (`id_unidad`);

--
-- Indices de la tabla `producto_atributo`
--
ALTER TABLE `producto_atributo`
  ADD PRIMARY KEY (`id_atributo`,`id_producto`),
  ADD KEY `fk_producto_atributo_atributos1_idx` (`id_atributo`),
  ADD KEY `fk_producto_atributo_producto1_idx` (`id_producto`);

--
-- Indices de la tabla `producto_casos`
--
ALTER TABLE `producto_casos`
  ADD PRIMARY KEY (`id_caso`),
  ADD KEY `FK_producto_casos_1` (`id_pedido`),
  ADD KEY `FK_producto_casos_2` (`id_producto`);

--
-- Indices de la tabla `producto_casos_proceso`
--
ALTER TABLE `producto_casos_proceso`
  ADD PRIMARY KEY (`id_proceso`),
  ADD KEY `fk_producto_casos_proceso_producto_casos1_idx` (`id_caso`);

--
-- Indices de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `FK_producto_imagenes_1` (`id_producto`);

--
-- Indices de la tabla `producto_resena`
--
ALTER TABLE `producto_resena`
  ADD PRIMARY KEY (`id_resena`),
  ADD KEY `FK_producto_resena_1` (`id_pedido`),
  ADD KEY `FK_producto_resena_2` (`id_producto`),
  ADD KEY `FK_producto_resena_3` (`email`);

--
-- Indices de la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD PRIMARY KEY (`id_promocion`),
  ADD KEY `FK_promociones_1` (`id_producto`);

--
-- Indices de la tabla `tipo_identi`
--
ALTER TABLE `tipo_identi`
  ADD PRIMARY KEY (`id_tipo_identi`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id_unidad`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `FK_usuarios_4` (`id_perfil`),
  ADD KEY `FK_usuarios_2` (`id_tipo_identi`),
  ADD KEY `fk_usuarios_usuarios1_idx` (`registrado_por`);

--
-- Indices de la tabla `usuarios_direcciones`
--
ALTER TABLE `usuarios_direcciones`
  ADD PRIMARY KEY (`id_direccion`),
  ADD KEY `FK_usuarios_direcciones_1` (`email`),
  ADD KEY `FK_usuarios_direcciones_2` (`id_ciudad`,`id_dpto`,`id_pais`);

--
-- Indices de la tabla `visitas_pagina`
--
ALTER TABLE `visitas_pagina`
  ADD PRIMARY KEY (`id_visita`),
  ADD KEY `FK_visitas_pagina_1` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cambio_clave`
--
ALTER TABLE `cambio_clave`
  MODIFY `id_cambio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `promociones`
--
ALTER TABLE `promociones`
  MODIFY `id_promocion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `visitas_pagina`
--
ALTER TABLE `visitas_pagina`
  MODIFY `id_visita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cambio_clave`
--
ALTER TABLE `cambio_clave`
  ADD CONSTRAINT `FK_cambio_clave_1` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`);

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `fk_ciudad_departamento1` FOREIGN KEY (`id_dpto`) REFERENCES `departamento` (`id_dpto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `clasificacion`
--
ALTER TABLE `clasificacion`
  ADD CONSTRAINT `FK_clasificacion_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `fk_departamento_pais1` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id_pais`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `emails`
--
ALTER TABLE `emails`
  ADD CONSTRAINT `FK_emails_1` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `fk_notificaciones_usuarios1` FOREIGN KEY (`envia`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_notificaciones_usuarios2` FOREIGN KEY (`recibe`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_usuarios1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD CONSTRAINT `FK_pedido_detalle_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `fk_pedido_detalle_pedido1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedido_detalle_promociones1` FOREIGN KEY (`id_promocion`) REFERENCES `promociones` (`id_promocion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_producto_2` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`),
  ADD CONSTRAINT `FK_producto_3` FOREIGN KEY (`id_clasificacion`) REFERENCES `clasificacion` (`id_clasificacion`),
  ADD CONSTRAINT `fk_producto_unidades1` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id_unidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto_atributo`
--
ALTER TABLE `producto_atributo`
  ADD CONSTRAINT `fk_producto_atributo_atributos1` FOREIGN KEY (`id_atributo`) REFERENCES `atributos` (`id_atributo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_atributo_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto_casos`
--
ALTER TABLE `producto_casos`
  ADD CONSTRAINT `FK_producto_casos_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `FK_producto_casos_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `producto_casos_proceso`
--
ALTER TABLE `producto_casos_proceso`
  ADD CONSTRAINT `fk_producto_casos_proceso_producto_casos1` FOREIGN KEY (`id_caso`) REFERENCES `producto_casos` (`id_caso`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto_imagenes`
--
ALTER TABLE `producto_imagenes`
  ADD CONSTRAINT `FK_producto_imagenes_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `producto_resena`
--
ALTER TABLE `producto_resena`
  ADD CONSTRAINT `FK_producto_resena_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`),
  ADD CONSTRAINT `FK_producto_resena_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `FK_producto_resena_3` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`);

--
-- Filtros para la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD CONSTRAINT `FK_promociones_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_usuarios_2` FOREIGN KEY (`id_tipo_identi`) REFERENCES `tipo_identi` (`id_tipo_identi`),
  ADD CONSTRAINT `FK_usuarios_4` FOREIGN KEY (`id_perfil`) REFERENCES `perfil` (`id_perfil`),
  ADD CONSTRAINT `fk_usuarios_usuarios1` FOREIGN KEY (`registrado_por`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios_direcciones`
--
ALTER TABLE `usuarios_direcciones`
  ADD CONSTRAINT `FK_usuarios_direcciones_1` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`),
  ADD CONSTRAINT `FK_usuarios_direcciones_2` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudad` (`id_ciudad`);

--
-- Filtros para la tabla `visitas_pagina`
--
ALTER TABLE `visitas_pagina`
  ADD CONSTRAINT `FK_visitas_pagina_1` FOREIGN KEY (`email`) REFERENCES `usuarios` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
