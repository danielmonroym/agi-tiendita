CREATE DATABASE  `tiendita` collate utf8_general_ci;

use tiendita;

CREATE TABLE productos (
        id_producto INT NOT NULL AUTO_INCREMENT,
        nombre CHAR(100),
        precio  INT,
        cantidad INT,
        descripcion CHAR(100),
        KEY (id_producto)
);

INSERT INTO productos VALUES (1, 'Leche Alqueria', 420,
       5, 'Leche melita pa desayunar' );

INSERT INTO productos VALUES (2, 'Arepitas', 666,
       15, 'Producto apenas pa desayunar' );

INSERT INTO productos VALUES (3, 'CocaCola', 999,
       5, 'Oro negro' );

INSERT INTO productos VALUES (4, 'Quesito', 100,
       25, 'Util para todas las comidas' );

CREATE TABLE venta_productos (
	id_venta INT NOT NULL AUTO_INCREMENT, 
	nombre CHAR(100), 
	cantidad INT,
	precio INT,
	KEY (id_venta) 
); 

