# MarketChef

¡Bienvenidos a MarketChef!

MarketChef es una plataforma única donde los apasionados de la cocina pueden comprar y vender recetas originales de manera segura y organizada. ¿Tienes una receta exclusiva que has perfeccionado? Véndela. ¿Buscas inspiración para una cena especial o un menú innovador? ¡Encuéntrala en MarketChef!

A diferencia de otras plataformas de cocina, aquí las recetas son activos valiosos, permitiendo a los creadores monetizar su conocimiento culinario y a los compradores acceder a contenido exclusivo de calidad, proporcionado solamente por Chefs verificados.

# Local

## Creación de la Base de Datos

Para poder interactuar con nuestra aplicación en Local, se deben seguir estos pasos:
1. Ejecutar XAMPP y activar Apache y MySQL.
2. Acceder a phpMyAdmin para poder manejar las BBDD.
3. Acceder a la pestaña SQL.
4. Copiar el contenido del archivo **script.sql** que se encuentra en esta carpeta.
5. Pulsar en Continuar. 

Para más información sobre el contenido, cómo introducir algunas filas y otras explicaciones de nuestra Base de Datos, leer el archivo **script.sql**.


¡Enhorabuena! Ya tienes cargada nuestra base de datos. De ahora en adelante los datos que varíen lo harán solo en tu dispositivo.

# VPS
## Información

Esta aplicación además de poder usarse en local como esta explicado más arriba, ha sido desplegada en el servidor VPS proporcionado por la universidad, concretamente podemos encontrarla en este enlace: https://vm016-beta.containers.fdi.ucm.es/Marketchef 

### Guía de despliegue (UCM)

Para poder subir y desplegar de cero correctamente la aplicación en el VPS, deberás seguir las instrucciones disponibles en el campus virtual, conectándote a guacamole desde el *vm016* que se nos ha proporcionado como préstamo de la universidad, copiando y descomprimiendo la práctica en /var/www/produccion y ejecutando el comando fix-www-acl.

Finalmente, el código es robusto y correcto, por lo que no haría falta cambiar nada en los archivos a excepción del config.php, donde tendremos que cambiar el HOST de **'localhost'** a **'vm016.db.swarm.test'**. Estos cambios se deben hacer directamente desde la consola de guacamole.

Una vez desplegada la aplicación, ya se puede acceder al enlace descrito anteriormente y podrás ver toda la aplicación funcionando.

---

Los cambios que se puedan realizar en la base de datos durante el uso de la aplicación en ese sitio web, como crear una nueva receta, son visibles a todas las personas que tengan acceso a dicha página web.


# Acceso

Para acceder, hay precargados una cuenta con cada tipo de usuario, a modo de test y ejemplo:

    - Rol: User -> 
        email: usuario@marketchef.com
        contraseña: usuario
        (resto de valores insignificantes)
    
    - Rol: Chef ->
        email: chef@marketchef.com
        contraseña: chef
        (resto de valores insignificantes)

    - Rol: Admin ->
        email: admin@marketchef.com
        contraseña: admin
        (resto de valores insignificantes)

    Además de estas tres cuentas, tenemos varios chefs más, así como un usuario y un admin extra.

    - Rol: User -> 
        email: laura@marketchef.com
        contraseña: usuario
        (resto de valores insignificantes)

    - Rol: Admin ->
        email: juan@marketchef.com
        contraseña: admin
        (resto de valores insignificantes)

    - Rol: Chef ->
        email: chef2@marketchef.com
        contraseña: chef
        (resto de valores insignificantes)

    - Rol: Chef ->
        email: chef3@marketchef.com
        contraseña: chef
        (resto de valores insignificantes)
    
# Importante
*Esta versión, tanto en local como en el VPS, está pensada para ser utilizada con fines académicos y con el objetivo de ser compartida y accesible tanto por todos los creadores de MarketChef, como por el profesor encargado de evaluar la plataforma y sus entrañas.* 

