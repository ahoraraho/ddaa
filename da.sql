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
/*DATO DE PRUEVA DE INGRESO QUE TIDAVIA NO ES USABLE*/
INSERT INTO especialista (dni, nombre, apellido, cargo, direccion, telefono)
VALUES 
    ('12345678', 'Karol', 'Apellido 1', 'Especialista', 'Dirección 1', '987654321'),
    ('23456789', 'Nisha', 'Apellido 2', 'Especialista', 'Dirección 2', '876543210'),
    ('34567890', 'Yomira', 'Apellido 3', 'Especialista', 'Dirección 3', '765432109'),
    ('45678901', 'User', 'Apellido 4', 'Especialista', 'Dirección 4', '654321098');


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
    ruc VARCHAR(11) NOT NULL CHECK (LENGTH(ruc) = 11),
    telefono VARCHAR(9) NOT NULL CHECK (LENGTH(telefono) = 9),
    email VARCHAR(50) NOT NULL,
    numeroPartida VARCHAR(8) NOT NULL CHECK (LENGTH(telefono) = 9),
    mipe VARCHAR(1) NOT NULL
);

INSERT INTO empresa (nombreEmpresa, ruc, telefono, email, numeroPartida, mipe)
VALUES 
    ('Empresa 1', '12345678901', '987654321', 'empresa1@example.com', '12345678', 'N'),
    ('Empresa 2', '23456789012', '876543210', 'empresa2@example.com', '23456789', 'N'),
    ('Empresa 3', '34567890123', '765432109', 'empresa3@example.com', '34567890', 'S'),
    ('Empresa 4', '45678901234', '654321098', 'empresa4@example.com', '45678901', 'N'),
    ('Empresa 5', '56789012345', '543210987', 'empresa5@example.com', '56789012', 'N');

CREATE TABLE archivosEmpresa (
    idEmpresa INT(11) NOT NULL,
    ficha_ruc VARCHAR(255) DEFAULT NULL,
    constancia_RNP VARCHAR(255) DEFAULT NULL,
    constancia_mipe VARCHAR(255) DEFAULT NULL,
    certificado_discapacitados VARCHAR(255) DEFAULT NULL,
    planilla_discapasitados VARCHAR(255) DEFAULT NULL,
    carnet_conadis VARCHAR(255) DEFAULT NULL, /*o sertificado medico*/

    FOREIGN KEY (idEmpresa) REFERENCES empresa (idEmpresa)
);

INSERT INTO archivosEmpresa (idEmpresa, ficha_ruc, constancia_RNP, constancia_mipe, certificado_discapacitados, planilla_discapasitados, carnet_conadis) 
VALUES 
    (1, 'FICHA001.pdf', 'CONSTANCIA001.pdf', 'MIPE001.pdf', 'DISCAPACIDAD001.pdf', 'PLANILLA001.pdf', 'CARNET001.pdf'),
    (2, 'FICHA002.pdf', 'CONSTANCIA002.pdf', 'MIPE002.pdf', 'DISCAPACIDAD002.pdf', 'PLANILLA002.pdf', 'CARNET002.pdf'),
    (3, 'FICHA003.pdf', 'CONSTANCIA003.pdf', 'MIPE003.pdf', 'DISCAPACIDAD003.pdf', 'PLANILLA003.pdf', 'CARNET003.pdf'),
    (4, 'FICHA004.pdf', 'CONSTANCIA004.pdf', 'MIPE004.pdf', 'DISCAPACIDAD004.pdf', 'PLANILLA004.pdf', 'CARNET004.pdf'),
    (5, 'FICHA005.pdf', 'CONSTANCIA005.pdf', 'MIPE005.pdf', 'DISCAPACIDAD005.pdf', 'PLANILLA005.pdf', 'CARNET005.pdf');


CREATE TABLE objeto (
    idObjeto INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

INSERT INTO objeto (nombre) VALUES 
('Obras'),
('Servicios'),
('Bienes'),
('Consultorías'),
('Consultoria de Obra');


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

INSERT INTO contacto (dni, nombre, email, celular, cargo)
VALUES 
    ('12345678', 'Contacto 1', 'contacto1@example.com', '987654321', 'Cargo 1'),
    ('23456789', 'Contacto 2', 'contacto2@example.com', '876543210', 'Cargo 2'),
    ('34567890', 'Contacto 3', 'contacto3@example.com', '765432109', 'Cargo 3'),
    ('45678901', 'Contacto 4', 'contacto4@example.com', '654321098', 'Cargo 4'),
    ('56789012', 'Contacto 5', 'contacto5@example.com', '543210987', 'Cargo 5');

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

INSERT INTO proyectos (nombre_empresa, nombre_proyecto, numero_contrato, entidad, fecha_firma, monto_contrato_original, porcentaje_de_participacion, adicionales_de_la_obra, deductivos_de_obra, monto_final_del_contrato, miembro_del_consorcio, observaciones, contacto, objeto, especialidad)
VALUES
(1, 'Proyecto Alpha', 'CONTR2023-001', 'Compañía A', '2023-06-01 10:00:00', 1500000.00, 70.00, 50000.00, 0.00, 1545000.00, 1, 'Observación por defecto', 2, 3, 7),
(2, 'Proyecto Beta', 'CONTR2023-002', 'Organización B', '2023-06-02 11:30:00', 2200000.00, 50.00, 80000.00, 0.00, 2240000.00, 2, 'Observación por defecto', 5, 1, 10),
(3, 'Proyecto Gamma', 'CONTR2023-003', 'Entidad C', '2023-06-03 14:15:00', 1800000.00, 80.00, 60000.00, 0.00, 1836000.00, 3, 'Observación por defecto', 4, 4, 3),
(4, 'Proyecto Delta', 'CONTR2023-004', 'Empresa XYZ', '2023-06-04 09:45:00', 2500000.00, 75.00, 90000.00, 0.00, 2572500.00, 1, 'Observación por defecto', 1, 2, 8),
(5, 'Proyecto Epsilon', 'CONTR2023-005', 'Institución PQR', '2023-06-05 12:30:00', 3100000.00, 60.00, 100000.00, 0.00, 3140000.00, 2, 'Observación por defecto', 3, 5, 12);
CREATE TABLE archivosProyectos (
    idProyecto INT(11) NOT NULL,
    acta_de_recepcion VARCHAR(255) DEFAULT NULL,
    resolucion_de_obra VARCHAR(255) DEFAULT NULL,
    resolucion_deductivos VARCHAR(255) DEFAULT NULL,
    resolucion_adicionales VARCHAR(255) DEFAULT NULL,
    anexo_de_promesa_de_consorcio VARCHAR(255) DEFAULT NULL,
    constancia VARCHAR(255) DEFAULT NULL,
    contrato_de_consorcio VARCHAR(255) DEFAULT NULL,
    contrato VARCHAR(255) DEFAULT NULL,

    FOREIGN KEY (idProyecto) REFERENCES proyectos (idProyecto)
);

INSERT INTO archivosProyectos (idProyecto, acta_de_recepcion, resolucion_de_obra, resolucion_deductivos, resolucion_adicionales, anexo_de_promesa_de_consorcio, constancia, contrato_de_consorcio, contrato)
VALUES 
    (1, 'ActaRecepcion001.pdf', 'ResolucionObra001.pdf', 'ResolucionDeductivos001.pdf', 'ResolucionAdicionales001.pdf', 'AnexoPromesaConsorcio001.pdf', 'Constancia001.pdf', 'ContratoConsorcio001.pdf', 'Contrato001.pdf'),
    (2, 'ActaRecepcion002.pdf', 'ResolucionObra002.pdf', 'ResolucionDeductivos002.pdf', 'ResolucionAdicionales002.pdf', 'AnexoPromesaConsorcio002.pdf', 'Constancia002.pdf', 'ContratoConsorcio002.pdf', 'Contrato002.pdf'),
    (3, 'ActaRecepcion003.pdf', 'ResolucionObra003.pdf', 'ResolucionDeductivos003.pdf', 'ResolucionAdicionales003.pdf', 'AnexoPromesaConsorcio003.pdf', 'Constancia003.pdf', 'ContratoConsorcio003.pdf', 'Contrato003.pdf'),
    (4, 'ActaRecepcion004.pdf', 'ResolucionObra004.pdf', 'ResolucionDeductivos004.pdf', 'ResolucionAdicionales004.pdf', 'AnexoPromesaConsorcio004.pdf', 'Constancia004.pdf', 'ContratoConsorcio004.pdf', 'Contrato004.pdf'),
    (5, 'ActaRecepcion005.pdf', 'ResolucionObra005.pdf', 'ResolucionDeductivos005.pdf', 'ResolucionAdicionales005.pdf', 'AnexoPromesaConsorcio005.pdf', 'Constancia005.pdf', 'ContratoConsorcio005.pdf', 'Contrato005.pdf');



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

CREATE TABLE empresa_proceso (
    idEmpresa INT(11) NOT NULL,
    numProceso INT(11) NOT NULL,
    FOREIGN KEY (idEmpresa) REFERENCES empresa (idEmpresa),
    FOREIGN KEY (numProceso) REFERENCES procesos (numProceso)
);

/*TABLAS QUE SE VERAN EN EL SITIO WEB*/

CREATE TABLE tipoActualizacion (
    idActual INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL
);

INSERT INTO tipoActualizacion (nombre) VALUES 
('Resolución'),
('Pronunciamiento'),
('Opinión'),
('Directiva'),
('Dictamen');


CREATE TABLE actualizaciones (
    idActualizacion INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(255) NOT NULL,
    archivo VARCHAR(255) NULL,
    tipo INT(11) NOT NULL,
    FOREIGN KEY (tipo) REFERENCES tipoActualizacion (idActual)
);

CREATE TABLE noticias (
    idNoticia INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255),
    descripcion LONGTEXT,
    fecha DATE,
    destacado VARCHAR(1),
    imagen VARCHAR(255)
);


INSERT INTO noticias (titulo, descripcion, fecha, destacado) VALUES 
('Noticia 1', 'Descripción de la noticia 1', '2023-06-20', '0'),
('Noticia 2', 'Descripción de la noticia 2', '2023-06-20', '0'),
('Minem incrementará conexiones de gas natural en Arequipa, Moquegua y Tacna este 2023', 'El Minem elaboró un Convenio Específico de Inversiones, el cual cuenta con la conformidad de Petroperú, que permitirá iniciar este año la construcción de 350 km de redes de distribución y conectar más de 22 mil usuarios al gas natural.', '2023-06-20', '1'),
('Noticia 3', 'Descripción de la noticia 3', '2023-06-20', '0');

