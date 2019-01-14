
CREATE DATABASE IF NOT EXISTS Cerveza_Artesanal;
USE Cerveza_Artesanal;

CREATE TABLE  Cerveceria (
	id_cerveceria int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    PRIMARY KEY (id_cerveceria)
);

CREATE TABLE  Producto (
	id_producto int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    fecha_elaboracion date,
    fecha_expiracion date,
    cantidad int,
    PRIMARY KEY (id_producto)
);

CREATE TABLE  Bar (
	id_bar int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    nombre_sucursal varchar(250),
    direccion_sucursal varchar(250),
    PRIMARY KEY (id_bar)
);


CREATE TABLE  Barril (
	id_barril int NOT NULL AUTO_INCREMENT,
    capacidad int,
    status varchar(250),
    id_producto int NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES Producto(id_producto),
    PRIMARY KEY (id_barril)
);

CREATE TABLE  Distribuidor (
	id_distribuidor int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    nombre_sucursal varchar(250),
    id_barril int NOT NULL,
    FOREIGN KEY (id_barril) REFERENCES Barril(id_barril),
    PRIMARY KEY (id_distribuidor)
);

CREATE TABLE  Balanza (
	id_balanza int NOT NULL AUTO_INCREMENT,
    peso_barril int,
    id_barril int NOT NULL,
    FOREIGN KEY (id_barril) REFERENCES Barril(id_barril),
    PRIMARY KEY (id_balanza)
);




CREATE TABLE  Consumidor (
	id_consumidor int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    correo varchar(250),
    numero varchar(250),
    PRIMARY KEY (id_consumidor)
);


CREATE TABLE Usuarios (
  id_usuario INT NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(250) NOT NULL,
  password VARCHAR(250) NOT NULL,
  correo VARCHAR(250) NULL,
  tipo CHAR(1) NOT NULL DEFAULT 'R',
  PRIMARY KEY (id_usuario));

CREATE TABLE IF NOT EXISTS Cerveceria_producto (
	id_cerveceria_producto int NOT NULL AUTO_INCREMENT,
    id_producto int NOT NULL,
    id_cerveceria int NOT NULL,
    cantidad int,
    PRIMARY KEY (id_cerveceria_producto),
    FOREIGN KEY (id_producto) REFERENCES Producto(id_producto),
    FOREIGN KEY (id_cerveceria) REFERENCES Cerveceria(id_cerveceria)
);

CREATE TABLE IF NOT EXISTS Consumo (
	
    id_consumo int NOT NULL AUTO_INCREMENT,
    id_balanza int NOT NULL,
    id_barril int NOT NULL,
    peso_barril int,
    fecha date,
    hora datetime,
    PRIMARY KEY (id_consumo),
    FOREIGN KEY (id_barril) REFERENCES Balanza(id_barril),
    FOREIGN KEY (id_balanza) REFERENCES Balanza(id_balanza)
    
);

CREATE TABLE IF NOT EXISTS Cerveceria_distribuidor (
	id_cerveceria_distribuidor int NOT NULL AUTO_INCREMENT,
    id_distribuidor int NOT NULL,
    id_cerveceria int NOT NULL,
    cantidad_barriles int,
    PRIMARY KEY (id_cerveceria_distribuidor),
    FOREIGN KEY (id_distribuidor) REFERENCES Distribuidor(id_distribuidor),
    FOREIGN KEY (id_cerveceria) REFERENCES Cerveceria(id_cerveceria)
);

CREATE TABLE IF NOT EXISTS Producto_Bar (
	id_producto_bar int NOT NULL AUTO_INCREMENT,
    id_producto int NOT NULL,
    id_bar int NOT NULL,
    cantidad int,
    PRIMARY KEY (id_Producto_bar),
    FOREIGN KEY (id_producto) REFERENCES Producto(id_producto),
    FOREIGN KEY (id_bar) REFERENCES Bar(id_bar)
);


CREATE TABLE IF NOT EXISTS Consumidor_Bar (
	id_Consumidor_bar int NOT NULL AUTO_INCREMENT,
    id_consumidor int NOT NULL,
    id_bar int NOT NULL,
    cantidad int,
    PRIMARY KEY (id_Consumidor_bar),
    FOREIGN KEY (id_consumidor) REFERENCES Consumidor(id_consumidor),
    FOREIGN KEY (id_bar) REFERENCES Bar(id_bar)
);


/*
INSERT INTO `autor` (`id`, `nombre`, `nacionalidad`, `token`) 
VALUES ('1', 'Isabel allende', 'Chilena', NULL),
('2', 'Stephen King', 'Chilena', NULL);

INSERT INTO `libros` (`id`, `nombre`, `precio`, `genero`) 
VALUES ('1', 'IT', '15000', 'Ciencia ficción'), 
('2', 'La ciudad de las bestias', '12000', 'Ciencia ficción');

INSERT INTO `usuario` (`id`, `nombre`, `password`, `correo`, `tipo`) 
VALUES ('1', 'rodrigo', 'admin', 'rodrigo', 'R'), 
('2', 'Gonzalo', 'admin', 'Gonzalo', 'R');

INSERT INTO autor_libro (id_libro, id_autor) VALUES
	(1,5),
    (2,4),
    (3,3),
    (4,2),
    (5,1),
    (5,2);*/
