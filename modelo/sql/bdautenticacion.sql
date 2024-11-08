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

CREATE TABLE usuariorol (
    idusuario bigint(20) NOT NULL,
    idrol bigint(20) NOT NULL,
    FOREIGN KEY (idusuario) REFERENCES usuario(idusuario) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idrol) REFERENCES rol(idrol) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- POBLAMIENTO
INSERT INTO rol (idrol, rodescripcion) VALUES 
(1, 'admin'),
(2, 'usuario');

INSERT INTO usuario (usnombre, uspass, usmail, usdeshabilitado) VALUES 
-- TODAS LAS CLAVES SON: NOMBRE EN MINÚSCULA + 123 (pepe123, juan123, etc.)
('pepe', '7edede46f596b580cd10469463987280', 'pepe@gmail.com', NULL),
('juan', 'f5737d25829e95b9c234b7fa06af8736', 'juan@gmail.com', NULL),
('susana', '842c9034eeeb472b0bc93f3979a0cb42', 'susana@gmail.com', NULL),
('alicia', 'b3c301e9a1944dd2d610207da0056377', 'alicia@gmail.com', NULL),
('joaquin', '2b80773074c7c7a48b3a9b0aaeac4837', 'joaquin@gmail.com', NULL);

INSERT INTO usuariorol (idusuario, idrol) VALUES 
(1, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 1);