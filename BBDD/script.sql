
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
DROP TABLE IF EXISTS valoraciones;
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
 PRIMARY KEY (`ID`),
 UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


    -- Datos de la tabla usuarios
    INSERT INTO usuarios (Nombre, Apellidos, Email, Rol, Password) VALUES
    ('usuario', 'ejemplo', 'usuario@marketchef.com', 'User', '$2y$10$wjhoam2JWbGg4I4NRGoJF.ZUsLITJlV05Vg9Jp6GUBMdOWAlCI7FO'),
    ('admin', 'ejemplo', 'admin@marketchef.com', 'Admin', '$2y$10$aAfWpoA8/09hASfXru8j6.PUC1kHGzJyGW4KH.sMfVXg8Bs8RcNze');

    INSERT INTO usuarios (Nombre, Apellidos, Email, Rol, Password) VALUES
    ('chef', 'ejemplo', 'chef@marketchef.com', 'Chef', '$2y$10$c0GHSBjm7uYQN8fbczpQp.ccKIsKKqsIeegLTZa5pflAtbOvMrSiu');



-- Tabla Chefs
CREATE TABLE `chefs` (
 `Usuario` int(11) NOT NULL,
 `DNI` varchar(9) NOT NULL,
 `Cuenta_bancaria` varchar(255) NOT NULL,
 UNIQUE KEY `DNI` (`DNI`),
 KEY `fk_c_usuario` (`Usuario`),
 CONSTRAINT `fk_c_usuario` FOREIGN KEY (`Usuario`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- Tabla Recetas

/* 
Cabe destacar que para añadir una nueva fila a esta tabla, debemos añadir los pasos en formato JSON, lo que significa que debe seguir este esquema:

{
    "1": "explicacion paso 1",
    "2": "explicacion paso 2",
    "...": "..."
}

todo dentro de las comillas que delimitan el valor de la columna pasos.

*/
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
 UNIQUE KEY `Nombre` (`Nombre`),
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


    -- Ingredientes precargados

    INSERT INTO `ingredientes` (`Nombre`) VALUES

    -- Líquidos y Grasas
        ("Agua"),
        ("Aceite de oliva"),
        ("Aceite de girasol"),
        ("Aceite de coco"),
        ("Aceite de sésamo"),
        ("Aceite de aguacate"),
        ("Aceite de nuez"),
        ("Vinagre"),
        ("Vinagre balsámico"),
        ("Salsa de soja"),

    -- Básicos y Condimentos
        ("Sal"),
        ("Azúcar"),
        ("Azúcar moreno"),
        ("Azúcar glas"),
        ("Miel"),
        ("Mostaza"),
        ("Mostaza Dijon"),
        ("Cacao en polvo"),
        ("Chocolate con leche"),
        ("Chocolate blanco"),
        ("Chocolate negro"),
        ("Jarabe de arce"),
        ("Sirope de agave"),

    -- Cereales y Harinas
        ("Harina de trigo"),
        ("Harina de maíz"),
        ("Harina de almendra"),
        ("Harina de arroz"),
        ("Harina de avena"),
        ("Harina integral"),
        ("Avena"),
        ("Cuscús"),
        ("Quinoa"),
        ("Sémola de trigo"),
        ("Trigo sarraceno"),

    -- Lácteos y Derivados
        ("Leche"),
        ("Leche condensada"),
        ("Leche evaporada"),
        ("Yogur"),
        ("Mantequilla"),
        ("Margarina"),
        ("Nata líquida"),
        ("Crema agria"),
        ("Queso"),
        ("Queso azul"),
        ("Queso feta"),
        ("Queso ricotta"),
        ("Queso parmesano"),
        ("Queso gouda"),
        ("Queso mozzarella"),

    -- Carnes y Embutidos
        ("Ternera"),
        ("Buey"),
        ("Cerdo"),
        ("Pollo"),
        ("Cordero"),
        ("Pavo"),
        ("Conejo"),
        ("Codorniz"),
        ("Pato"),
        ("Jamón"),
        ("Bacon"),
        ("Chorizo"),
        ("Salchichón"),
        ("Morcilla"),
        ("Lomo de cerdo"),
        ("Grasa de cerdo (manteca)"),

    -- Pescados y Mariscos
        ("Pescado blanco"),
        ("Salmón"),
        ("Atún"),
        ("Gambas"),
        ("Langostinos"),
        ("Calamares"),
        ("Almejas"),
        ("Mejillones"),
        ("Merluza"),
        ("Dorada"),
        ("Lubina"),
        ("Bacalao"),
        ("Trucha"),
        ("Pulpo"),
        ("Cangrejo"),
        ("Erizo de mar"),
        ("Vieiras"),
    
    -- Verduras y Hortalizas
        ("Cebolla"),
        ("Ajo"),
        ("Tomate"),
        ("Zanahoria"),
        ("Patata"),
        ("Pimiento rojo"),
        ("Pimiento verde"),
        ("Pimiento amarillo"),
        ("Champiñones"),
        ("Espinacas"),
        ("Lechuga"),
        ("Pepino"),
        ("Brócoli"),
        ("Coliflor"),
        ("Berenjena"),
        ("Calabacín"),
        ("Maíz"),
        ("Nabo"),
        ("Rábanos"),
        ("Remolacha"),
        ("Endivias"),
        ("Coles de Bruselas"),
        ("Acelgas"),
        ("Puerro"),
        ("Hinojo"),
    
    -- Legumbres
        ("Lentejas"),
        ("Garbanzos"),
        ("Alubias"),
        ("Soja"),
        ("Guisantes"),
        ("Habas"),
        ("Frijoles negros"),
    
    -- Frutas
        ("Manzana"),
        ("Pera"),
        ("Plátano"),
        ("Naranja"),
        ("Limón"),
        ("Fresas"),
        ("Cereza"),
        ("Mango"),
        ("Piña"),
        ("Uvas"),
        ("Melón"),
        ("Sandía"),
        ("Papaya"),
        ("Kiwi"),
        ("Maracuyá"),
        ("Granada"),
        ("Ciruela"),
        ("Higos"),
        ("Coco"),
    
    -- Frutos Secos y Semillas
        ("Nueces"),
        ("Almendras"),
        ("Avellanas"),
        ("Anacardos"),
        ("Pistachos"),
        ("Semillas de lino"),
        ("Semillas de chía"),
        ("Semillas de girasol"),
        ("Semillas de calabaza"),
        ("Castañas"),
    
    -- Especias y Condimentos
        ("Pimienta negra"),
        ("Pimienta blanca"),
        ("Orégano"),
        ("Tomillo"),
        ("Romero"),
        ("Perejil"),
        ("Cilantro"),
        ("Canela"),
        ("Jengibre"),
        ("Curry"),
        ("Curry rojo"),
        ("Curry verde"),
        ("Comino"),
        ("Pimentón"),
        ("Pimentón picante"),
        ("Vainilla"),
        ("Anís estrellado"),
        ("Nuez moscada"),
        ("Clavo de olor"),
        ("Estragón"),
        ("Albahaca"),
        ("Eneldo"),
    
    -- Salsas y Aderezos
        ("Salsa barbacoa"),
        ("Salsa teriyaki"),
        ("Salsa de ostras"),
        ("Salsa de pescado"),
        ("Salsa worcestershire"),
    
    -- Bebidas y Otros
        ("Café"),
        ("Té verde"),
        ("Té negro"),
        ("Té de manzanilla"),
        ("Ron"),
        ("Vino blanco"),
        ("Vino tinto"),
        ("Cerveza");



-- Tabla Alérgenos

CREATE TABLE `alergenos` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 UNIQUE KEY `Nombre` (`Nombre`),
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


-- Tabla Magnitudes

CREATE TABLE `magnitudes` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Magnitud` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`),
 UNIQUE KEY `Magnitud` (`Magnitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Datos de la tabla magnitudes
        INSERT INTO magnitudes (Magnitud) VALUES
        ('gramos'),
        ('kilogramos'),
        ('mililitros'),
        ('litros'),
        ('tazas'),
        ('cucharadas'),
        ('cucharaditas'),
        ('pizca'),
        ('unidad'),
        ('rebanada'),
        ('diente'),
        ('puñado'),
        ('chorro'),
        ('gota'),
        ('lata'),
        ('botella'),
        ('vaso'),
        ('copa'),
        ('onza'),
        ('libra');



-- Tabla Receta_Ingrediente

CREATE TABLE `receta_ingrediente` (
 `Receta` int(11) NOT NULL,
 `Ingrediente` varchar(100) NOT NULL,
 `Cantidad` varchar(100) NOT NULL,
 `Magnitud` varchar(100) NOT NULL,
 KEY `fk_ri_receta` (`Receta`),
 KEY `fk_ri_ingrediente` (`Ingrediente`),
 KEY `fk_ri_magnitud` (`Magnitud`),
 CONSTRAINT `fk_ri_receta` FOREIGN KEY (`Receta`) REFERENCES `recetas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `fk_ri_ingrediente` FOREIGN KEY (`Ingrediente`) REFERENCES `ingredientes` (`Nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `fk_ri_magnitud` FOREIGN KEY (`Magnitud`) REFERENCES `magnitudes` (`Magnitud`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Tabla Ingrediente_Alérgeno

CREATE TABLE `ingrediente_alergeno` (
 `Ingrediente` varchar(100) NOT NULL,
 `Alergeno` varchar(100) NOT NULL,
 KEY `fk_ia_ingrediente` (`Ingrediente`),
 KEY `fk_ia_alergeno` (`Alergeno`),
 CONSTRAINT `fk_ia_alergeno` FOREIGN KEY (`Alergeno`) REFERENCES `alergenos` (`Nombre`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `fk_ia_ingrediente` FOREIGN KEY (`Ingrediente`) REFERENCES `ingredientes` (`Nombre`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


       INSERT INTO ingrediente_alergeno (ingrediente, alergeno) VALUES

            -- Gluten
            ('Harina de trigo', 'Gluten'),
            ('Harina de avena', 'Gluten'),
            ('Harina integral', 'Gluten'),
            ('Avena', 'Gluten'),
            ('Cuscús', 'Gluten'),
            ('Sémola de trigo', 'Gluten'),
            ('Cerveza', 'Gluten'),

            -- Lácteos
            ('Leche', 'Lácteos'),
            ('Leche condensada', 'Lácteos'),
            ('Leche evaporada', 'Lácteos'),
            ('Yogur', 'Lácteos'),
            ('Mantequilla', 'Lácteos'),
            ('Nata líquida', 'Lácteos'),
            ('Crema agria', 'Lácteos'),
            ('Queso', 'Lácteos'),
            ('Queso azul', 'Lácteos'),
            ('Queso feta', 'Lácteos'),
            ('Queso ricotta', 'Lácteos'),
            ('Queso parmesano', 'Lácteos'),
            ('Queso gouda', 'Lácteos'),
            ('Queso mozzarella', 'Lácteos'),
            ('Chocolate con leche', 'Lácteos'),
            ('Chocolate blanco', 'Lácteos'),

            -- Frutos secos
            ('Harina de almendra', 'Frutos secos'),
            ('Nueces', 'Frutos secos'),
            ('Almendras', 'Frutos secos'),
            ('Avellanas', 'Frutos secos'),
            ('Anacardos', 'Frutos secos'),
            ('Pistachos', 'Frutos secos'),
            ('Aceite de nuez', 'Frutos secos'),

            -- Soja
            ('Soja', 'Soja'),
            ('Salsa de soja', 'Soja'),

            -- Sésamo
            ('Aceite de sésamo', 'Sesamo'),

            -- Mostaza
            ('Mostaza', 'Mostaza'),
            ('Mostaza Dijon', 'Mostaza'),

            -- Pescado
            ('Pescado blanco', 'Pescado'),
            ('Salmón', 'Pescado'),
            ('Atún', 'Pescado'),
            ('Merluza', 'Pescado'),
            ('Dorada', 'Pescado'),
            ('Lubina', 'Pescado'),
            ('Bacalao', 'Pescado'),
            ('Trucha', 'Pescado'),

            -- Crustáceos
            ('Gambas', 'Crustáceos'),
            ('Langostinos', 'Crustáceos'),
            ('Cangrejo', 'Crustáceos'),

            -- Moluscos
            ('Calamares', 'Moluscos'),
            ('Almejas', 'Moluscos'),
            ('Mejillones', 'Moluscos'),
            ('Pulpo', 'Moluscos'),
            ('Erizo de mar', 'Moluscos'),
            ('Vieiras', 'Moluscos'),

            -- Sulfitos
            ('Vinagre balsámico', 'Sulfitos'),
            ('Vino blanco', 'Sulfitos'),
            ('Vino tinto', 'Sulfitos'),
            ('Cerveza', 'Sulfitos');



-- Tabla Etiquetas

CREATE TABLE `etiquetas` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Etiqueta` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`),
 UNIQUE KEY `Etiqueta` (`Etiqueta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


        -- Datos de la tabla etiquetas
        INSERT INTO etiquetas (Etiqueta) VALUES

        -- Etiquetas por Tipo de Plato
        ('Entrante'),
        ('Principal'),
        ('Postre'),
        ('Aperitivo'),
        ('Guarnición'),
        ('Sopa'),
        ('Ensalada'),
        ('Bocadillo'),
        ('Tarta'),
        ('Bebida'),
        ('Salsa'),
        -- Etiquetas por Tipo de Dieta
        ('Vegetariano'),
        ('Vegano'),
        ('Sin gluten'),
        ('Sin lactosa'),
        ('Sin azúcar'),
        ('Bajo en carbohidratos'),
        ('Alto en proteínas'),
        ('Keto'),
        ('Paleo'),
        -- Etiquetas por Ingrediente Principal
        ('Con pollo'),
        ('Con ternera'),
        ('Con cerdo'),
        ('Con pescado'),
        ('Con marisco'),
        ('Con verduras'),
        ('Con pasta'),
        ('Con arroz'),
        ('Con legumbres'),
        ('Con huevos'),
        ('Con queso'),
        -- Etiquetas por Método de Cocción
        ('Al horno'),
        ('A la plancha'),
        ('Frito'),
        ('Hervido'),
        ('Al vapor'),
        ('A la parrilla'),
        ('A baja temperatura'),
        -- Etiquetas por Cocina Internacional
        ('Italiana'),
        ('Mexicana'),
        ('Japonesa'),
        ('China'),
        ('India'),
        ('Mediterránea'),
        ('Árabe'),
        ('Francesa'),
        ('Americana'),
        -- Etiquetas por Ocasión
        ('Navidad'),
        ('Semana Santa'),
        ('Verano'),
        ('Invierno'),
        ('Cumpleaños'),
        ('Cena rápida'),
        ('Comida saludable'),
        -- Etiquetas de Dificultad y Tiempo
        ('Fácil'),
        ('Media'),
        ('Difícil'),
        ('Rápida'),
        ('Larga');


-- Tabla Receta_Etiqueta

CREATE TABLE `receta_etiqueta` (
 `Receta` int(11) NOT NULL,
 `Etiqueta` varchar(100) NOT NULL,
 KEY `fk_re_receta` (`Receta`),
 KEY `fk_re_etiqueta` (`Etiqueta`),
 CONSTRAINT `fk_re_receta` FOREIGN KEY (`Receta`) REFERENCES `recetas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `fk_re_etiqueta` FOREIGN KEY (`Etiqueta`) REFERENCES `etiquetas` (`Etiqueta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;






-- Eliminar el usuario 'MarketChef' si ya existe
DROP USER IF EXISTS 'MarketChef'@'%';

-- Crear el usuario 'MarketChef' con la contraseña 'MarketChef'
CREATE USER 'MarketChef'@'%' IDENTIFIED BY 'MarketChef';

-- Conceder todos los permisos sobre la base de datos MarketChef a este usuario
GRANT ALL PRIVILEGES ON MarketChef.* TO 'MarketChef'@'%';

-- Aplicar los cambios
FLUSH PRIVILEGES;


-- -- Los triggers que se crearán son:

-- -- Trigger que actualiza las valoraciones de las recetas para cada nueva valoración creada:

-- DELIMITER $$

-- CREATE TRIGGER `actualizar_media_valoracion` 
-- AFTER INSERT ON `valoraciones`
-- FOR EACH ROW 
-- BEGIN
--     UPDATE recetas
--     SET Valoracion = (SELECT AVG(Puntuacion) FROM valoraciones WHERE Receta = NEW.Receta) WHERE ID = NEW.Receta;
-- END $$

-- DELIMITER ;