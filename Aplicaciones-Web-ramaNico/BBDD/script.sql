
/*

Este script está pensado para ser copiado y ejecutado. Contiene instrucciones para crear todas
las tablas, datos, y triggers que nuestra BBDD tiene.

Los datos que se cargarán son los más básicos, un usuario de cada tipo y la tabla de alérgenos completa.

*/

-- Creación de la BBDD si no está creada y acceso
CREATE DATABASE IF NOT EXISTS marketchefn;
USE marketchefn;

/*

Antes de crear todas las tablas, vamos a borrarlas en caso de que ya existan y no estén bien configuradas
Como hay tablas que dependen unas de otras (relaciones y claves foráneas), hay que borrarlas en el orden inverso de creación

*/
DROP TABLE IF EXISTS platos_ingredientes;
DROP TABLE IF EXISTS platos;

DROP TABLE IF EXISTS etiquetas;
DROP TABLE IF EXISTS magnitudes;
DROP TABLE IF EXISTS ingredientes;
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


    -- Datos de la tabla usuarios
    INSERT INTO usuarios (Nombre, Apellidos, Email, Rol, Password, Ruta) 
    VALUES
        ('usuario', 'ejemplo', 'usuario@marketchef.com', 'User', '$2y$10$wjhoam2JWbGg4I4NRGoJF.ZUsLITJlV05Vg9Jp6GUBMdOWAlCI7FO', 'avatar_ejemplo.jpg'),       -- Contraseña: usuario
        ('admin', 'ejemplo', 'admin@marketchef.com', 'Admin', '$2y$10$aAfWpoA8/09hASfXru8j6.PUC1kHGzJyGW4KH.sMfVXg8Bs8RcNze', 'avatar_ejemplo.jpg'),          -- Contraseña: admin
        ('chef', 'ejemplo', 'chef@marketchef.com', 'Chef', '$2y$10$c0GHSBjm7uYQN8fbczpQp.ccKIsKKqsIeegLTZa5pflAtbOvMrSiu', 'avatar_ejemplo.jpg'),             -- Contraseña: chef
        ('chef2', 'ejemplo', 'chef2@marketchef.com', 'Chef', '$2y$10$c0GHSBjm7uYQN8fbczpQp.ccKIsKKqsIeegLTZa5pflAtbOvMrSiu', 'avatar_ejemplo.jpg'),           -- Contraseña: chef
        ('chef3', 'ejemplo', 'chef3@marketchef.com', 'Chef', '$2y$10$c0GHSBjm7uYQN8fbczpQp.ccKIsKKqsIeegLTZa5pflAtbOvMrSiu', 'avatar_ejemplo.jpg');           -- Contraseña: chef


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

    INSERT INTO chefs (Usuario, DNI, Cuenta_bancaria, Saldo) 
    VALUES
        (3, '12345678A', 'ES1234567890123456789012', 0),
        (4, '23456789B', 'ES2345678901234567890123', 0),
        (5, '34567890C', 'ES3456789012345678901234', 0);



-- Tabla Ingredientes

CREATE TABLE `ingredientes` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 UNIQUE KEY `Nombre` (`Nombre`),
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


    -- Ingredientes precargados

    INSERT INTO ingredientes (Nombre) 
    VALUES

        -- Líquidos y Grasas
        ("Agua"),               -- 1
        ("Aceite de oliva"),    -- 2
        ("Aceite de girasol"),  -- 3
        ("Vinagre"),           -- 4
        ("Salsa de soja"),     -- 5

        -- Básicos y Condimentos
        ("Sal"),              -- 6            
        ("Azúcar"),          -- 7         
        ("Azúcar moreno"),   -- 8
        ("Azúcar glas"),     -- 9
        ("Miel"),           -- 10
        ("Mostaza"),        -- 11
        ("Cacao en polvo"), -- 12
        ("Chocolate con leche"), -- 13
        ("Chocolate blanco"), -- 14
        ("Chocolate negro"), -- 15
        ("Huevo"),         -- 16

        -- Cereales y Harinas
        ("Harina"),        -- 17
        ("Avena"),        -- 18
        ("Cuscús"),       -- 19
        ("Quinoa"),       -- 20
        ("Arroz"),        -- 21
        ("Pasta"),        -- 22
        ("Pan"),          -- 23

        -- Lácteos y Derivados
        ("Leche"),         -- 24
        ("Leche condensada"), -- 25
        ("Yogur"),         -- 26
        ("Mantequilla"),   -- 27
        ("Nata líquida"),  -- 28
        ("Crema agria"),   -- 29
        ("Queso"),         -- 30

        -- Carnes y Embutidos
        ("Ternera"),       -- 31
        ("Cerdo"),         -- 32
        ("Pollo"),         -- 33
        ("Cordero"),       -- 34
        ("Pavo"),          -- 35
        ("Conejo"),        -- 36
        ("Jamón"),         -- 37
        ("Bacon"),         -- 38
        ("Chorizo"),       -- 39
        ("Salchichón"),    -- 40
        ("Morcilla"),      -- 41
        
        -- Pescados y Mariscos
        ("Salmón"),        -- 42
        ("Atún"),          -- 43
        ("Gambas"),        -- 44
        ("Langostinos"),   -- 45
        ("Calamares"),     -- 46
        ("Almejas"),       -- 47
        ("Mejillones"),    -- 48
        ("Merluza"),       -- 49
        ("Dorada"),        -- 50
        ("Lubina"),        -- 51
        ("Bacalao"),       -- 52
        ("Pulpo"),         -- 53
        ("Cangrejo"),      -- 54

        -- Verduras y Hortalizas
        ("Cebolla"),       -- 55
        ("Ajo"),           -- 56
        ("Tomate"),        -- 57
        ("Zanahoria"),     -- 58
        ("Patata"),        -- 59
        ("Pimiento rojo"), -- 60
        ("Pimiento verde"),-- 61
        ("Pimiento amarillo"), -- 62
        ("Champiñones"),   -- 63
        ("Espinacas"),     -- 64
        ("Lechuga"),       -- 65
        ("Pepino"),        -- 66
        ("Brócoli"),       -- 67
        ("Coliflor"),      -- 68
        ("Berenjena"),     -- 69
        ("Calabacín"),     -- 70
        ("Maíz"),          -- 71
        ("Aguacate"),      -- 72
        ("Alga nori"),     -- 73

        -- Legumbres
        ("Lentejas"),      -- 74
        ("Garbanzos"),     -- 75
        ("Alubias"),       -- 76
        ("Soja"),          -- 77
        ("Guisantes"),     -- 78

        -- Frutas
        ("Manzana"),       -- 79
        ("Pera"),          -- 80
        ("Plátano"),       -- 81
        ("Naranja"),       -- 82
        ("Limón"),         -- 83
        ("Fresas"),        -- 84
        ("Cereza"),        -- 85
        ("Mango"),         -- 86
        ("Piña"),          -- 87
        ("Uvas"),          -- 88
        ("Melón"),         -- 89
        ("Sandía"),        -- 90

        -- Frutos Secos y Semillas
        ("Nueces"),        -- 91
        ("Almendras"),     -- 92
        ("Avellanas"),     -- 93
        ("Anacardos"),     -- 94
        ("Pistachos"),     -- 95
        ("Castañas"),      -- 96

        -- Especias y Condimentos
        ("Pimienta negra"),-- 97
        ("Orégano"),       -- 98
        ("Tomillo"),       -- 99
        ("Romero"),        -- 100
        ("Perejil"),       -- 101
        ("Cilantro"),      -- 102
        ("Canela"),        -- 103
        ("Jengibre"),      -- 104
        ("Curry"),         -- 105
        ("Pimentón"),      -- 106
        ("Vainilla"),      -- 107
        ("Nuez moscada"),  -- 108

        -- Salsas y Aderezos
        ("Salsa barbacoa"),-- 109
        ("Salsa teriyaki"),-- 110

        -- Bebidas y Otros
        ("Vino blanco"),   -- 111
        ("Vino tinto"),    -- 112
        ("Cerveza");       -- 113





-- Tabla Magnitudes
CREATE TABLE `magnitudes` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`),
 UNIQUE KEY `Nombre` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

        -- Datos de la tabla magnitudes
    INSERT INTO magnitudes (Nombre) VALUES
        ('Gramos (g)'),
        ('Kilogramos (kg)'),
        ('Mililitros (ml)'),
        ('Litros (l)'),
        ('Cucharada'),
        ('Unidad');





-- Tabla Etiquetas
CREATE TABLE `etiquetas` (
 `ID` int(11) NOT NULL AUTO_INCREMENT,
 `Nombre` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`),
 UNIQUE KEY `Nombre` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

    -- Datos de la tabla etiquetas
    INSERT INTO etiquetas (Nombre) 
    VALUES

        --    Etiquetas por Tipo de Plato
        ('Entrante'),   --  1
        ('Principal'),  --  2
        ('Postre'),     --  3 
        ('Sopa'),       --  4
        ('Ensalada'),   --  5
        ('Tarta'),      --  6

        --  Etiquetas por Tipo de Dieta
        ('Vegano'),     -- 7
        ('Sin gluten'), -- 8
        ('Sin lactosa'),    -- 9
        ('Sin azúcar'), -- 10

        --  Etiquetas por Método de Cocción
        ('Al horno'),   -- 11
        ('A la plancha'),   -- 12
        ('Frito'),  -- 13
        ('Hervido'),    -- 14
        ('Al vapor'),   -- 15
        ('A la parrilla'),  -- 16
        ('A baja temperatura'), -- 17

        --  Etiquetas por Cocina Internacional
        ('Italiana'),   -- 18
        ('Mexicana'),   -- 19
        ('Japonesa'),   -- 20
        ('China'),      -- 21
        ('India'),      -- 22
        ('Mediterránea'),   -- 23
        ('Árabe'),      -- 24
        ('Francesa'),   -- 25
        ('Americana'),   -- 26

        --  Etiquetas por Ocasión
        ('Navidad'),    -- 27
        ('Verano'),     -- 28
        ('Invierno'),   -- 29
        ('Cumpleaños'),  -- 30  
        ('Cena rápida'),        -- 31
        ('Comida saludable'),   -- 32

        --  Etiquetas de Dificultad y Tiempo
        ('Fácil'),  -- 33
        ('Media'),  -- 34
        ('Difícil');    -- 35



-- Crear tabla 'platos' si no existe
CREATE TABLE platos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Crear tabla 'platos_ingredientes'
CREATE TABLE platos_ingredientes (
    plato_id INT NOT NULL,
    ingrediente_id INT NOT NULL,
    PRIMARY KEY (plato_id, ingrediente_id),
    FOREIGN KEY (plato_id) REFERENCES platos(id) ON DELETE CASCADE,
    FOREIGN KEY (ingrediente_id) REFERENCES ingredientes(id) ON DELETE CASCADE
);

-- Paella Valenciana
INSERT INTO platos (nombre) VALUES ('Paella Valenciana');
SET @plato_id := LAST_INSERT_ID();
INSERT INTO platos_ingredientes (plato_id, ingrediente_id) VALUES
(@plato_id, 21),  -- Arroz
(@plato_id, 44),  -- Gambas
(@plato_id, 46),  -- Calamares
(@plato_id, 55),  -- Cebolla
(@plato_id, 6),   -- Sal
(@plato_id, 45),  -- Mejillones
(@plato_id, 48);  -- Guisantes

-- Tortilla de Patatas
INSERT INTO platos (nombre) VALUES ('Tortilla de Patatas');
SET @plato_id := LAST_INSERT_ID();
INSERT INTO platos_ingredientes (plato_id, ingrediente_id) VALUES
(@plato_id, 16),  -- Huevo
(@plato_id, 59),  -- Patata
(@plato_id, 55),  -- Cebolla
(@plato_id, 6),   -- Sal
(@plato_id, 27);  -- Aceite de oliva

-- Gazpacho Andaluz
INSERT INTO platos (nombre) VALUES ('Gazpacho Andaluz');
SET @plato_id := LAST_INSERT_ID();
INSERT INTO platos_ingredientes (plato_id, ingrediente_id) VALUES
(@plato_id, 57),  -- Tomate
(@plato_id, 56),  -- Ajo
(@plato_id, 60),  -- Pimiento rojo
(@plato_id, 55),  -- Cebolla
(@plato_id, 4),   -- Vinagre
(@plato_id, 6),   -- Sal
(@plato_id, 1),   -- Agua
(@plato_id, 27);  -- Aceite de oliva

-- Croquetas de Jamón
INSERT INTO platos (nombre) VALUES ('Croquetas de Jamón');
SET @plato_id := LAST_INSERT_ID();
INSERT INTO platos_ingredientes (plato_id, ingrediente_id) VALUES
(@plato_id, 37),  -- Jamón
(@plato_id, 17),  -- Harina
(@plato_id, 24),  -- Leche
(@plato_id, 16),  -- Huevo
(@plato_id, 23),  -- Pan rallado
(@plato_id, 6),   -- Sal
(@plato_id, 27);  -- Mantequilla o aceite

-- Ensalada César
INSERT INTO platos (nombre) VALUES ('Ensalada César');
SET @plato_id := LAST_INSERT_ID();
INSERT INTO platos_ingredientes (plato_id, ingrediente_id) VALUES
(@plato_id, 65),  -- Lechuga romana
(@plato_id, 33),  -- Pollo
(@plato_id, 30),  -- Queso parmesano
(@plato_id, 23),  -- Pan tostado (croutons)
(@plato_id, 6),   -- Sal
(@plato_id, 27);  -- Aceite de oliva




-- Eliminar el usuario si ya existe
DROP USER IF EXISTS 'MarketChef'@'%';

-- Crear el usuario con contraseña
CREATE USER 'MarketChef'@'%' IDENTIFIED BY 'MarketChef';

-- Conceder todos los privilegios sobre la base de datos correcta
GRANT ALL PRIVILEGES ON marketchefn.* TO 'MarketChef'@'%';

-- Aplicar los cambios
FLUSH PRIVILEGES;
