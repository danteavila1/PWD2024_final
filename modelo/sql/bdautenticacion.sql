DROP DATABASE bdautenticacion;

--
-- Base de datos: 'bdautenticacion'
--
CREATE DATABASE bdautenticacion;
USE bdautenticacion;

-- CREACIÓN DE TABLAS
CREATE TABLE usuario (
    idusuario bigint(20) NOT NULL AUTO_INCREMENT,
    usnombre varchar(50) NOT NULL,
    uspass varchar(50) NOT NULL,
    usmail varchar(50) NOT NULL,
    usdeshabilitado timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE rol (
    idrol bigint(20) NOT NULL,
    rodescripcion varchar(50) NOT NULL,
    PRIMARY KEY (`idrol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT;
  
CREATE TABLE usuariorol (
    idusuario bigint(20) NOT NULL,
    idrol bigint(20) NOT NULL,
    FOREIGN KEY (idusuario) REFERENCES usuario(idusuario) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idrol) REFERENCES rol(idrol) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- TABLA COMPRA
CREATE TABLE `compra` (
  `idcompra` bigint(20) NOT NULL,
  `cofecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idusuario` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- TABLE COMPRA ITEM
CREATE TABLE `compraitem` (
  `idcompraitem` bigint(20) UNSIGNED NOT NULL,
  `idproducto` bigint(20) NOT NULL,
  `idcompra` bigint(20) NOT NULL,
  `cicantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- TABLA DE PRODUCTO

CREATE TABLE `producto` (
  `idproducto` bigint(20) NOT NULL,
  `pronombre` varchar(11) NOT NULL,
  `prodetalle` varchar(512) NOT NULL,
  `procantstock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- POBLAMIENTO
INSERT INTO rol (idrol, rodescripcion) VALUES 
(1, 'admin'),
(2, 'deposito'),
(3, 'usuario');

INSERT INTO usuario (usnombre, uspass, usmail, usdeshabilitado) VALUES 
-- TODAS LAS CLAVES SON: NOMBRE EN MINÚSCULA + 123 (pepe123, juan123, etc.)
('pepe', '7edede46f596b580cd10469463987280', 'pepe@gmail.com', '0000-00-00 00:00:00'),
('juan', 'f5737d25829e95b9c234b7fa06af8736', 'juan@gmail.com', '0000-00-00 00:00:00'),
('susana', '842c9034eeeb472b0bc93f3979a0cb42', 'susana@gmail.com', '0000-00-00 00:00:00'),
('alicia', 'b3c301e9a1944dd2d610207da0056377', 'alicia@gmail.com', '0000-00-00 00:00:00'),
('joaquin', '2b80773074c7c7a48b3a9b0aaeac4837', 'joaquin@gmail.com', '0000-00-00 00:00:00');

INSERT INTO usuariorol (idusuario, idrol) VALUES 
(1, 1),
(2, 1),
(3, 2),
(4, 2),
(5, 3);