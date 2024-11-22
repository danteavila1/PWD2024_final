-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2024 a las 22:39:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- -----------------------------------------【 BD RÁPIDA 】-----------------------------------------

DROP DATABASE bdcarritocompras;
CREATE DATABASE bdcarritocompras;
USE bdcarritocompras;

-- -----------------------------------------【 CREACIÓN DE TABLAS 】-----------------------------------------

-- --------------------- Estructura tabla `usuario`
CREATE TABLE `usuario` (
  `idusuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `usnombre` varchar(50) NOT NULL,
  `uspass` varchar(50) NOT NULL,
  `usmail` varchar(50) NOT NULL,
  `usdeshabilitado` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------- Estructura tabla `rol`
CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL AUTO_INCREMENT,
  `rodescripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`idrol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------- Estructura tabla `usuariorol`
CREATE TABLE `usuariorol` (
  `idusuario` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL,
  FOREIGN KEY (idusuario) REFERENCES usuario(idusuario) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (idrol) REFERENCES rol(idrol) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------- Estructura tabla `compra`
CREATE TABLE `compra` (
  `idcompra` bigint(20) NOT NULL AUTO_INCREMENT,
  `cofecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idusuario` bigint(20) NOT NULL,
  PRIMARY KEY (`idcompra`),
  FOREIGN KEY (idusuario) REFERENCES usuario(idusuario) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------- Estructura tabla `compraestadotipo`
CREATE TABLE `compraestadotipo` (
  `idcompraestadotipo` int(11) NOT NULL AUTO_INCREMENT,
  `cetdescripcion` varchar(50) NOT NULL,
  `cetdetalle` varchar(256) NOT NULL,
  PRIMARY KEY (`idcompraestadotipo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------- Estructura tabla `compraestado`
CREATE TABLE `compraestado` (
  `idcompraestado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idcompra` bigint(11) NOT NULL,
  `idcompraestadotipo` int(11) NOT NULL,
  `cefechaini` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cefechafin` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idcompraestado`),
  FOREIGN KEY (idcompra) REFERENCES compra(idcompra) ON UPDATE CASCADE,
  FOREIGN KEY (idcompraestadotipo) REFERENCES compraestadotipo(idcompraestadotipo) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------- Estructura tabla `producto`
CREATE TABLE `producto` (
  `idproducto` bigint(20) NOT NULL AUTO_INCREMENT,
  `pronombre` varchar(50) NOT NULL,
  `prodetalle` varchar(512) NOT NULL,
  `proimagen` varchar(200) NOT NULL,
  `procantstock` int(11) NOT NULL,
  PRIMARY KEY (`idproducto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------- Estructura tabla `compraitem`
CREATE TABLE `compraitem` (
  `idcompraitem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idproducto` bigint(20) NOT NULL,
  `idcompra` bigint(20) NOT NULL,
  `cicantidad` int(11) NOT NULL,
  PRIMARY KEY (`idcompraitem`),
  FOREIGN KEY (idproducto) REFERENCES producto(idproducto) ON UPDATE CASCADE,
  FOREIGN KEY (idcompra) REFERENCES compra(idcompra) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------- Estructura tabla `menu`
CREATE TABLE `menu` (
  `idmenu` bigint(20) NOT NULL AUTO_INCREMENT,
  `menombre` varchar(50) NOT NULL COMMENT 'Nombre del item del menu',
  `medescripcion` varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
  `idpadre` bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
  `medeshabilitado` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez',
  PRIMARY KEY (`idmenu`),
  FOREIGN KEY (idpadre) REFERENCES menu(idmenu) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------- Estructura tabla `menurol`
CREATE TABLE `menurol` (
  `idmenu` bigint(20) NOT NULL,
  `idrol` bigint(20) NOT NULL,
  FOREIGN KEY (idmenu) REFERENCES menu(idmenu) ON UPDATE CASCADE,
  FOREIGN KEY (idrol) REFERENCES rol(idrol) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- -----------------------------------------【 POBLAMIENTO 】-----------------------------------------

-- --------------------- Poblamiento tabla `usuario`
INSERT INTO `usuario` (`idusuario`, `usnombre`, `uspass`, `usmail`, `usdeshabilitado`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin@gmail.com', '0000-00-00 00:00:00'), -- admin admin123
(2, 'deposito', '58c583ac2d31e73486f26dccdf560cea', 'deposito@gmail.com', '0000-00-00 00:00:00'), -- deposito deposito123
(3, 'cliente', '7159bbe0c8ca2a67230a26b72dea7557', 'cliente@gmail.com', '0000-00-00 00:00:00'), -- cliente cliente123
(4, 'juan', 'f5737d25829e95b9c234b7fa06af8736', 'juan@gmail.com', '0000-00-00 00:00:00'), -- juan juan123
(5, 'susana', '842c9034eeeb472b0bc93f3979a0cb42', 'susana@gmail.com', '0000-00-00 00:00:00'); -- susana susana123

-- --------------------- Poblamiento tabla `rol`
INSERT INTO `rol` (`idrol`, `rodescripcion`) VALUES
(1, 'admin'),
(2, 'deposito'),
(3, 'cliente');

-- --------------------- Poblamiento tabla `usuariorol`
INSERT INTO `usuariorol` (`idusuario`, `idrol`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 3),
(5, 3);

-- --------------------- Poblamiento tabla `compraestadotipo`
INSERT INTO `compraestadotipo` (`idcompraestadotipo`, `cetdescripcion`, `cetdetalle`) VALUES
(1, 'iniciada', 'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'),
(2, 'aceptada', 'cuando el usuario administrador da ingreso a uno de las compras en estado = 1 '),
(3, 'enviada', 'cuando el usuario administrador envia a uno de las compras en estado =2 '),
(4, 'cancelada', 'un usuario administrador podra cancelar una compra en cualquier estado y un usuario cliente solo en estado=1 ');

-- --------------------- Poblamiento tabla `producto`
INSERT INTO `producto` (`pronombre`, `prodetalle`, `proimagen`, `procantstock`) VALUES
('Té de conejito', 'Un tecito calentito y dulce', 'conejoTesito.jpg', 10),
('Peluche conejo', 'Perfecto para acurrucarse', 'conejo.png', 10),
('Gatito con sombrero', 'El gatito más coqueto', 'gatitoGorro.jpg', 20),
('Gatito con pijama', 'Para dormir como un angelito', 'gatoPijama.jpg', 25),
('Kit peluche + hebillas', 'Estilo y ternura en el mismo lugar', 'kitOsito.jpg', 15),
('Oso con listón', 'Suave y esponjoso', 'osoCinta.jpg', 10),
('Oso rosa', 'Tan rosado que empalaga', 'osoRosa.jpg', 15),
('Oveja con tulipán', 'Flores y ternura, juntas', 'ovejaTulipan.png', 20),
('Pollito', 'El pollito que emana amor', 'pollito.jpg', 25),
('Vaquita frutilla', 'La vaquita más dulce', 'vacaFrutilla.jpg', 10),
('Osita con vestido', 'La osita más coqueta', 'osoConVestido.jpg', 15);

-- -----------------------------------------【 ALTERACIONES 】-----------------------------------------

ALTER TABLE `producto`
ADD COLUMN `proprecio` DECIMAL(10,2) NOT NULL AFTER `procantstock`;

ALTER TABLE `menu`
ADD COLUMN `melink` VARCHAR(50) AFTER `medeshabilitado`;


-- --------------------- Poblamiento tabla `menu`
INSERT INTO `menu` (`idmenu`, `menombre`, `medescripcion`, `idpadre`, `medeshabilitado`,`melink`) VALUES
(1, 'Gestión de usuarios', 'Gestión de usuarios', NULL, NULL,'vista/admin/listarusuario.php'),
(2, 'Gestión de roles', 'Gestión de roles', NULL, NULL,'vista/admin/listarroles.php'),
(3, 'Gestión de productos', 'Gestión de productos', NULL, NULL,'vista/admin/listarproductos.php'),
(4, 'Productos', 'Productos', NULL, NULL,'vista/deposito/productosdeposito.php'),
(5, 'Inicio', 'Inicio', NULL, NULL,'vista/productos.php'),
(6, 'Tienda', 'Tienda', NULL, NULL,'vista/productos.php'),
(7, 'Novedades', 'Novedades', NULL, NULL,'vista/productos.php'),
(8, 'Contacto', 'Contacto', NULL, NULL,'vista/productos.php');

-- --------------------- Poblamiento tabla `menurol`
INSERT INTO `menurol` (`idmenu`, `idrol`) VALUES
(1, 1),(2, 1),(3, 1),(4, 2),(5, 3),(6, 3),(7, 3),(8, 3);

-- --------------------- Poblamiento tabla `compra`
INSERT INTO `compra` (`idcompra`, `cofecha`, `idusuario`) VALUES
(1, '2024-11-01 14:30:00', 3), -- Compra realizada por el usuario 'cliente'
(2, '2024-11-02 16:45:00', 4), -- Compra realizada por el usuario 'juan'
(3, '2024-11-03 10:15:00', 5), -- Compra realizada por el usuario 'susana'
(4, '2024-11-04 18:20:00', 3); -- Otra compra realizada por el usuario 'cliente'

-- --------------------- Poblamiento tabla `compraestado`
INSERT INTO `compraestado` (`idcompraestado`, `idcompra`, `idcompraestadotipo`, `cefechaini`, `cefechafin`) VALUES
(1, 1, 1, '2024-11-01 14:30:00', NULL), -- Compra 1 iniciada
(2, 2, 1, '2024-11-02 16:45:00', NULL), -- Compra 2 iniciada
(3, 3, 1, '2024-11-03 10:15:00', NULL), -- Compra 3 iniciada
(4, 4, 1, '2024-11-04 18:20:00', NULL); -- Compra 4 iniciada

-- --------------------- Poblamiento tabla `compraitem`
INSERT INTO `compraitem` (`idcompraitem`, `idproducto`, `idcompra`, `cicantidad`) VALUES
(1, 1, 1, 2), -- Compra 1 incluye 2 unidades de "Llavero de conejito"
(2, 3, 1, 1), -- Compra 1 incluye 1 unidad de "Kuromi Black"
(3, 2, 2, 3), -- Compra 2 incluye 3 unidades de "Peluche conejo"
(4, 4, 2, 2), -- Compra 2 incluye 2 unidades de "Kuromi Rosa"
(5, 1, 3, 5), -- Compra 3 incluye 5 unidades de "Llavero de conejito"
(6, 4, 3, 1), -- Compra 3 incluye 1 unidad de "Kuromi Rosa"
(7, 3, 4, 2), -- Compra 4 incluye 2 unidades de "Kuromi Black"
(8, 2, 4, 1); -- Compra 4 incluye 1 unidad de "Peluche conejo"

-- --------------------- Poblamiento tabla `producto`
UPDATE `producto` 
SET `proprecio` = 
    CASE `idproducto`
        WHEN 1 THEN 150.00 
        WHEN 2 THEN 300.00
        WHEN 3 THEN 450.00
        WHEN 4 THEN 400.00
        WHEN 5 THEN 250.00 
        WHEN 6 THEN 200.00
        WHEN 7 THEN 320.00
        WHEN 8 THEN 190.00
        WHEN 9 THEN 200.00 
        WHEN 10 THEN 300.00
        WHEN 11 THEN 250.00 
    END;
