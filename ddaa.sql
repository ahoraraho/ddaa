CREATE TABLE `administrador` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cargo` varchar(30) NOT NULL DEFAULT 'Administrador',
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(9) NOT NULL
);

INSERT INTO `administrador` (`nombre`,`apellido`, `cargo`, `direccion`, `telefono`) VALUES
('Alan', 'Codori', 'Administrador', 'Arequipa', '936660120');

CREATE TABLE `especialista` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `DNI` varchar(8) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cargo` varchar(30) NOT NULL DEFAULT 'Especialista',
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(9) NOT NULL
);
/*
INSERT INTO `especialista` (`DNI`, `nombre`, `apellido`, `cargo`,`direccion`, `telefono`) VALUES
('78458968','Juan', 'Pérez', 'Especialista', 'Lima', '123456789');*/

CREATE TABLE `login` (
  `idUsuario` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `rol` int(11) NOT NULL,
  `idAdministrador` int(11) DEFAULT 0,
  `idEspecialista` int(11) DEFAULT 0,
  `Email` varchar(50) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `Activacion` varchar(100) NOT NULL,
  `Estado` tinyint(1) DEFAULT 0,
  `fehcaModificacion` VARCHAR(100) DEFAULT 'No modificado'
  -- FOREIGN KEY (`idAdministrador`) REFERENCES `administrador` (`id`),
  -- FOREIGN KEY (`idEspecialista`) REFERENCES `especialista` (`id`)
);


INSERT INTO `login` (`idUsuario`, `rol`, `idAdministrador`, `idEspecialista`, `Email`, `Pass`, `Activacion`, `Estado`) VALUES
(1, 1, 1, 0, 'admin@da.com', '$2y$11$9bu9o.TQsFTdUTvVwFTCCu5RjC2W6RrWhs1qzkRWgGz0c3qDJsNR6', '2023-05-30 14:46:55', 1);
