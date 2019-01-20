
DROP DATABASE if EXISTS Cerveza_Artesanal

CREATE DATABASE IF NOT EXISTS Cerveza_Artesanal;
USE Cerveza_Artesanal;

CREATE TABLE  cerveceria (
	id_cerveceria int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    PRIMARY KEY (id_cerveceria)
);

CREATE TABLE  producto (
	id_producto int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    fecha_elaboracion date,
    fecha_expiracion date,
    cantidad int,
    PRIMARY KEY (id_producto)
);

CREATE TABLE  bar (
	id_bar int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    nombre_sucursal varchar(250),
    direccion_sucursal varchar(250),
    PRIMARY KEY (id_bar)
);


CREATE TABLE  barril (
	id_barril int NOT NULL AUTO_INCREMENT,
    capacidad int,
    status varchar(250),
    id_producto int NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto),
    PRIMARY KEY (id_barril)
);

CREATE TABLE  distribuidor (
	id_distribuidor int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    nombre_sucursal varchar(250),
    id_barril int NOT NULL,
    FOREIGN KEY (id_barril) REFERENCES barril(id_barril),
    PRIMARY KEY (id_distribuidor)
);

CREATE TABLE  balanza (
	id_balanza int NOT NULL AUTO_INCREMENT,
    peso_barril int,
    id_barril int NOT NULL,
    FOREIGN KEY (id_barril) REFERENCES barril(id_barril),
    PRIMARY KEY (id_balanza)
);

CREATE TABLE  consumidor (
	id_consumidor int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    correo varchar(250),
    numero varchar(250),
    PRIMARY KEY (id_consumidor)
);

CREATE TABLE usuarios (
  id_usuario INT NOT NULL AUTO_INCREMENT,
  id_bar int NOT NULL,
  nombre VARCHAR(250) NOT NULL,
  password VARCHAR(250) NOT NULL,
  correo VARCHAR(250) NULL,
  tipo CHAR(1) NOT NULL DEFAULT 'W',
  PRIMARY KEY (id_usuario),
  FOREIGN KEY (id_bar) REFERENCES bar(id_bar)
  );

CREATE TABLE IF NOT EXISTS cerveceria_producto (
	id_cerveceria_producto int NOT NULL AUTO_INCREMENT,
    id_producto int NOT NULL,
    id_cerveceria int NOT NULL,
    cantidad int,
    PRIMARY KEY (id_cerveceria_producto),
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto),
    FOREIGN KEY (id_cerveceria) REFERENCES cerveceria(id_cerveceria)
);

CREATE TABLE IF NOT EXISTS consumo (
	
    id_consumo int NOT NULL AUTO_INCREMENT,
    id_balanza int NOT NULL,
    id_barril int NOT NULL,
    peso_barril int,
    fecha date,
    hora datetime,
    PRIMARY KEY (id_consumo),
    FOREIGN KEY (id_barril) REFERENCES balanza(id_barril),
    FOREIGN KEY (id_balanza) REFERENCES balanza(id_balanza)
    
);

CREATE TABLE IF NOT EXISTS cerveceria_distribuidor (
	id_cerveceria_distribuidor int NOT NULL AUTO_INCREMENT,
    id_distribuidor int NOT NULL,
    id_cerveceria int NOT NULL,
    cantidad_barriles int,
    PRIMARY KEY (id_cerveceria_distribuidor),
    FOREIGN KEY (id_distribuidor) REFERENCES distribuidor(id_distribuidor),
    FOREIGN KEY (id_cerveceria) REFERENCES cerveceria(id_cerveceria)
);

CREATE TABLE IF NOT EXISTS producto_Bar (
	id_producto_bar int NOT NULL AUTO_INCREMENT,
    id_producto int NOT NULL,
    id_bar int NOT NULL,
    cantidad int,
    PRIMARY KEY (id_Producto_bar),
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto),
    FOREIGN KEY (id_bar) REFERENCES bar(id_bar)
);

CREATE TABLE IF NOT EXISTS consumidor_Bar (
	id_Consumidor_bar int NOT NULL AUTO_INCREMENT,
    id_consumidor int NOT NULL,
    id_bar int NOT NULL,
    cantidad int,
    PRIMARY KEY (id_Consumidor_bar),
    FOREIGN KEY (id_consumidor) REFERENCES consumidor(id_consumidor),
    FOREIGN KEY (id_bar) REFERENCES bar(id_bar)
);


CREATE TABLE IF NOT EXISTS registro (
	id_registro INT NOT NULL AUTO_INCREMENT,
    nombre_sucursal INT NOT NULL,
    factura INT NOT NULL,
    receptor VARCHAR (250),
    linea INT,
    fecha_elaboración DATE,
    fecha_vencimiento DATE,
    cerveceria VARCHAR(250),
    tipo_barril VARCHAR(250),
    etiqueta INT
    PRIMARY KEY (id_registro)
);
 