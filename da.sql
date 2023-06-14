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
    nombreClave VARCHAR(255) NOT NULL,
    consultas DATETIME,
    integracion DATETIME,
    presentacion DATETIME,
    buenaPro DATETIME,
    valorReferencial VARCHAR(255) NOT NULL,
    postores INT(11) NOT NULL,
    encargado INT(11) NOT NULL,
    objeto INT(11) NOT NULL,
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