
/*

Este script está pensado para ser copiado y ejecutado. Contiene instrucciones para crear todas
las tablas, datos, y triggers que nuestra BBDD tiene.

Los datos que se cargarán son los más básicos, un usuario de cada tipo y la tabla de alérgenos completa.

*/

-- Creación de la BBDD si no está creada y acceso
CREATE DATABASE IF NOT EXISTS MarketChef;
USE MarketChef;

/*

Antes de crear todas las tablas, vamos a borrarlas en caso de que ya existan y no estén bien configuradas
Como hay tablas que dependen unas de otras (relaciones y claves foráneas), hay que borrarlas en el orden inverso de creación

*/

DROP TABLE IF EXISTS receta_etiqueta;
DROP TABLE IF EXISTS etiquetas;
DROP TABLE IF EXISTS ingrediente_alergeno;
DROP TABLE IF EXISTS receta_ingrediente;
DROP TABLE IF EXISTS magnitudes;
DROP TABLE IF EXISTS receta_comprada;
DROP TABLE IF EXISTS alergenos;
DROP TABLE IF EXISTS ingredientes;
DROP TABLE IF EXISTS recetas;
DROP TABLE IF EXISTS chefs;
DROP TABLE IF EXISTS usuarios;


-- Una vez borradas las tablas, procedemos a crearlas de nuevo, con los parámetros correctos.


-- Las tablas que se crearán son:

-- Tabla Usuarios

/*

Debido a los posibles problemas que puede ocasionar la letra ñ en distintos dispositivos y bases de datos configuradas en otros lenguajes,
se ha sustituido el campo Contraseña por Password, manteniendo el resto igual.

En las cuentas de ejemplo que hay precargadas, no se guardan los hashes de las contraseñas porque están siendo añadidas a la BBDD directamente
desde la consola de MySQL por nosotros. Cuando alguien se registre en la web, la contraseña será procesada en el backend y se almacenará
únicamente su hash.
*/
CREATE TABLE `usuarios` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 `Apellidos` varchar(100) NOT NULL,
 `Email` varchar(100) NOT NULL,
 `Rol` enum('Admin','User','Chef') NOT NULL DEFAULT 'User',
 `Password` varchar(250) NOT NULL COMMENT 'Se guarda el Hash',
 `Ruta` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`),
 UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla Chefs
CREATE TABLE `chefs` (
 `Usuario` int(11) NOT NULL,
 `DNI` varchar(9) NOT NULL,
 `Cuenta_bancaria` varchar(255) NOT NULL,
 `Saldo` double NOT NULL DEFAULT 0,
 UNIQUE KEY `DNI` (`DNI`),
 KEY `fk_c_usuario` (`Usuario`),
 CONSTRAINT `fk_c_usuario` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla Recetas
CREATE TABLE `recetas` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 `Autor` int(11) NOT NULL,
 `Descripcion` text NOT NULL,
 `Pasos` json NOT NULL,
 `Tiempo` int(11) NOT NULL,
 `Precio` double NOT NULL,
 `Fecha_Creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Ruta` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`),
 KEY `fk_recetas_autor` (`Autor`),
 CONSTRAINT `fk_recetas_autor` FOREIGN KEY (`Autor`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla Ingredientes

CREATE TABLE `ingredientes` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 UNIQUE KEY `Nombre` (`Nombre`),
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla Receta_Comprada
CREATE TABLE `receta_comprada` (
 `Usuario` int(11) NOT NULL,
 `Receta` int(11) NOT NULL,
 KEY `fk_rc_usuario` (`Usuario`),
 KEY `fk_rc_receta` (`Receta`),
 CONSTRAINT `fk_rc_receta` FOREIGN KEY (`Receta`) REFERENCES `recetas` (`ID`) ON DELETE CASCADE,
 CONSTRAINT `fk_rc_usuario` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla Magnitudes
CREATE TABLE `magnitudes` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`),
 UNIQUE KEY `Nombre` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla Receta_Ingrediente

CREATE TABLE `receta_ingrediente` (
 `Receta` int(11) NOT NULL,
 `Ingrediente` int(11) NOT NULL,
 `Cantidad` double NOT NULL,
 `Magnitud` int(11) NOT NULL,
 KEY `fk_ri_receta` (`Receta`),
 KEY `fk_ri_ingrediente` (`Ingrediente`),
 KEY `fk_ri_magnitud` (`Magnitud`),
 CONSTRAINT `fk_ri_receta` FOREIGN KEY (`Receta`) REFERENCES `recetas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `fk_ri_ingrediente` FOREIGN KEY (`Ingrediente`) REFERENCES `ingredientes` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `fk_ri_magnitud` FOREIGN KEY (`Magnitud`) REFERENCES `magnitudes` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla Etiquetas
CREATE TABLE `etiquetas` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`),
 UNIQUE KEY `Nombre` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabla Receta_Etiqueta
CREATE TABLE `receta_etiqueta` (
 `Receta` int(11) NOT NULL,
 `Etiqueta` int(11) NOT NULL,
 KEY `fk_re_receta` (`Receta`),
 KEY `fk_re_etiqueta` (`Etiqueta`),
 CONSTRAINT `fk_re_receta` FOREIGN KEY (`Receta`) REFERENCES `recetas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `fk_re_etiqueta` FOREIGN KEY (`Etiqueta`) REFERENCES `etiquetas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Eliminar el usuario 'MarketChef' si ya existe
DROP USER IF EXISTS 'MarketChef'@'%';

-- Crear el usuario 'MarketChef' con la contraseña 'MarketChef'
CREATE USER 'MarketChef'@'%' IDENTIFIED BY 'MarketChef';

-- Conceder todos los permisos sobre la base de datos MarketChef a este usuario
GRANT ALL PRIVILEGES ON MarketChef.* TO 'MarketChef'@'%';

-- Aplicar los cambios
FLUSH PRIVILEGES;
