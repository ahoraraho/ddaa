CREATE TABLE `administrador` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `cargo` varchar(100) NOT NULL DEFAULT 'Administrador',
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(30) NOT NULL
);

INSERT INTO `administrador` (`nombre`,`apellido`, `cargo`, `direccion`, `telefono`) VALUES
('Alan', 'Codori', 'Administrador', 'Arequipa', '936660120');

CREATE TABLE `especialista` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `DNI` varchar(8) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `cargo` varchar(50) NOT NULL DEFAULT 'Especialista',
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(9) NOT NULL
);

INSERT INTO `especialista` (`DNI`, `nombre`, `apellido`, `cargo`,`direccion`, `telefono`) VALUES
('78458968','Juan', 'Pérez', 'Especialista', 'Lima', '123456789');

CREATE TABLE `login` (
  `idUsuario` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `rol` int(11) NOT NULL,
  `idAdministrador` int(11) DEFAULT 0,
  `idEspecialista` int(11) DEFAULT 0,
  `Email` varchar(30) NOT NULL,
  `Pass` varchar(255) NOT NULL,
  `Activacion` text NOT NULL,
  `Estado` tinyint(1) DEFAULT 0
  -- FOREIGN KEY (`idAdministrador`) REFERENCES `administrador` (`id`),
  -- FOREIGN KEY (`idEspecialista`) REFERENCES `especialista` (`id`)
);


INSERT INTO `login` (`idUsuario`, `rol`, `idAdministrador`, `idEspecialista`, `Email`, `Pass`, `Activacion`, `Estado`) VALUES
(1, 1, 1, 0, 'admin@da.com', '$2y$11$lEFx8V.h4fDJXygPhmMci.H2C2Qwesxq2DpKgv.MFZ/7PDabR1u2W', '', 1);
