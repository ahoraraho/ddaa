-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2023 at 12:52 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `da`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrador`
--

CREATE TABLE `administrador` (
  `idAdministrador` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cargo` varchar(30) NOT NULL DEFAULT 'Administrador',
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(9) NOT NULL CHECK (octet_length(`telefono`) = 9)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrador`
--

INSERT INTO `administrador` (`idAdministrador`, `nombre`, `apellido`, `cargo`, `direccion`, `telefono`) VALUES
(1, 'Alan Atilio', 'Codori', 'Administrador', 'Arequipa', '936660120');

-- --------------------------------------------------------

--
-- Table structure for table `contacto`
--

CREATE TABLE `contacto` (
  `idContacto` int(11) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `celular` varchar(9) NOT NULL,
  `cargo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `documentos`
--

CREATE TABLE `documentos` (
  `idDocumento` int(11) NOT NULL,
  `acta_de_recepcion` longblob DEFAULT NULL,
  `resolucion_de_obra` longblob DEFAULT NULL,
  `resolucion_deductivos` longblob DEFAULT NULL,
  `resolucion_adicionales` longblob DEFAULT NULL,
  `anexo_de_promesa_de_consorcio` longblob DEFAULT NULL,
  `constancia` longblob DEFAULT NULL,
  `contrato_de_consorcio` longblob DEFAULT NULL,
  `contrato` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `idEmpresa` int(11) NOT NULL,
  `nombreEmpresa` varchar(100) NOT NULL,
  `ruc` varchar(11) NOT NULL,
  `telefono` varchar(9) NOT NULL CHECK (octet_length(`telefono`) = 9),
  `email` varchar(50) NOT NULL,
  `numeroPartida` varchar(8) NOT NULL,
  `mipe` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `empresa_proceso`
--

CREATE TABLE `empresa_proceso` (
  `idEmpresa` int(11) NOT NULL,
  `numProceso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `especialidad`
--

CREATE TABLE `especialidad` (
  `idEspecialidad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `especialista`
--

CREATE TABLE `especialista` (
  `idEspecialista` int(11) NOT NULL,
  `dni` varchar(8) NOT NULL CHECK (octet_length(`dni`) = 8),
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cargo` varchar(30) NOT NULL DEFAULT 'Especialista',
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(9) NOT NULL CHECK (octet_length(`telefono`) = 9)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `idUsuario` int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  `idAdministrador` int(11) DEFAULT NULL,
  `idEspecialista` int(11) DEFAULT NULL,
  `Email` varchar(50) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Activacion` datetime NOT NULL,
  `Estado` tinyint(1) DEFAULT 0,
  `fechaModificacionPass` datetime DEFAULT NULL,
  `fechaModificacionData` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`idUsuario`, `rol`, `idAdministrador`, `idEspecialista`, `Email`, `Contrasena`, `Activacion`, `Estado`, `fechaModificacionPass`, `fechaModificacionData`) VALUES
(1, 1, 1, NULL, 'admin@da.com', '$2y$11$8zACYbl4d3PGpLIgIlEnzOuKCvhtTk9FG5AfyIsZXSRg62WK19NJ2', '2023-05-30 14:46:55', 1, '2023-06-02 17:44:09', '2023-06-02 17:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `objeto`
--

CREATE TABLE `objeto` (
  `idObjeto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `procesos`
--

CREATE TABLE `procesos` (
  `numProceso` int(11) NOT NULL,
  `entidad` varchar(100) NOT NULL,
  `nomenclatura` varchar(100) NOT NULL,
  `nombreClave` varchar(255) NOT NULL,
  `consultas` datetime DEFAULT NULL,
  `integracion` datetime DEFAULT NULL,
  `presentacion` datetime DEFAULT NULL,
  `buenaPro` datetime DEFAULT NULL,
  `valorReferencial` varchar(255) NOT NULL,
  `postores` int(11) NOT NULL,
  `encargado` int(11) NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `proyectos`
--

CREATE TABLE `proyectos` (
  `idProyecto` int(11) NOT NULL,
  `nombre_empresa` int(11) NOT NULL,
  `nombre_proyecto` varchar(100) NOT NULL,
  `numero_contrato` varchar(255) NOT NULL,
  `entidad` varchar(255) NOT NULL,
  `fecha_firma` datetime NOT NULL,
  `monto_contrato_original` decimal(20,2) NOT NULL,
  `porcentaje_de_participacion` decimal(20,2) NOT NULL,
  `adicionales_de_la_obra` decimal(20,2) NOT NULL,
  `deductivos_de_obra` decimal(20,2) NOT NULL,
  `monto_final_del_contrato` decimal(20,2) NOT NULL,
  `miembro_del_consorcio` int(11) NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `contacto` int(11) NOT NULL,
  `objeto` int(11) NOT NULL,
  `especialidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `proyectos_documentos`
--

CREATE TABLE `proyectos_documentos` (
  `idProyecto` int(11) NOT NULL,
  `idDocumento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`idAdministrador`);

--
-- Indexes for table `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`idContacto`);

--
-- Indexes for table `documentos`
--
ALTER TABLE `documentos`
  ADD PRIMARY KEY (`idDocumento`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idEmpresa`);

--
-- Indexes for table `empresa_proceso`
--
ALTER TABLE `empresa_proceso`
  ADD KEY `idEmpresa` (`idEmpresa`),
  ADD KEY `numProceso` (`numProceso`);

--
-- Indexes for table `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`idEspecialidad`);

--
-- Indexes for table `especialista`
--
ALTER TABLE `especialista`
  ADD PRIMARY KEY (`idEspecialista`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idAdministrador` (`idAdministrador`),
  ADD KEY `idEspecialista` (`idEspecialista`);

--
-- Indexes for table `objeto`
--
ALTER TABLE `objeto`
  ADD PRIMARY KEY (`idObjeto`);

--
-- Indexes for table `procesos`
--
ALTER TABLE `procesos`
  ADD PRIMARY KEY (`numProceso`),
  ADD KEY `postores` (`postores`),
  ADD KEY `encargado` (`encargado`);

--
-- Indexes for table `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`idProyecto`),
  ADD KEY `nombre_empresa` (`nombre_empresa`),
  ADD KEY `contacto` (`contacto`),
  ADD KEY `objeto` (`objeto`),
  ADD KEY `especialidad` (`especialidad`);

--
-- Indexes for table `proyectos_documentos`
--
ALTER TABLE `proyectos_documentos`
  ADD KEY `idProyecto` (`idProyecto`),
  ADD KEY `idDocumento` (`idDocumento`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrador`
--
ALTER TABLE `administrador`
  MODIFY `idAdministrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacto`
--
ALTER TABLE `contacto`
  MODIFY `idContacto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documentos`
--
ALTER TABLE `documentos`
  MODIFY `idDocumento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idEmpresa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `idEspecialidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `especialista`
--
ALTER TABLE `especialista`
  MODIFY `idEspecialista` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `objeto`
--
ALTER TABLE `objeto`
  MODIFY `idObjeto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `procesos`
--
ALTER TABLE `procesos`
  MODIFY `numProceso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `idProyecto` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `empresa_proceso`
--
ALTER TABLE `empresa_proceso`
  ADD CONSTRAINT `empresa_proceso_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`),
  ADD CONSTRAINT `empresa_proceso_ibfk_2` FOREIGN KEY (`numProceso`) REFERENCES `procesos` (`numProceso`);

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`idAdministrador`) REFERENCES `administrador` (`idAdministrador`),
  ADD CONSTRAINT `login_ibfk_2` FOREIGN KEY (`idEspecialista`) REFERENCES `especialista` (`idEspecialista`);

--
-- Constraints for table `procesos`
--
ALTER TABLE `procesos`
  ADD CONSTRAINT `procesos_ibfk_1` FOREIGN KEY (`postores`) REFERENCES `empresa` (`idEmpresa`),
  ADD CONSTRAINT `procesos_ibfk_2` FOREIGN KEY (`encargado`) REFERENCES `especialista` (`idEspecialista`);

--
-- Constraints for table `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`nombre_empresa`) REFERENCES `empresa` (`idEmpresa`),
  ADD CONSTRAINT `proyectos_ibfk_2` FOREIGN KEY (`contacto`) REFERENCES `contacto` (`idContacto`),
  ADD CONSTRAINT `proyectos_ibfk_3` FOREIGN KEY (`objeto`) REFERENCES `objeto` (`idObjeto`),
  ADD CONSTRAINT `proyectos_ibfk_4` FOREIGN KEY (`especialidad`) REFERENCES `especialidad` (`idEspecialidad`);

--
-- Constraints for table `proyectos_documentos`
--
ALTER TABLE `proyectos_documentos`
  ADD CONSTRAINT `proyectos_documentos_ibfk_1` FOREIGN KEY (`idProyecto`) REFERENCES `proyectos` (`idProyecto`),
  ADD CONSTRAINT `proyectos_documentos_ibfk_2` FOREIGN KEY (`idDocumento`) REFERENCES `documentos` (`idDocumento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
