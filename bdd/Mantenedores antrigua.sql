DROP DATABASE Mantenedores;
CREATE DATABASE IF NOT EXISTS Mantenedores;
USE Mantenedores;

CREATE TABLE  Cerveza (
	id int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    PRIMARY KEY (id)
);

CREATE TABLE  Distribuidor (
  id int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    PRIMARY KEY (id)
);

CREATE TABLE  Bar (
  id int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    nombre_sucursal varchar(250),
    direccion_sucursal varchar(250),
    PRIMARY KEY (id)
);

CREATE TABLE  Cerveceria (
  id int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    PRIMARY KEY (id)
);

CREATE TABLE usuario (
  id INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(250) NOT NULL,
  password VARCHAR(250) NOT NULL,
  correo VARCHAR(250) NULL,
  tipo CHAR(1) NOT NULL DEFAULT 'R',
  PRIMARY KEY (id));


INSERT INTO `Bar` (`id`, `nombre`, `nombre_sucursal`, `direccion_sucursal`) 
VALUES ('1', 'Ramblas', 'Providencia', 'Manuel Montt 1059'), 
('2', 'Ramblas ', 'Providencia', 'Manuel Montt 1293');


INSERT INTO `Cerveza` (`id`, `nombre`) 
VALUES ('1', 'Ambar'), 
('2', 'Rubia');

INSERT INTO `Distribuidor` (`id`, `nombre`) 
VALUES ('1', 'Distribuidora 1'), 
('2', 'distribuidora 2');

INSERT INTO `usuario` (`id`, `nombre`, `password`, `correo`, `tipo`) 
VALUES ('1', 'rodrigo', 'admin', 'rodrigo', 'R'), 
('2', 'Gonzalo', 'admin', 'Gonzalo', 'R');

INSERT INTO `Cerveceria` (`id`, `nombre`) 
VALUES ('1', 'Kross'), 
('2', 'Cuello Negro');