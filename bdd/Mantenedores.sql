
DROP DATABASE if EXISTS Cerveza_Artesanal;

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
    familia varchar(250),
   
    PRIMARY KEY (id_producto)
);


CREATE TABLE  barril (
	id_barril int NOT NULL AUTO_INCREMENT,
    capacidad int,
    status varchar(250),
    id_producto int NOT NULL,
	fecha_elaboracion date,
    fecha_expiracion date,
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto),
    PRIMARY KEY (id_barril)
);

CREATE TABLE  bar (
	id_bar int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    nombre_sucursal varchar(250),
    direccion_sucursal varchar(250),
    PRIMARY KEY (id_bar)
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
	ubicacion varchar(250),
    PRIMARY KEY (id_balanza)
);

CREATE TABLE  consumidor (
	id_consumidor int NOT NULL AUTO_INCREMENT,
    nombre varchar(250),
    correo varchar(250),
    numero varchar(250),
    PRIMARY KEY (id_consumidor)
);

CREATE TABLE pinchado (
id_pinchado int not null auto_increment,
id_barril int not null,
id_balanza int not null,
fecha datetime,
hora time,
peso_inicial int,
primary key(id_pinchado),
foreign key(id_barril) references barril(id_barril),
foreign key (id_balanza) references balanza(id_balanza)
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
    FOREIGN KEY (id_barril) REFERENCES barril(id_barril),
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
    id_bar INT NOT NULL,
    id_cerveceria INT NOT NULL,
    id_producto INT NOT NULL,
    fecha_registro DATETIME,
    factura INT NOT NULL,
    receptor VARCHAR (250),
    linea INT,
    fecha_elaboracion DATE,
    fecha_vencimiento DATE,
    tipo_barril VARCHAR(250),
    etiqueta INT,
    PRIMARY KEY (id_registro),
    FOREIGN KEY (id_bar) REFERENCES bar(id_bar),
    FOREIGN KEY (id_cerveceria) REFERENCES cerveceria(id_cerveceria),
    FOREIGN KEY (id_producto) REFERENCES producto(id_producto)

);

INSERT INTO `bar` (`id_bar`, `nombre`, `nombre_sucursal`, `direccion_sucursal`)
VALUES ('1', 'Ramblas', 'Providencia', 'Av. Manuel Montt 370');

INSERT INTO `usuarios` (`id_usuario`, `id_bar`, `nombre`, `password`, `correo`, `tipo`)
VALUES ('1', '1', 'rodrigo', '0401', 'rvalenzuelagu@gmail.com', 'W');

INSERT INTO `cerveceria` (`id_cerveceria`, `nombre`)
VALUES ('1', 'Kross'), ('2', 'Rothhammer');

INSERT INTO `producto` (`id_producto`, `nombre`, `familia`) 
VALUES ('1', 'Ambar', 'Lager'), ('2', 'Negra', 'Stout');

INSERT INTO `registro` (`id_registro`, `id_bar`, `id_cerveceria`, `id_producto`, `fecha_registro`,
`factura`, `receptor`, `linea`, `fecha_elaboracion`, `fecha_vencimiento`, `tipo_barril`, `etiqueta`)
VALUES ('1', '1', '2', '1', '2019-01-24 07:15:17', '123', 'Rodrigo Valenzuela', '1', '2019-01-24',
'2019-01-31', '50', '1233');