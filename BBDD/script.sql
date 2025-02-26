
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
 `Verificado` BOOLEAN NOT NULL,
 PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


    -- Ingredientes precargados

    INSERT INTO `ingredientes` (`Nombre`, `Verificado`) VALUES

    -- Líquidos y Grasas
        ("Agua", 1),
        ("Aceite de oliva", 1),
        ("Aceite de girasol", 1),
        ("Aceite de coco", 1),
        ("Aceite de sésamo", 1),
        ("Aceite de aguacate", 1),
        ("Aceite de nuez", 1),
        ("Vinagre", 1),
        ("Vinagre balsámico", 1),
        ("Salsa de soja", 1),

    -- Básicos y Condimentos
        ("Sal", 1),
        ("Azúcar", 1),
        ("Azúcar moreno", 1),
        ("Azúcar glas", 1),
        ("Miel", 1),
        ("Mostaza", 1),
        ("Mostaza Dijon", 1),
        ("Cacao en polvo", 1),
        ("Chocolate con leche", 1),
        ("Chocolate blanco", 1),
        ("Chocolate negro", 1),
        ("Jarabe de arce", 1),
        ("Sirope de agave", 1),

    -- Cereales y Harinas
        ("Harina de trigo", 1),
        ("Harina de maíz", 1),
        ("Harina de almendra", 1),
        ("Harina de arroz", 1),
        ("Harina de avena", 1),
        ("Harina integral", 1),
        ("Avena", 1),
        ("Cuscús", 1),
        ("Quinoa", 1),
        ("Sémola de trigo", 1),
        ("Trigo sarraceno", 1),

    -- Lácteos y Derivados
        ("Leche", 1),
        ("Leche condensada", 1),
        ("Leche evaporada", 1),
        ("Yogur", 1),
        ("Mantequilla", 1),
        ("Margarina", 1),
        ("Nata líquida", 1),
        ("Crema agria", 1),
        ("Queso", 1),
        ("Queso azul", 1),
        ("Queso feta", 1),
        ("Queso ricotta", 1),
        ("Queso parmesano", 1),
        ("Queso gouda", 1),
        ("Queso mozzarella", 1),

    -- Carnes y Embutidos
        ("Ternera", 1),
        ("Buey", 1),
        ("Cerdo", 1),
        ("Pollo", 1),
        ("Cordero", 1),
        ("Pavo", 1),
        ("Conejo", 1),
        ("Codorniz", 1),
        ("Pato", 1),
        ("Jamón", 1),
        ("Bacon", 1),
        ("Chorizo", 1),
        ("Salchichón", 1),
        ("Morcilla", 1),
        ("Lomo de cerdo", 1),
        ("Grasa de cerdo (manteca)", 1),

    -- Pescados y Mariscos
        ("Pescado blanco", 1),
        ("Salmón", 1),
        ("Atún", 1),
        ("Gambas", 1),
        ("Langostinos", 1),
        ("Calamares", 1),
        ("Almejas", 1),
        ("Mejillones", 1),
        ("Merluza", 1),
        ("Dorada", 1),
        ("Lubina", 1),
        ("Bacalao", 1),
        ("Trucha", 1),
        ("Pulpo", 1),
        ("Cangrejo", 1),
        ("Erizo de mar", 1),
        ("Vieiras", 1),
    
    -- Verduras y Hortalizas
        ("Cebolla", 1),
        ("Ajo", 1),
        ("Tomate", 1),
        ("Zanahoria", 1),
        ("Patata", 1),
        ("Pimiento rojo", 1),
        ("Pimiento verde", 1),
        ("Pimiento amarillo", 1),
        ("Champiñones", 1),
        ("Espinacas", 1),
        ("Lechuga", 1),
        ("Pepino", 1),
        ("Brócoli", 1),
        ("Coliflor", 1),
        ("Berenjena", 1),
        ("Calabacín", 1),
        ("Maíz", 1),
        ("Nabo", 1),
        ("Rábanos", 1),
        ("Remolacha", 1),
        ("Endivias", 1),
        ("Coles de Bruselas", 1),
        ("Acelgas", 1),
        ("Puerro", 1),
        ("Hinojo", 1),
    
    -- Legumbres
        ("Lentejas", 1),
        ("Garbanzos", 1),
        ("Alubias", 1),
        ("Soja", 1),
        ("Guisantes", 1),
        ("Habas", 1),
        ("Frijoles negros", 1),
    
    -- Frutas
        ("Manzana", 1),
        ("Pera", 1),
        ("Plátano", 1),
        ("Naranja", 1),
        ("Limón", 1),
        ("Fresas", 1),
        ("Cereza", 1),
        ("Mango", 1),
        ("Piña", 1),
        ("Uvas", 1),
        ("Melón", 1),
        ("Sandía", 1),
        ("Papaya", 1),
        ("Kiwi", 1),
        ("Maracuyá", 1),
        ("Granada", 1),
        ("Ciruela", 1),
        ("Higos", 1),
        ("Coco", 1),
    
    -- Frutos Secos y Semillas
        ("Nueces", 1),
        ("Almendras", 1),
        ("Avellanas", 1),
        ("Anacardos", 1),
        ("Pistachos", 1),
        ("Semillas de lino", 1),
        ("Semillas de chía", 1),
        ("Semillas de girasol", 1),
        ("Semillas de calabaza", 1),
        ("Castañas", 1),
    
    -- Especias y Condimentos
        ("Pimienta negra", 1),
        ("Pimienta blanca", 1),
        ("Orégano", 1),
        ("Tomillo", 1),
        ("Romero", 1),
        ("Perejil", 1),
        ("Cilantro", 1),
        ("Canela", 1),
        ("Jengibre", 1),
        ("Curry", 1),
        ("Curry rojo", 1),
        ("Curry verde", 1),
        ("Comino", 1),
        ("Pimentón", 1),
        ("Pimentón picante", 1),
        ("Vainilla", 1),
        ("Anís estrellado", 1),
        ("Nuez moscada", 1),
        ("Clavo de olor", 1),
        ("Estragón", 1),
        ("Albahaca", 1),
        ("Eneldo", 1),
    
    -- Salsas y Aderezos
        ("Salsa barbacoa", 1),
        ("Salsa teriyaki", 1),
        ("Salsa de ostras", 1),
        ("Salsa de pescado", 1),
        ("Salsa worcestershire", 1),
    
    -- Bebidas y Otros
        ("Café", 1),
        ("Té verde", 1),
        ("Té negro", 1),
        ("Té de manzanilla", 1),
        ("Ron", 1),
        ("Vino blanco", 1),
        ("Vino tinto", 1),
        ("Cerveza", 1);



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


-- Eliminar el usuario 'MarketChef' si ya existe
DROP USER IF EXISTS 'MarketChef'@'%';

-- Crear el usuario 'MarketChef' con la contraseña 'MarketChef'
CREATE USER 'MarketChef'@'%' IDENTIFIED BY 'MarketChef';

-- Conceder todos los permisos sobre la base de datos MarketChef a este usuario
GRANT ALL PRIVILEGES ON MarketChef.* TO 'MarketChef'@'%';

-- Aplicar los cambios
FLUSH PRIVILEGES;


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