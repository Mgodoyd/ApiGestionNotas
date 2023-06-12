

## Api Gestión de Notas

### Instrucciones para ejecutar el API
Sigue los siguientes pasos para ejecutar el API "Api Gestión de Notas" en tu entorno local:

1. Asegúrate de tener instalado PHP en tu sistema. Puedes verificarlo ejecutando el comando php --version en tu terminal. Si no lo tienes instalado, debes instalarlo antes de continuar.

2. Clona el repositorio del API "Api Gestión de Notas" en tu máquina local.

3. Abre una terminal o línea de comandos y navega hasta la carpeta raíz del proyecto de Laravel.

4. Copia el archivo de configuración de ejemplo .env.example y renómbralo a .env:
```bash
cp .env.example .env
```
 Luego, abre el archivo .env y configura las variables de entorno necesarias, como la conexión a la base de datos.
 
5. Genera una nueva clave de aplicación ejecutando el siguiente comando:
```bash
php artisan key:generate
```
Esto generará una clave única para tu aplicación Laravel.

6. Ejecuta el siguiente comando para instalar las dependencias del proyecto:
```bash
composer install
```
Esto descargará e instalará todas las dependencias definidas en el archivo composer.json del proyecto.

7. Crea la base de datos en tu sistema de gestión de bases de datos (por ejemplo, MySQL) y configura las credenciales de conexión en el archivo .env.

8. Ejecuta las migraciones para crear las tablas en la base de datos ejecutando el siguiente comando:
 ```bash
php artisan migrate
```
Esto creará las tablas necesarias en la base de datos.

9. Opcionalmente, si deseas llenar la base de datos con datos de prueba, puedes ejecutar los seeders utilizando el siguiente comando:
 ```bash
php artisan db:seed
```

10. Finalmente, puedes iniciar el servidor de desarrollo de Laravel ejecutando el siguiente comando:
 ```bash
php artisan serve
```
Esto iniciará el servidor en http://localhost:8000, donde podrás acceder al API "Api Gestión de Notas".

## Relaciones de las Tablas:

![Texto alternativo de la imagen](Documentacion/Relaciones.png)

En la imagen se muestra un diagrama que representa las relaciones entre las tablas en la base de datos utilizada por el API. Estas relaciones son importantes para comprender la estructura y la interacción de los datos en el sistema.

### Video del Funcionamiento del api

Puedes ver un video que muestra el funcionamiento del API en el siguiente enlace: [Video :) ](https://youtu.be/ejhVSdfD4Ls)

El video proporciona una visión general del API y demuestra cómo se pueden utilizar sus endpoints para la gestión de notas. Te recomendamos ver el video para obtener una mejor comprensión de su funcionamiento.

Este API es utilizado como backend en el proyecto de Angular en el siguiente repositorio lo puedes encontrar:  [aqui](https://github.com/Mgodoyd/GestionNotasFront.git). Asegúrate de seguir las instrucciones proporcionadas en la documentación del API y configurarlo correctamente en el proyecto de Angular para que funcione de manera adecuada.
