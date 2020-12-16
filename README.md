# SeCo - TTPS 2020 - Grupo 7
Desarrollo de un SPA (Aplciación de una sola página) con Laravel 5.8 y Vuejs para la materia "Taller de tecnologías de producción de software"

## Integrantes del equipo de desarrollo:
* Faraone Negri, Camila
* Gonzalez Iriart, Gabriela
* Guido, Manuel

## Instalación

#### Software requerido para la instalación
* PHP
* MySQL
* Apache
* Composer
* Laravel

#### Instalar XAMPP (Incluye: PHP, Mysql, Apache) desde:
```
https://www.apachefriends.org/es/index.html
```

#### Instalar Composer desde:
```
https://getcomposer.org/
```

#### Instalar Laravel desde un terminal de comandos:
```
composer global require laravel/installer
```

#### Descargar Proyecto
```
git clone https://github.com/manuelguido/ttps-2020.git
```

#### Ubicarse en el directorio del proyecto
```
cd ttps-2020
```

#### Instalar dependencias de Composer
```
composer install
```

#### Instalar dependencias de NPM
```
npm install
```

#### Crear una copia del archivo .env.example a y renombrarlo como .env (También puede hacerse manualmente)
```
cp .env.example .env
```

#### Generar clave de encriptado
```
php artisan key:generate
```

#### Crear una base de datos en MySQL para el proyecto con el siguiente nombre
```
ttps-2020
```

#### Ingresar la siguiente información de la base de datos en el archivo .env del proyecto
```
DB_DATABASE=ttps-2020
DB_USERNAME=usuarioDeBaseDeDatos
DB_PASSWORD=contraseñaDeBaseDeDatos
```

#### Migrar la base de datos y hacer cargar seeds de información inicial
```
php artisan migrate:fresh --seed
```

#### Instalar Passport para la autenticación via AJAX con la API
```
php artisan passport:install
```

#### Ingresar la siguiente información en el archivo .env
```
PASSPORT_LOGIN_ENDPOINT=http://127.0.0.1:8000/oauth/token
PASSPORT_CLIENT_ID=2
PASSPORT_CLIENT_SECRET=LaSegundaKeyQueSeGeneróEnElComandoAnterior
```

#### Actualizar la información del proyecto en la cache
```
php artisan config:cache
```

#### Correr el servidor
```
php artisan serve
```

#### Listo! Ahora puedes acceder al sitio desde la siguiente URL
```
http://127.0.0.1:8000/
```


# Para correr los test luego de la instalación
```
.\vendor\bin\phpunit
```

### En caso de que los test no carguen, se debe limpiar la configuración del proyecto
```
php artisan config:clear
```
