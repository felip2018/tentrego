-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema db_tentrego
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_tentrego
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_tentrego` DEFAULT CHARACTER SET utf8mb4 ;
USE `db_tentrego` ;

-- -----------------------------------------------------
-- Table `db_tentrego`.`atributos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`atributos` (
  `id_atributo` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(100) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_atributo`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`tipo_identi`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`tipo_identi` (
  `id_tipo_identi` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_tipo_identi`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`perfil`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`perfil` (
  `id_perfil` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(100) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_perfil`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `id_perfil` INT(11) NOT NULL,
  `id_tipo_identi` INT(11) NOT NULL,
  `num_identi` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL DEFAULT '',
  `telefono` VARCHAR(100) NOT NULL,
  `direccion` VARCHAR(500) NOT NULL,
  `clave` VARCHAR(200) NOT NULL,
  `foto` VARCHAR(100) NOT NULL,
  `intentos` INT(11) NOT NULL DEFAULT 0,
  `sesion` VARCHAR(45) NOT NULL,
  `codigo_validacion` VARCHAR(128) NOT NULL,
  `notificaciones` INT(1) NOT NULL,
  `terminos_condiciones` INT(1) NOT NULL,
  `registrado_por` INT NULL,
  `fecha_usuario` DATETIME NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  INDEX `FK_usuarios_4` (`id_perfil` ASC),
  INDEX `FK_usuarios_2` (`id_tipo_identi` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  PRIMARY KEY (`id_usuario`),
  INDEX `fk_usuarios_usuarios1_idx` (`registrado_por` ASC),
  CONSTRAINT `FK_usuarios_2`
    FOREIGN KEY (`id_tipo_identi`)
    REFERENCES `db_tentrego`.`tipo_identi` (`id_tipo_identi`),
  CONSTRAINT `FK_usuarios_4`
    FOREIGN KEY (`id_perfil`)
    REFERENCES `db_tentrego`.`perfil` (`id_perfil`),
  CONSTRAINT `fk_usuarios_usuarios1`
    FOREIGN KEY (`registrado_por`)
    REFERENCES `db_tentrego`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`cambio_clave`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`cambio_clave` (
  `id_cambio` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `codigo` VARCHAR(100) NOT NULL,
  `desde` DATETIME NOT NULL,
  `hasta` DATETIME NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_cambio`),
  INDEX `FK_cambio_clave_1` (`email` ASC),
  CONSTRAINT `FK_cambio_clave_1`
    FOREIGN KEY (`email`)
    REFERENCES `db_tentrego`.`usuarios` (`email`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`categorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`categorias` (
  `id_categoria` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(100) NOT NULL,
  `fecha` DATE NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_categoria`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`pais`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`pais` (
  `id_pais` INT(11) NOT NULL,
  `nombre` VARCHAR(20) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`id_pais`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `db_tentrego`.`departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`departamento` (
  `id_dpto` INT(11) NOT NULL DEFAULT 0,
  `id_pais` INT(11) NOT NULL,
  `nombre` VARCHAR(20) NOT NULL,
  `descripcion` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_dpto`),
  INDEX `fk_departamento_pais1_idx` (`id_pais` ASC),
  CONSTRAINT `fk_departamento_pais1`
    FOREIGN KEY (`id_pais`)
    REFERENCES `db_tentrego`.`pais` (`id_pais`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`ciudad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`ciudad` (
  `id_ciudad` INT(11) NOT NULL,
  `id_dpto` INT(11) NOT NULL,
  `nombre` VARCHAR(20) NOT NULL,
  `descripcion` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_ciudad`),
  INDEX `fk_ciudad_departamento1_idx` (`id_dpto` ASC),
  CONSTRAINT `fk_ciudad_departamento1`
    FOREIGN KEY (`id_dpto`)
    REFERENCES `db_tentrego`.`departamento` (`id_dpto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`clasificacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`clasificacion` (
  `id_clasificacion` INT(11) NOT NULL,
  `id_categoria` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_clasificacion`),
  INDEX `FK_clasificacion_1` (`id_categoria` ASC),
  CONSTRAINT `FK_clasificacion_1`
    FOREIGN KEY (`id_categoria`)
    REFERENCES `db_tentrego`.`categorias` (`id_categoria`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`emails`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`emails` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(100) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `asunto` VARCHAR(100) NOT NULL,
  `plantilla` VARCHAR(100) NOT NULL,
  `parametros` VARCHAR(1000) NOT NULL,
  `estado` INT(11) NOT NULL,
  `fecha_registro` DATETIME NOT NULL,
  `fecha_envio` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `FK_emails_1` (`email` ASC),
  CONSTRAINT `FK_emails_1`
    FOREIGN KEY (`email`)
    REFERENCES `db_tentrego`.`usuarios` (`email`))
ENGINE = InnoDB
AUTO_INCREMENT = 30
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`marcas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`marcas` (
  `id_marca` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `logo` VARCHAR(100) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_marca`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`notificaciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`notificaciones` (
  `id_notificacion` INT(11) NOT NULL AUTO_INCREMENT,
  `envia` INT NOT NULL,
  `recibe` INT NOT NULL,
  `asunto` VARCHAR(100) NOT NULL,
  `notificacion` VARCHAR(300) NOT NULL,
  `fecha_notificacion` DATETIME NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_notificacion`),
  INDEX `fk_notificaciones_usuarios1_idx` (`envia` ASC),
  INDEX `fk_notificaciones_usuarios2_idx` (`recibe` ASC),
  CONSTRAINT `fk_notificaciones_usuarios1`
    FOREIGN KEY (`envia`)
    REFERENCES `db_tentrego`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_notificaciones_usuarios2`
    FOREIGN KEY (`recibe`)
    REFERENCES `db_tentrego`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`pedido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`pedido` (
  `id_pedido` INT(11) NOT NULL DEFAULT 0,
  `id_usuario` INT NOT NULL,
  `codigo_pedido` VARCHAR(128) NOT NULL,
  `total` DOUBLE NOT NULL,
  `dcto` INT NOT NULL,
  `transporte` DOUBLE NOT NULL,
  `total_pagar` DOUBLE NOT NULL,
  `observaciones` VARCHAR(1000) NOT NULL COMMENT 'observaciones del pedido',
  `fecha` DATETIME NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_pedido`),
  INDEX `fk_pedido_usuarios1_idx` (`id_usuario` ASC),
  CONSTRAINT `fk_pedido_usuarios1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `db_tentrego`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`unidades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`unidades` (
  `id_unidad` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_unidad`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`producto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`producto` (
  `id_producto` INT(11) NOT NULL,
  `id_clasificacion` INT(11) NOT NULL,
  `id_marca` INT(11) NOT NULL,
  `id_unidad` INT(11) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `imagen` VARCHAR(100) NOT NULL,
  `descripcion` VARCHAR(1000) NOT NULL,
  `costo` DOUBLE NOT NULL,
  `utilidad` DOUBLE NOT NULL,
  `venta` DOUBLE NOT NULL,
  `fecha` DATE NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_producto`),
  INDEX `FK_producto_2` (`id_marca` ASC),
  INDEX `FK_producto_3` (`id_clasificacion` ASC),
  INDEX `fk_producto_unidades1_idx` (`id_unidad` ASC),
  CONSTRAINT `FK_producto_2`
    FOREIGN KEY (`id_marca`)
    REFERENCES `db_tentrego`.`marcas` (`id_marca`),
  CONSTRAINT `FK_producto_3`
    FOREIGN KEY (`id_clasificacion`)
    REFERENCES `db_tentrego`.`clasificacion` (`id_clasificacion`),
  CONSTRAINT `fk_producto_unidades1`
    FOREIGN KEY (`id_unidad`)
    REFERENCES `db_tentrego`.`unidades` (`id_unidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`promociones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`promociones` (
  `id_promocion` INT(11) NOT NULL AUTO_INCREMENT,
  `id_producto` INT(11) NOT NULL,
  `venta` DOUBLE NOT NULL,
  `dcto` INT(11) NOT NULL,
  `precio_promo` DOUBLE NOT NULL,
  `fecha` DATE NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_promocion`),
  INDEX `FK_promociones_1` (`id_producto` ASC),
  CONSTRAINT `FK_promociones_1`
    FOREIGN KEY (`id_producto`)
    REFERENCES `db_tentrego`.`producto` (`id_producto`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`pedido_detalle`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`pedido_detalle` (
  `id_pdetalle` INT(11) NOT NULL DEFAULT 0,
  `id_pedido` INT(11) NOT NULL,
  `id_producto` INT(11) NOT NULL,
  `id_promocion` INT(11) NULL,
  `valor_unitario` DOUBLE NOT NULL,
  `cantidad` INT(11) NOT NULL,
  `valor_total` DOUBLE NOT NULL,
  `origen` VARCHAR(45) NOT NULL,
  `recomienda` VARCHAR(100) NOT NULL,
  `fecha` DATE NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_pdetalle`),
  INDEX `FK_pedido_detalle_2` (`id_producto` ASC),
  INDEX `fk_pedido_detalle_pedido1_idx` (`id_pedido` ASC),
  INDEX `fk_pedido_detalle_promociones1_idx` (`id_promocion` ASC),
  CONSTRAINT `FK_pedido_detalle_2`
    FOREIGN KEY (`id_producto`)
    REFERENCES `db_tentrego`.`producto` (`id_producto`),
  CONSTRAINT `fk_pedido_detalle_pedido1`
    FOREIGN KEY (`id_pedido`)
    REFERENCES `db_tentrego`.`pedido` (`id_pedido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_detalle_promociones1`
    FOREIGN KEY (`id_promocion`)
    REFERENCES `db_tentrego`.`promociones` (`id_promocion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`producto_atributo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`producto_atributo` (
  `id_atributo` INT(11) NOT NULL,
  `id_producto` INT(11) NOT NULL,
  `valor` VARCHAR(100) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  INDEX `fk_producto_atributo_atributos1_idx` (`id_atributo` ASC),
  INDEX `fk_producto_atributo_producto1_idx` (`id_producto` ASC),
  PRIMARY KEY (`id_atributo`, `id_producto`),
  CONSTRAINT `fk_producto_atributo_atributos1`
    FOREIGN KEY (`id_atributo`)
    REFERENCES `db_tentrego`.`atributos` (`id_atributo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_atributo_producto1`
    FOREIGN KEY (`id_producto`)
    REFERENCES `db_tentrego`.`producto` (`id_producto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`producto_casos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`producto_casos` (
  `id_caso` INT(11) NOT NULL DEFAULT 0,
  `id_pedido` INT(11) NOT NULL,
  `id_producto` INT(11) NOT NULL,
  `motivo` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(1000) NOT NULL,
  `fecha` DATE NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_caso`),
  INDEX `FK_producto_casos_1` (`id_pedido` ASC),
  INDEX `FK_producto_casos_2` (`id_producto` ASC),
  CONSTRAINT `FK_producto_casos_1`
    FOREIGN KEY (`id_pedido`)
    REFERENCES `db_tentrego`.`pedido` (`id_pedido`),
  CONSTRAINT `FK_producto_casos_2`
    FOREIGN KEY (`id_producto`)
    REFERENCES `db_tentrego`.`producto` (`id_producto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`producto_casos_proceso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`producto_casos_proceso` (
  `id_proceso` INT(11) NOT NULL DEFAULT 0,
  `id_caso` INT(11) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(1000) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `fecha` DATETIME NOT NULL,
  PRIMARY KEY (`id_proceso`),
  INDEX `fk_producto_casos_proceso_producto_casos1_idx` (`id_caso` ASC),
  CONSTRAINT `fk_producto_casos_proceso_producto_casos1`
    FOREIGN KEY (`id_caso`)
    REFERENCES `db_tentrego`.`producto_casos` (`id_caso`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`producto_imagenes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`producto_imagenes` (
  `id_imagen` INT(11) NOT NULL AUTO_INCREMENT,
  `id_producto` INT(11) NOT NULL,
  `imagen` VARCHAR(100) NOT NULL,
  `fecha` DATE NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_imagen`),
  INDEX `FK_producto_imagenes_1` (`id_producto` ASC),
  CONSTRAINT `FK_producto_imagenes_1`
    FOREIGN KEY (`id_producto`)
    REFERENCES `db_tentrego`.`producto` (`id_producto`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`producto_resena`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`producto_resena` (
  `id_resena` INT(11) NOT NULL DEFAULT 0,
  `id_pedido` INT(11) NOT NULL,
  `id_producto` INT(11) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `calificacion` INT(11) NOT NULL,
  `comentarios` VARCHAR(1000) NOT NULL,
  `fecha` DATETIME NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_resena`),
  INDEX `FK_producto_resena_1` (`id_pedido` ASC),
  INDEX `FK_producto_resena_2` (`id_producto` ASC),
  INDEX `FK_producto_resena_3` (`email` ASC),
  CONSTRAINT `FK_producto_resena_1`
    FOREIGN KEY (`id_pedido`)
    REFERENCES `db_tentrego`.`pedido` (`id_pedido`),
  CONSTRAINT `FK_producto_resena_2`
    FOREIGN KEY (`id_producto`)
    REFERENCES `db_tentrego`.`producto` (`id_producto`),
  CONSTRAINT `FK_producto_resena_3`
    FOREIGN KEY (`email`)
    REFERENCES `db_tentrego`.`usuarios` (`email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`usuarios_direcciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`usuarios_direcciones` (
  `id_direccion` INT(11) NOT NULL DEFAULT 0,
  `email` VARCHAR(100) NOT NULL,
  `telefono` VARCHAR(50) NOT NULL,
  `direccion` VARCHAR(100) NOT NULL,
  `barrio` VARCHAR(100) NOT NULL,
  `id_pais` INT(11) NOT NULL,
  `id_dpto` INT(11) NOT NULL,
  `id_ciudad` INT(11) NOT NULL,
  `indicaciones` VARCHAR(1000) NOT NULL,
  `fecha` DATE NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_direccion`),
  INDEX `FK_usuarios_direcciones_1` (`email` ASC),
  INDEX `FK_usuarios_direcciones_2` (`id_ciudad` ASC, `id_dpto` ASC, `id_pais` ASC),
  CONSTRAINT `FK_usuarios_direcciones_1`
    FOREIGN KEY (`email`)
    REFERENCES `db_tentrego`.`usuarios` (`email`),
  CONSTRAINT `FK_usuarios_direcciones_2`
    FOREIGN KEY (`id_ciudad`)
    REFERENCES `db_tentrego`.`ciudad` (`id_ciudad`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `db_tentrego`.`visitas_pagina`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_tentrego`.`visitas_pagina` (
  `id_visita` INT(11) NOT NULL AUTO_INCREMENT,
  `origen` VARCHAR(45) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `fecha` DATE NOT NULL,
  `cantidad` INT(11) NOT NULL,
  PRIMARY KEY (`id_visita`),
  INDEX `FK_visitas_pagina_1` (`email` ASC),
  CONSTRAINT `FK_visitas_pagina_1`
    FOREIGN KEY (`email`)
    REFERENCES `db_tentrego`.`usuarios` (`email`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
