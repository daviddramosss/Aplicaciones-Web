
/* 

Este script está pensado para ser copiado y ejecutado. Contiene instrucciones para crear todas 
las tablas, datos, y triggers que nuestra BBDD tiene.

Los datos que se cargarán son los más básicos, un usuario de cada tipo y la tabla de alérgenos completa.

*/

-- Creación de la BBDD si no está creada y acceso
CREATE DATABASE IF NOT EXISTS MarketChef;
USE MarketChef;

--Las tablas que se crearán son:

-- Tabla Usuarios

DROP TABLE IF EXISTS usuarios;
CREATE TABLE `usuarios` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 `Apellidos` varchar(100) NOT NULL,
 `Email` varchar(100) NOT NULL,
 `Rol` enum('Admin','User','Chef') NOT NULL DEFAULT 'User',
 `Contraseña` varchar(250) NOT NULL COMMENT 'Se guarda el Hash',
 `DNI` varchar(9) DEFAULT NULL,
 `Cuenta_bancaria` varchar(100) DEFAULT NULL,
 PRIMARY KEY (`ID`),
 UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


    -- Datos de la tabla usuarios



--Tabla Recetas
DROP TABLE IF EXISTS recetas;
CREATE TABLE `recetas` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 `Autor` int(11) NOT NULL,
 `Descripcion` text NOT NULL,
 `Pasos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`Pasos`)),
 `Tiempo` int(11) NOT NULL,
 `Precio` double NOT NULL,
 `Fecha_Creacion` timestamp NOT NULL DEFAULT current_timestamp(),
 `Valoracion` double DEFAULT NULL,
 PRIMARY KEY (`ID`),
 KEY `Autor` (`Autor`),
 CONSTRAINT `Autor` FOREIGN KEY (`Autor`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla Ingredientes
DROP TABLE IF EXISTS ingredientes;
CREATE TABLE `ingredientes` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla Alérgenos
DROP TABLE IF EXISTS alergenos;
CREATE TABLE `alergenos` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

    -- Datos de la tabla alérgenos


-- Tabla Valoraciones
DROP TABLE IF EXISTS valoraciones;
CREATE TABLE `valoraciones` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Usuario` int(11) NOT NULL,
 `Receta` int(11) NOT NULL,
 `Puntuacion` double NOT NULL COMMENT 'de 0 a 5',
 `Comentario` text DEFAULT NULL,
 PRIMARY KEY (`ID`),
 KEY `Usuario` (`Usuario`),
 KEY `Receta` (`Receta`),
 CONSTRAINT `Receta` FOREIGN KEY (`Receta`) REFERENCES `recetas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `Usuario` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla Receta_Comprada
DROP TABLE IF EXISTS receta_comprada;
CREATE TABLE `receta_comprada` (
 `Usuario` int(11) NOT NULL,
 `Receta` int(11) NOT NULL,
 KEY `user` (`Usuario`),
 KEY `rec` (`Receta`),
 CONSTRAINT `rec` FOREIGN KEY (`Receta`) REFERENCES `recetas` (`ID`) ON DELETE CASCADE,
 CONSTRAINT `user` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla Receta_Ingrediente
DROP TABLE IF EXISTS receta_ingrediente;
CREATE TABLE `receta_ingrediente` (
 `Receta` int(11) NOT NULL,
 `Ingrediente` int(11) NOT NULL,
 `Cantidad` double NOT NULL,
 `Magnitud` varchar(100) NOT NULL,
 KEY `1` (`Receta`),
 KEY `2` (`Ingrediente`),
 CONSTRAINT `1` FOREIGN KEY (`Receta`) REFERENCES `recetas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `2` FOREIGN KEY (`Ingrediente`) REFERENCES `ingredientes` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla Ingrediente_Alérgeno
DROP TABLE IF EXISTS ingrediente_alergeno;
CREATE TABLE `ingrediente_alergeno` (
 `Ingrediente` int(11) NOT NULL,
 `Alergeno` int(11) NOT NULL,
 KEY `Ingrediente` (`Ingrediente`),
 KEY `Alergeno` (`Alergeno`),
 CONSTRAINT `Alergeno` FOREIGN KEY (`Alergeno`) REFERENCES `alergenos` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `Ingrediente` FOREIGN KEY (`Ingrediente`) REFERENCES `ingredientes` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Los triggers que se crearán son:

-- Trigger que actualiza las valoraciones de las recetas para cada nueva valoración creada:
CREATE TRIGGER `actualizar_media_valoracion` 
AFTER INSERT ON `valoraciones`
FOR EACH ROW 
BEGIN
    UPDATE recetas
    SET Valoracion = (SELECT AVG(Puntuacion) FROM valoraciones WHERE Receta = NEW.Receta) WHERE ID = NEW.Receta;
END

