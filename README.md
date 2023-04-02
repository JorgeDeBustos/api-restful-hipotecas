## Requisitos previos

Requisitos previos a la descarga y ejecución del repositorio:

- [Instalación última versión PHP](https://www.php.net/downloads.php).
- [Instalación última version Composer](https://getcomposer.org/download/).
- [Descarga de binarios precompilados de SQLite para el SO deseado](https://www.sqlite.org/download.html).
- Crear un directorio y alojar dentro los archivos "sqlite3.dll" y "sqlite3.def" obtenidos.
- Realizar los siguientes pasos en el archivo "php.ini":
    - Descomentar la línea "extension=pdo_sqlite".
    - Añadir las siguientes líneas en la sección Environment:
        - extension_dir = "absolute/path/to/php/ext".
        - sqlite3.extension_dir = "absolute/path/to/sqlitefolder" (directorio creado con anterioridad).

## Descarga del repositorio y configuración del proyecto

Una vez hayamos descargado el repositorio debemos abrir una terminal o símbolo del sistema y ejecutamos el comando "composer install --ignore-platform-reqs". Una vez haya finalizado debemos editar la línea "DB_DATABASE_URL" en el archivo .env del proyecto y establecer la ruta absoluta hasta el archivo "database\database.sqlite" del proyecto.

## Ejecución del proyecto

Una vez realizados todos los pasos anteriores simplemente debemos ejecutar en una terminal o símbolo del sistema el comando "php artisan serve", lo cual hará que la Api Rest empiece a correr en "http://127.0.0.1:8000".

Una vez realizadas las operaciones deseadas se deben lanzar peticiones desde un agente PostMan o similares (incluyendo la cabecera "Accept, application/json" si es que no viene preestablecida) a la url http://127.0.0.1:8000/api/ENDPOINT_DESEADO o desde la propia documentación Swagger ubicada en la url http://127.0.0.1:8000/api/documentation .
