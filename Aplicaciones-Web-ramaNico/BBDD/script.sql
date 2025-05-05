
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
  `Ruta` varchar(100) NOT NULL,
 PRIMARY KEY (`ID`),
 KEY `fk_recetas_autor` (`Autor`),
 CONSTRAINT `fk_recetas_autor` FOREIGN KEY (`Autor`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Recetas Precargadas
INSERT INTO recetas (Nombre, Autor, Descripcion, Pasos, Tiempo, Precio, Fecha_Creacion, Valoracion, Ruta) 
VALUES
    ('Paella Valenciana', 
    3, 
    'Clásico plato español a base de arroz, pollo, conejo y verduras.', 
    '[
        "Calentar el aceite en una paellera.",
        "Dorar el pollo y el conejo.",
        "Añadir las verduras y sofreír.",
        "Incorporar el arroz y el caldo.",
        "Cocinar a fuego medio hasta que el arroz esté en su punto."
    ]', 
    60, 
    20.0,
    '2022-07-15 14:25:30',
    4.8, 
    'paella_valenciana.jpg'),

    ('Spaghetti Carbonara', 
    4,
    'Pasta italiana con salsa cremosa de huevo, queso y panceta.', 
    '[
        "Cocer los spaghetti en agua con sal.",
        "Saltear la panceta en una sartén.",
        "Batir los huevos con el queso.",
        "Mezclar la pasta caliente con la panceta y la salsa.",
        "Servir con pimienta negra recién molida."
    ]', 
    20, 
    10.5, 
    '2021-05-10 18:45:20',
    4.7, 
    'spaghetti_carbonara.jpg'),

    ('Tacos al Pastor', 
    5, 
    'Tacos de cerdo marinados con achiote y piña.', 
    '[
        "Marinar la carne con achiote y especias.",
        "Asar la carne en un trompo o sartén.",
        "Cortar en trozos pequeños.",
        "Servir en tortillas con piña y cebolla.",
        "Acompañar con cilantro y salsa."
    ]', 
    45, 
    15.0, 
    '2023-11-08 09:30:10',
    4.9, 
    'tacos_al_pastor.jpg'),

    ('Sushi de Salmón', 
    3, 
    'Rollos de sushi rellenos de arroz y salmón fresco.', 
    '[
        "Lavar y cocinar el arroz de sushi.",
        "Extender el arroz sobre una hoja de alga nori.",
        "Añadir tiras de salmón y aguacate.",
        "Enrollar y cortar en piezas.",
        "Servir con salsa de soja y wasabi."
    ]', 
    40, 
    25.0, 
    '2020-02-20 12:15:45',
    4.6, 
    'sushi_de_salmon.jpg'),

    ('Hamburguesa Clásica', 
    4, 
    'Hamburguesa de ternera con queso, lechuga y tomate.', 
    '[
        "Formar las hamburguesas con carne molida.",
        "Cocinar en una sartén o parrilla.",
        "Tostar el pan de hamburguesa.",
        "Montar con lechuga, tomate y queso.",
        "Acompañar con papas fritas."
    ]', 
    25, 
    12.0, 
    '2024-01-05 17:50:55',
    4.5, 
    'hamburguesa_clasica.jpg'),

    ('Ensalada César', 
    5, 
    'Ensalada de lechuga, pollo, croutons y aderezo césar.', 
    '[
        "Lavar y cortar la lechuga.",
        "Preparar el aderezo mezclando mayonesa, ajo y parmesano.",
        "Saltear el pollo y cortarlo en tiras.",
        "Mezclar todos los ingredientes en un bol.",
        "Servir con más queso y croutons."
    ]', 
    15, 
    8.0,
    '2019-09-25 07:10:30', 
    4.4, 
    'ensalada_cesar.jpg'),

    ('Lasagna Bolognesa', 
    3, 
    'Capas de pasta con carne, 
    tomate y bechamel gratinadas al horno.', 
    '[
        "Preparar la salsa bolognesa con carne y tomate.",
        "Hacer la salsa bechamel.",
        "Intercalar capas de pasta, salsa y queso.",
        "Hornear a 180°C por 30 minutos.",
        "Servir caliente con parmesano."
    ]', 
    50, 
    18.0, 
    '2024-01-06 17:50:55',
    4.7, 
    'lasagna_bolognesa.jpg'),

    ('Pollo al Curry', 
    4, 
    'Pollo en salsa de curry con leche de coco.', 
    '[
        "Cortar el pollo en trozos.",
        "Saltear con cebolla y ajo.",
        "Añadir la pasta de curry y leche de coco.",
        "Cocinar a fuego lento hasta espesar.",
        "Servir con arroz basmati."
    ]', 
    35, 
    14.0, 
    '2024-09-05 17:50:55',
    4.6, 
    'pollo_al_curry.jpg'),

    ('Chili con Carne', 
    5, 
    'Guiso picante de carne con frijoles y tomate.', 
    '[
        "Sofreír la carne con cebolla y ajo.",
        "Añadir los frijoles y el tomate.",
        "Incorporar el chile y especias.",
        "Cocinar a fuego bajo por 40 minutos.",
        "Servir caliente con nachos."
    ]', 
    45, 
    16.0, 
    '2024-12-09 10:50:55',
    4.5, 
    'chili_con_carne.jpg'),

    ('Ceviche de Pescado', 
    3, 
    'Pescado marinado en limón con cebolla y cilantro.', 
    '[
        "Cortar el pescado en cubos pequeños.",
        "Marinar en jugo de limón por 30 minutos.",
        "Añadir cebolla morada, ají y cilantro.",
        "Dejar reposar en la nevera.",
        "Servir frío con maíz tostado."
    ]', 
    30, 
    13.5, 
    '2025-01-01 17:50:55',
    4.8, 
    'ceviche_de_pescado.jpg'),

    ('Risotto de Champiñones', 
    4, 
    'Arroz cremoso cocinado con caldo y champiñones.', 
    '[
        "Sofreír cebolla y ajo en mantequilla.",
        "Añadir el arroz y el vino blanco.",
        "Incorporar caldo poco a poco.",
        "Agregar los champiñones y cocinar.",
        "Servir con queso parmesano."
    ]', 
    40, 
    17.0, 
    '2024-01-25 07:50:55',
    4.7, 
    'risotto_de_champinones.jpg'),

    ('Papas a la Huancaína', 
    5, 
    'Papas cocidas con salsa de ají amarillo y queso.', 
    '[
        "Cocer las papas en agua con sal.",
        "Preparar la salsa licuando ají amarillo, queso y leche.",
        "Cortar las papas en rodajas.",
        "Servir con la salsa por encima.",
        "Acompañar con huevo y aceitunas."
    ]', 
    25,
    9.5, 
    '2024-01-05 00:50:55',
    4.6,
    'papas_a_la_huancaina.jpg'),

    ('Goulash Húngaro', 
    3, 
    'Guiso de carne con pimentón y especias.', 
    '[
        "Cortar la carne en cubos.",
        "Sofreír con cebolla y pimentón.",
        "Añadir caldo y dejar cocinar lentamente.",
        "Incorporar especias y papas.",
        "Servir caliente con pan."
    ]', 
    60, 
    22.0, 
    '2024-01-05 17:50:55',
    4.8, 
    'goulash_hungaro.jpg'),

    ('Sopa de Tomate', 
    4, 
    'Sopa cremosa de tomate con albahaca.', 
    '[
        "Sofreír cebolla y ajo en aceite de oliva.",
        "Añadir los tomates troceados.",
        "Cocinar con caldo hasta ablandar.",
        "Licuar y colar para obtener una crema suave.",
        "Servir con albahaca y croutons."
    ]', 
    30, 
    10.0, 
    '2024-01-05 17:50:55',
    4.5, 
    'sopa_de_tomate.jpg'),

    ('Moussaka', 
    5, 
    'Plato griego de berenjena, carne y bechamel.', 
    '[
        "Cortar las berenjenas en rodajas y asarlas.",
        "Preparar la carne con tomate y especias.",
        "Montar en capas con bechamel.",
        "Hornear a 180°C por 40 minutos.",
        "Servir caliente con queso rallado."
    ]', 
    50, 
    19.0, 
    '2022-01-05 17:50:55',
    4.7, 
    'moussaka.jpg');




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

-- Datos de la tabla receta_ingrediente

INSERT INTO receta_ingrediente (Receta, Ingrediente, Cantidad, Magnitud) VALUES
   
    -- Paella Valenciana (ID Receta: 1)
    (1, 21, 300.0, 1),  -- Arroz (g)
    (1, 33, 200.5, 1),  -- Pollo (g)
    (1, 36, 199.8, 1),  -- Conejo (g)
    (1, 60, 1.0, 6),    -- Pimiento rojo (unidad)
    (1, 57, 2.0, 6),    -- Tomate (unidad)
    (1, 56, 2.0, 6),    -- Ajo (unidad)
    (1, 2, 3.5, 5),     -- Aceite de oliva (cucharada)
    (1, 6, 1.0, 5),     -- Sal (cucharada)
    (1, 106, 1.2, 5),   -- Pimentón (cucharada)

    -- Spaghetti Carbonara (ID Receta: 2)
    (2, 22, 250.0, 1),  -- Pasta (g)
    (2, 38, 150.3, 1),  -- Bacon (g)
    (2, 16, 3.0, 6),    -- Huevo (unidad)
    (2, 30, 100.7, 1),  -- Queso (g)
    (2, 97, 1.0, 5),    -- Pimienta negra (cucharada)
    (2, 6, 1.0, 5),     -- Sal (cucharada)

    -- Tacos al Pastor (ID Receta: 3)
    (3, 32, 300.2, 1),  -- Cerdo (g)
    (3, 60, 1.0, 6),    -- Pimiento rojo (unidad)
    (3, 87, 2.5, 6),    -- Piña (unidad)
    (3, 56, 2.0, 6),    -- Ajo (unidad)
    (3, 102, 1.3, 5),   -- Cilantro (cucharada)
    (3, 2, 2.0, 5),     -- Aceite de oliva (cucharada)
    (3, 6, 1.0, 5),     -- Sal (cucharada)

    -- Sushi de Salmón (ID Receta: 4)
    (4, 42, 200.4, 1),  -- Salmón (g)
    (4, 21, 250.0, 1),  -- Arroz (g)
    (4, 4, 2.0, 5),     -- Vinagre (cucharada)
    (4, 7, 1.0, 5),     -- Azúcar (cucharada)
    (4, 6, 1.0, 5),     -- Sal (cucharada)
    (4, 72, 1.0, 6),    -- Aguacate (unidad)
    (4, 73, 5.0, 6),    -- Alga nori (unidad)

    -- Hamburguesa Clásica (ID Receta: 5)
    (5, 31, 200.8, 1),  -- Ternera (g)
    (5, 23, 2.0, 6),    -- Pan (unidad)
    (5, 65, 2.0, 6),    -- Lechuga (unidad)
    (5, 57, 1.0, 6),    -- Tomate (unidad)
    (5, 30, 2.0, 6),    -- Queso (unidad)
    (5, 55, 1.0, 6),    -- Cebolla (unidad)
    (5, 11, 1.0, 5),    -- Mostaza (cucharada)

    -- Ensalada César (ID Receta: 6)
    (6, 65, 1.0, 6),    -- Lechuga (unidad)
    (6, 33, 150.2, 1),  -- Pollo (g)
    (6, 30, 50.5, 1),   -- Queso (g)
    (6, 23, 2.0, 6),    -- Pan (unidad)
    (6, 11, 1.0, 5),    -- Mostaza (cucharada)
    (6, 6, 1.0, 5),     -- Sal (cucharada)

    -- Lasagna Bolognesa (ID Receta: 7)
    (7, 31, 200.6, 1),  -- Ternera (g)
    (7, 22, 6.0, 6),    -- Pasta (unidad)
    (7, 57, 3.0, 6),    -- Tomate (unidad)
    (7, 55, 1.0, 6),    -- Cebolla (unidad)
    (7, 56, 2.0, 6),    -- Ajo (unidad)
    (7, 30, 100.4, 1),  -- Queso (g)
    (7, 6, 1.0, 5),     -- Sal (cucharada)

    -- Pollo al Curry (ID Receta: 8)
    (8, 33, 200.9, 1),  -- Pollo (g)
    (8, 55, 1.0, 6),    -- Cebolla (unidad)
    (8, 56, 2.0, 6),    -- Ajo (unidad)
    (8, 105, 1.4, 5),   -- Curry (cucharada)
    (8, 24, 100.0, 3),  -- Leche (ml)

    -- Chili con Carne (ID Receta: 9)
    (9, 31, 250.3, 1),  -- Ternera (g)
    (9, 60, 1.0, 6),    -- Pimiento rojo (unidad)
    (9, 61, 1.0, 6),    -- Pimiento verde (unidad)
    (9, 57, 3.0, 6),    -- Tomate (unidad)
    (9, 76, 150.7, 1),  -- Alubias (g)
    (9, 56, 2.0, 6),    -- Ajo (unidad)

    -- Ceviche de Pescado (ID Receta: 10)
    (10, 49, 200.1, 1), -- Merluza (g)
    (10, 83, 3.0, 6),   -- Limón (unidad)
    (10, 55, 1.0, 6),   -- Cebolla (unidad)
    (10, 102, 1.0, 5),  -- Cilantro (cucharada)
    (10, 6, 1.0, 5);    -- Sal (cucharada)


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


-- Tabla Receta_Etiqueta
CREATE TABLE `receta_etiqueta` (
 `Receta` int(11) NOT NULL,
 `Etiqueta` int(11) NOT NULL,
 KEY `fk_re_receta` (`Receta`),
 KEY `fk_re_etiqueta` (`Etiqueta`),
 CONSTRAINT `fk_re_receta` FOREIGN KEY (`Receta`) REFERENCES `recetas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
 CONSTRAINT `fk_re_etiqueta` FOREIGN KEY (`Etiqueta`) REFERENCES `etiquetas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

    -- Datos de la tabla receta_etiqueta
    INSERT INTO receta_etiqueta (Receta, Etiqueta) VALUES
        -- Paella Valenciana
        (1, 2),  -- Principal
        (1, 23), -- Mediterránea
        (1, 14), -- Hervido

        -- Spaghetti Carbonara
        (2, 2),  -- Principal
        (2, 18), -- Italiana
        (2, 14), -- Hervido

        -- Tacos al Pastor
        (3, 2),  -- Principal
        (3, 19), -- Mexicana
        (3, 16), -- A la parrilla

        -- Sushi de Salmón
        (4, 2),  -- Principal
        (4, 20), -- Japonesa
        (4, 15), -- Al vapor

        -- Hamburguesa Clásica
        (5, 2),  -- Principal
        (5, 26), -- Americana
        (5, 16), -- A la parrilla

        -- Ensalada César
        (6, 5),  -- Ensalada
        (6, 26), -- Americana
        (6, 32), -- Comida saludable

        -- Lasagna Bolognesa
        (7, 2),  -- Principal
        (7, 18), -- Italiana
        (7, 11), -- Al horno

        -- Pollo al Curry
        (8, 2),  -- Principal
        (8, 22), -- India
        (8, 14), -- Hervido

        -- Chili con Carne
        (9, 2),  -- Principal
        (9, 26), -- Americana
        (9, 29), -- Invierno

        -- Ceviche de Pescado
        (10, 2),  -- Principal
        (10, 23), -- Mediterránea
        (10, 32), -- Comida saludable

        -- Risotto de Champiñones
        (11, 2),  -- Principal
        (11, 18), -- Italiana
        (11, 14), -- Hervido

        -- Papas a la Huancaína
        (12, 1),  -- Entrante
        (12, 19), -- Mexicana
        (12, 13), -- Frito

        -- Goulash Húngaro
        (13, 2),  -- Principal
        (13, 25), -- Francesa
        (13, 29), -- Invierno

        -- Sopa de Tomate
        (14, 4),  -- Sopa
        (14, 23), -- Mediterránea
        (14, 14), -- Hervido

        -- Moussaka
        (15, 2),  -- Principal
        (15, 23), -- Mediterránea
        (15, 11); -- Al horno

-- Eliminar el usuario 'MarketChef' si ya existe
DROP USER IF EXISTS 'MarketChef'@'%';

-- Crear el usuario 'MarketChef' con la contraseña 'MarketChef'
CREATE USER 'MarketChef'@'%' IDENTIFIED BY 'MarketChef';

-- Conceder todos los permisos sobre la base de datos MarketChef a este usuario
GRANT ALL PRIVILEGES ON MarketChef.* TO 'MarketChef'@'%';

-- Aplicar los cambios
FLUSH PRIVILEGES;
