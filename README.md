Para correr 

php artisan serve

REPORTE DE POSIBLES ERRORES AL DESCARGAR EL PROYECTO DEL GITHUP
1. Error: Falta la carpeta vendor
Mensaje de error:
require(...\vendor\autoload.php): Failed to open stream: No such file or directory
Explicación:
Laravel necesita las dependencias del proyecto para funcionar. Estas están dentro de la carpeta vendor/, que se genera al instalar con Composer.
Solución:
Ejecuta en la raíz del proyecto:
composer install
2. Error 500 - Server Error
Mensaje de error:
500 Server Error
Explicación:
Este es un error genérico. En Laravel, suele deberse a problemas en la configuración del archivo. env o a la falta de clave de cifrado.
Soluciones posibles:
1.	Asegúrate de tener un archivo. env. Si no, crea uno con:
copy .env.example .env
2.	Genera la clave de la aplicación:
php artisan key:generate
3.	Verifica que la configuración de base de datos en .env esté correcta.
3. Error: No application encryption key has been specified
Mensaje de error:
No application encryption key has been specified.
Explicación:
Laravel requiere una clave única para cifrar información sensible.
Solución:
Ejecuta:
php artisan key:generate
Esto generará una clave y la agregará automáticamente a tu .env.
4. Error: Base de datos SQLite no encontrada
Mensaje de error:
Database file at path [...]database.sqlite does not exist.
Explicación:
Laravel intenta conectarse a una base de datos SQLite, pero el archivo físico no existe.
Soluciones:
Opción 1: Crear el archivo SQLite
1.	Ve a la carpeta:
Donde tienes el proyecto descargado 
2.	Crea un archivo vacío llamado database.sqlite.
3.	En el archivo. env, asegúrate de tener:
DB_CONNECTION=sqlite
Y agrega el archive sqlite 
5. Error: Vite manifest not found
Mensaje de error:
Vite manifest not found at: ...\public\build/manifest.json
Explicación:
Laravel usa Vite para compilar los archivos frontend (JS/CSS). Este error aparece cuando no se ha generado el build de Vite.
Solución:
1.	Instala las dependencias de Node:}
npm install
2.	Genera el build:
npm run build
Esto creará la carpeta public/build y el archivo manifest.json.
Alternativa para desarrollo:
npm run dev
Y en .env:
VITE_DEV_SERVER=true
 Recomendaciones finales
•	Verifica siempre que .env esté completo y actualizado.
•	Revisa los logs de Laravel si sigue fallando:
storage/logs/laravel.log
•	Haz composer install y npm install al descargar un proyecto Laravel.
•	Para que el proyecto funcione con los datos en tiempo real, debes crear el archivo .env en la raíz del proyecto y añadir la siguiente configuración de conexión:

DB_CONNECTION=mysql
DB_HOST=b60pyfgptnwp2r2n1q8k-mysql.services.clever-cloud.com
DB_PORT=3306
DB_DATABASE=b60pyfgptnwp2r2n1q8k
DB_USERNAME=u9ac9ulxaf0wjnkm
DB_PASSWORD=0bof7wwSeLhaIclX03K1
#DB_URL=mysql://u9ac9ulxaf0wjnkm:0bof7wwSeLhaIclX03K1@b60pyfgptnwp2r2n1q8k-mysql.services.clever-cloud.com:3306/b60pyfgptnwp2r2n1q8k
   

