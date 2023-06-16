CREATE TABLE administrador (
    idAdministrador INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cargo VARCHAR(30) NOT NULL DEFAULT 'Administrador',
    direccion VARCHAR(100) NOT NULL,
    telefono VARCHAR(9) NOT NULL CHECK (LENGTH(telefono) = 9)
);

CREATE TABLE especialista (
    idEspecialista INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    dni VARCHAR(8) NOT NULL CHECK (LENGTH(dni) = 8),
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    cargo VARCHAR(30) NOT NULL DEFAULT 'Especialista',
    direccion VARCHAR(100) NOT NULL,
    telefono VARCHAR(9) NOT NULL CHECK (LENGTH(telefono) = 9)
);

CREATE TABLE login (
    idUsuario INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    rol INT(11) NOT NULL,
    idAdministrador INT(11) DEFAULT NULL,
    idEspecialista INT(11) DEFAULT NULL,
    Email VARCHAR(50) NOT NULL,
    Contrasena VARCHAR(255) NOT NULL,
    Activacion DATETIME NOT NULL,
    Estado tinyint(1) DEFAULT 0,
    fechaModificacionPass DATETIME DEFAULT NULL,
    fechaModificacionData DATETIME DEFAULT NULL,
    FOREIGN KEY (idAdministrador) REFERENCES administrador (idAdministrador),
    FOREIGN KEY (idEspecialista) REFERENCES especialista (idEspecialista)
);

INSERT INTO administrador (nombre, apellido, cargo, direccion, telefono) VALUES
('Alan Atilio', 'Codori', 'Administrador', 'Arequipa', '936660120');

INSERT INTO login (rol, idAdministrador, idEspecialista, Email, Contrasena, Activacion, Estado, fechaModificacionPass, fechaModificacionData) VALUES
(1, 1, NULL, 'admin@da.com', '$2y$11$8zACYbl4d3PGpLIgIlEnzOuKCvhtTk9FG5AfyIsZXSRg62WK19NJ2', '2023-05-30 14:46:55', 1, '2023-06-02 17:44:09', '2023-06-02 17:43:39');


CREATE TABLE empresa (
    idEmpresa INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombreEmpresa VARCHAR(100) NOT NULL,
    ruc VARCHAR(11) NOT NULL,
    telefono VARCHAR(9) NOT NULL CHECK (LENGTH(telefono) = 9),
    email VARCHAR(50) NOT NULL,
    numeroPartida VARCHAR(8) NOT NULL,
    mipe VARCHAR(1) NOT NULL
);

CREATE TABLE objeto (
    idObjeto INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

INSERT INTO objeto (nombre) VALUES 
('Obras'),
('Servicios'),
('Bienes'),
('Consultoria de Obra'),
('Consultorías');


CREATE TABLE especialidad (
    idEspecialidad INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

INSERT INTO especialidad (nombre) VALUES
    ('Saneamiento'),
    ('Colegio'),
    ('Via'),
    ('Canal'),
    ('Edificación'),
    ('Parque'),
    ('Ciclovia'),
    ('Puente'),
    ('Electromecánica'),
    ('Infraestructura'),
    ('Infraestructura Parque'),
    ('Infraestructura Deportiva');


CREATE TABLE contacto (
    idContacto INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    dni VARCHAR(8) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(50) NOT NULL,
    celular VARCHAR(9) NOT NULL,
    cargo VARCHAR(50) DEFAULT NULL
);

CREATE TABLE documentos (
    idDocumento INT PRIMARY KEY AUTO_INCREMENT,
    acta_de_recepcion LONGBLOB,
    resolucion_de_obra LONGBLOB,
    resolucion_deductivos LONGBLOB,
    resolucion_adicionales LONGBLOB,
    anexo_de_promesa_de_consorcio LONGBLOB,
    constancia LONGBLOB,
    contrato_de_consorcio LONGBLOB,
    contrato LONGBLOB
);

CREATE TABLE proyectos (
    idProyecto INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_empresa INT(11) NOT NULL,
    nombre_proyecto VARCHAR(100) NOT NULL,
    numero_contrato VARCHAR(255) NOT NULL,
    entidad VARCHAR(255) NOT NULL,
    fecha_firma DATETIME NOT NULL,
    monto_contrato_original DECIMAL(20, 2) NOT NULL,
    porcentaje_de_participacion DECIMAL(20, 2) NOT NULL,
    adicionales_de_la_obra DECIMAL(20, 2) NOT NULL,
    deductivos_de_obra DECIMAL(20, 2) NOT NULL,
    monto_final_del_contrato DECIMAL(20, 2) NOT NULL,
    miembro_del_consorcio INT(11) NOT NULL,
    observaciones VARCHAR(255) DEFAULT NULL,
    contacto INT(11) NOT NULL,
    objeto INT(11) NOT NULL,
    especialidad INT(11) NOT NULL,
    FOREIGN KEY (nombre_empresa) REFERENCES empresa (idEmpresa),
    FOREIGN KEY (contacto) REFERENCES contacto (idContacto),
    FOREIGN KEY (objeto) REFERENCES objeto (idObjeto),
    FOREIGN KEY (especialidad) REFERENCES especialidad (idEspecialidad)
);

CREATE TABLE proyectos_documentos (
    idProyecto INT(11) NOT NULL,
    idDocumento INT(11) NOT NULL,
    FOREIGN KEY (idProyecto) REFERENCES proyectos (idProyecto),
    FOREIGN KEY (idDocumento) REFERENCES documentos (idDocumento)
);

CREATE TABLE procesos (
    numProceso INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    entidad VARCHAR(100) NOT NULL,
    nomenclatura VARCHAR(100) NOT NULL,
    objeto INT(11) NOT NULL,
    nombreClave VARCHAR(255) NOT NULL,
    consultas DATETIME,
    integracion DATETIME,
    presentacion DATETIME,
    buenaPro DATETIME,
    postores INT(11) NOT NULL,
    valorReferencial DECIMAL(20, 2) NOT NULL,
    encargado INT(11) NOT NULL,
    estado VARCHAR(55) DEFAULT NULL,
    observaciones VARCHAR(255) DEFAULT NULL,
    
    FOREIGN KEY (postores) REFERENCES empresa (idEmpresa),
    FOREIGN KEY (encargado) REFERENCES especialista (idEspecialista),
    FOREIGN KEY (objeto) REFERENCES objeto (idObjeto)
);
CREATE TABLE empresa_proceso (
    idEmpresa INT(11) NOT NULL,
    numProceso INT(11) NOT NULL,
    FOREIGN KEY (idEmpresa) REFERENCES empresa (idEmpresa),
    FOREIGN KEY (numProceso) REFERENCES procesos (numProceso)
);

INSERT INTO especialista (dni, nombre, apellido, cargo, direccion, telefono)
VALUES 
    ('12345678', 'Karol', 'Apellido 1', 'Especialista', 'Dirección 1', '987654321'),
    ('23456789', 'Nisha', 'Apellido 2', 'Especialista', 'Dirección 2', '876543210'),
    ('34567890', 'Yomira', 'Apellido 3', 'Especialista', 'Dirección 3', '765432109'),
    ('45678901', 'User', 'Apellido 4', 'Especialista', 'Dirección 4', '654321098');


INSERT INTO empresa (nombreEmpresa, ruc, telefono, email, numeroPartida, mipe)
VALUES 
    ('Empresa 1', '12345678901', '987654321', 'empresa1@example.com', '12345678', 'N'),
    ('Empresa 2', '23456789012', '876543210', 'empresa2@example.com', '23456789', 'N'),
    ('Empresa 3', '34567890123', '765432109', 'empresa3@example.com', '34567890', 'S'),
    ('Empresa 4', '45678901234', '654321098', 'empresa4@example.com', '45678901', 'N'),
    ('Empresa 5', '56789012345', '543210987', 'empresa5@example.com', '56789012', 'N');


INSERT INTO contacto (dni, nombre, email, celular, cargo)
VALUES 
    ('12345678', 'Contacto 1', 'contacto1@example.com', '987654321', 'Cargo 1'),
    ('23456789', 'Contacto 2', 'contacto2@example.com', '876543210', 'Cargo 2'),
    ('34567890', 'Contacto 3', 'contacto3@example.com', '765432109', 'Cargo 3'),
    ('45678901', 'Contacto 4', 'contacto4@example.com', '654321098', 'Cargo 4'),
    ('56789012', 'Contacto 5', 'contacto5@example.com', '543210987', 'Cargo 5');


/*datos de prueva*/
INSERT INTO procesos (entidad, nomenclatura, objeto, nombreClave, consultas, integracion, presentacion, buenaPro, postores, valorReferencial, encargado, estado, observaciones)
VALUES 
    ('Entidad 1', 'Nomenc 1', 1, 'Nombre Clave 1', '2023-06-14 08:00:00', '2023-06-15 12:30:00', '2023-06-16 11:15:00', '2023-06-17 13:00:00', 1, 1587896.25, 1, 'Estado 1', 'Observación 1'),
    ('Entidad 2', 'Nomenc 2', 2, 'Nombre Clave 2', '2023-06-14 08:00:00', '2023-06-15 12:30:00', '2023-06-16 11:15:00', '2023-06-17 13:00:00', 2, 2398745.50, 2, 'Estado 2', 'Observación 2'),
    ('Entidad 3', 'Nomenc 3', 3, 'Nombre Clave 3', '2023-06-14 08:00:00', '2023-06-15 12:30:00', '2023-06-16 11:15:00', '2023-06-17 13:00:00', 3, 1258946.75, 3, 'Estado 3', 'Observación 3'),
    ('Entidad 4', 'Nomenc 4', 4, 'Nombre Clave 4', '2023-06-14 08:00:00', '2023-06-15 12:30:00', '2023-06-16 11:15:00', '2023-06-17 13:00:00', 4, 3756489.30, 1, 'Estado 4', 'Observación 4'),
    ('Entidad 5', 'Nomenc 5', 5, 'Nombre Clave 5', '2023-06-14 08:00:00', '2023-06-15 12:30:00', '2023-06-16 11:15:00', '2023-06-17 13:00:00', 5, 1987456.80, 2, 'Estado 5', 'Observación 5'),
    ('Entidad 6', 'Nomenc 6', 1, 'Nombre Clave 6', '2023-06-14 08:00:00', '2023-06-15 12:30:00', '2023-06-16 11:15:00', '2023-06-17 13:00:00', 1, 897562.40, 3, 'Estado 6', 'Observación 6'),
    ('Entidad 7', 'Nomenc 7', 2, 'Nombre Clave 7', '2023-06-14 08:00:00', '2023-06-15 12:30:00', '2023-06-16 11:15:00', '2023-06-17 13:00:00', 3, 1795478.25, 2, 'Estado 7', 'Observación 7'),
    ('Entidad 8', 'Nomenc 8', 3, 'Nombre Clave 8', '2023-06-14 08:00:00', '2023-06-15 12:30:00', '2023-06-16 11:15:00', '2023-06-17 13:00:00', 2, 1245897.30, 1, 'Estado 8', 'Observación 8'),
    ('Entidad 9', 'Nomenc 9', 4, 'Nombre Clave 9', '2023-06-14 08:00:00', '2023-06-15 12:30:00', '2023-06-16 11:15:00', '2023-06-17 13:00:00', 3, 1758964.50, 2, 'Estado 9', 'Observación 9'),
    ('Entidad 10', 'Nomenc 10', 1, 'Nombre Clave 10', '2023-06-14 08:00:00', '2023-06-15 12:30:00', '2023-06-16 11:15:00', '2023-06-17 13:00:00', 1, 986574.80, 3, 'Estado 10', 'Observación 10'),
    ('Entidad 11', 'Nomenc 11', 2, 'Nombre Clave 11', '2023-06-14 08:00:00', '2023-06-15 12:30:00', '2023-06-16 11:15:00', '2023-06-17 13:00:00', 2, 2245897.60, 1, 'Estado 11', 'Observación 11'),
    ('Entidad 12', 'Nomenc 12', 3, 'Nombre Clave 12', '2023-06-14 08:00:00', '2023-06-15 12:30:00', '2023-06-16 11:15:00', '2023-06-17 13:00:00', 3, 1264589.90, 2, 'Estado 12', 'Observación 12');
