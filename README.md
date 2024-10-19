<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Ecommerce Platform API

Esta es la API de la plataforma de comercio electrónico, desarrollada en Laravel. Esta API permite gestionar usuarios, autenticación, productos y órdenes.

## Requisitos

Antes de comenzar, asegúrate de tener instalados los siguientes requisitos:

- [PHP](https://www.php.net/downloads) (versión 7.4 o superior)
- [Composer](https://getcomposer.org/download/)
- [Laravel](https://laravel.com/docs/8.x/installation#installation-via-composer)
- [MySQL](https://www.mysql.com/downloads/) (o cualquier otro sistema de gestión de bases de datos soportado)
- [Node.js](https://nodejs.org/en/download/) (opcional, si se utiliza para el frontend)

## Instalación

Sigue estos pasos para instalar y ejecutar la API:

1. **Clona el repositorio**:

   ```bash
   git clone https://github.com/tu-usuario/ecommerce-platform.git
   cd ecommerce-platform
    ```

2. **Instala las dependencias**:

    ```bash 
        composer install
    ```

3. **Copia el archivo de configuración**:

    ```bash
        cp .env.example .env
    ```

4. **Configura el entorno**:

    ```plaintext
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=nombre_de_la_base_de_datos
        DB_USERNAME=tu_usuario
        DB_PASSWORD=tu_contraseña
    ```
5. **Genera la clave de la aplicación**:
    ```bash
        php artisan key:generate
    ```
6. **Ejecuta las migraciones**:
    ```bash
        php artisan migrate
    ```
7. **Instala las dependencias de frontend (opcional)**:
    ```bash
        npm install
    ```
8. **Inicia el servidor**:
    ```bash
        php artisan serve
        npm run dev
    ```
## Documentación de la API

La documentación de la API generada por Swagger está disponible en:
```bash	
http://localhost/api/documentation
```
## Uso de la API
Puedes utilizar herramientas como Postman o cURL para realizar solicitudes a la API. Asegúrate de consultar la documentación para conocer los endpoints disponibles y los parámetros requeridos.

## Contribuciones
Las contribuciones son bienvenidas. Si deseas contribuir, por favor abre un issue o envía un pull request.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
