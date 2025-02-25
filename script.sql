
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

DROP TABLE IF EXISTS ingrediente_alergeno;
DROP TABLE IF EXISTS receta_ingrediente;
DROP TABLE IF EXISTS receta_comprada;
DROP TABLE IF EXISTS valoraciones;
DROP TABLE IF EXISTS alergenos;
DROP TABLE IF EXISTS ingredientes;
DROP TABLE IF EXISTS recetas;
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
 `DNI` varchar(9) DEFAULT NULL,
 `Cuenta_bancaria` varchar(100) DEFAULT NULL,
 PRIMARY KEY (`ID`),
 UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


    -- Datos de la tabla usuarios
    INSERT INTO usuarios (Nombre, Apellidos, Email, Rol, Password) VALUES
    ('usuario', 'ejemplo', 'usuario@marketchef.com', 'User', 'usuario'),
    ('admin', 'ejemplo', 'admin@marketchef.com', 'Admin', 'admin');

    INSERT INTO usuarios (Nombre, Apellidos, Email, Rol, Password, DNI, Cuenta_bancaria) VALUES
    ('chef', 'ejemplo', 'chef@marketchef.com', 'Chef', 'chef', '12345678A', 'ES00 0000 0000 0000 0000 0000');

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
 `Valoracion` double DEFAULT NULL,
 PRIMARY KEY (`ID`),
 KEY `fk_recetas_autor` (`Autor`),
 CONSTRAINT `fk_recetas_autor` FOREIGN KEY (`Autor`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla Ingredientes

CREATE TABLE `ingredientes` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla Alérgenos

CREATE TABLE `alergenos` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

    -- Datos de la tabla alérgenos

        -- Aqui incluiremos los principales alérgenos que según la normativa europea deben declararse como mínimo, ordenados alfabéticamente.
        -- Se pueden incluir muchos más, solo hay que añadirlos.
        INSERT INTO alergenos (Nombre) VALUES
        ('Altramuces'),
        ('Apio'),
        ('Cacahuetes'),
        ('Crustáceos'),
        ('Frutos secos'),
        ('Gluten'),
        ('Huevos'),
        ('Lácteos'),
        ('Moluscos'),
        ('Mostaza'),
        ('Pescado'),
        ('Sesamo'),
        ('Soja'),
        ('Sulfitos');



-- Tabla Valoraciones

CREATE TABLE `valoraciones` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Usuario` int(11) NOT NULL,
 `Receta` int(11) NOT NULL,
 `Puntuacion` double NOT NULL COMMENT 'de 0 a 5',
 `Comentario` text DEFAULT NULL,
 PRIMARY KEY (`ID`),
 KEY `fk_valoraciones_usuario` (`Usuario`),
 KEY `fk_valoraciones_receta` (`Receta`),
 CONSTRAINT `fk_valoraciones_receta` FOREIGN KEY (`Receta`) REFERENCES `recetas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `fk_valoraciones_usuario` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
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


-- Tabla Receta_Ingrediente

CREATE TABLE `receta_ingrediente` (
 `Receta` int(11) NOT NULL,
 `Ingrediente` int(11) NOT NULL,
 `Cantidad` double NOT NULL,
 `Magnitud` varchar(100) NOT NULL,
 KEY `fk_ri_receta` (`Receta`),
 KEY `fk_ri_usuario` (`Ingrediente`),
 CONSTRAINT `fk_ri_receta` FOREIGN KEY (`Receta`) REFERENCES `recetas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `fk_ri_usuario` FOREIGN KEY (`Ingrediente`) REFERENCES `ingredientes` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla Ingrediente_Alérgeno
CREATE TABLE `ingrediente_alergeno` (
 `Ingrediente` int(11) NOT NULL,
 `Alergeno` int(11) NOT NULL,
 KEY `fk_ia_ingrediente` (`Ingrediente`),
 KEY `fk_ia_alergeno` (`Alergeno`),
 CONSTRAINT `fk_ia_alergeno` FOREIGN KEY (`Alergeno`) REFERENCES `alergenos` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `fk_ia_ingrediente` FOREIGN KEY (`Ingrediente`) REFERENCES `ingredientes` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Los triggers que se crearán son:

-- Trigger que actualiza las valoraciones de las recetas para cada nueva valoración creada:

DELIMITER $$

CREATE TRIGGER `actualizar_media_valoracion` 
AFTER INSERT ON `valoraciones`
FOR EACH ROW 
BEGIN
    UPDATE recetas
    SET Valoracion = (SELECT AVG(Puntuacion) FROM valoraciones WHERE Receta = NEW.Receta) WHERE ID = NEW.Receta;
END $$

DELIMITER ;