## Requisitos previos

Requisitos previos a la ejecución del proyecto son tener en nuestro sistema PHP, Composer y SQLite, si alguno o todos de los requisitos no se cumplen seguir los siguientes pasos:

- [Instalación última versión PHP](https://www.php.net/downloads.php).
    - Si optamos por la instalación manual realizar los siguientes pasos:
        - Descargar zip con la versión de php.
        - Descomprimir contenido en directorio (estandar) "C:\php".
        - Copiar archivo "php.ini-development" y reescribirlo como "php.ini".
        - Editar el archivo "php.ini" y editar la línea extension_dir="absolute/path/to/phpfolder/ext".
        - Editar la variable de entorno del sistema PATH y añadir la línea "absolute/path/to/phpfolder".
- [Instalación última version Composer](https://getcomposer.org/download/).
- [Descarga de binarios precompilados de SQLite para el SO deseado](https://www.sqlite.org/download.html).
- Crear un directorio y alojar dentro los archivos "sqlite3.dll" y "sqlite3.def" obtenidos.
- Realizar los siguientes pasos en el archivo "php.ini" (copia del archivo php.ini-development renombrado como php.ini):
    - Descomentar la línea "extension=zip".
    - Descomentar la línea "extension=pdo_sqlite".
    - A continuación de esta añadir la siguiente línea:
        - sqlite3.extension_dir = "absolute/path/to/sqlitefolder" (directorio creado con anterioridad).

Una vez realizados todos estos pasos será necesario reiniciar el sistema.

## Descarga del repositorio y configuración del proyecto

Una vez hayamos descargado el repositorio debemos abrir una terminal o símbolo del sistema y ejecutamos el comando "composer install --ignore-platform-reqs". Una vez haya finalizado debemos editar la línea "DB_DATABASE_URL" en el archivo .env del proyecto y establecer la ruta absoluta hasta el archivo "database\database.sqlite" del proyecto.

## Ejecución del proyecto

Una vez realizados todos los pasos anteriores simplemente debemos ejecutar en una terminal o símbolo del sistema el comando "php artisan serve", lo cual hará que la Api Rest empiece a correr en "http://127.0.0.1:8000".

Una vez realizadas las operaciones deseadas se deben lanzar peticiones desde un agente PostMan o similares (incluyendo la cabecera "Accept, application/json" si es que no viene preestablecida) a la url http://127.0.0.1:8000/api/ENDPOINT_DESEADO o desde la propia documentación Swagger ubicada en la url http://127.0.0.1:8000/api/documentation .
