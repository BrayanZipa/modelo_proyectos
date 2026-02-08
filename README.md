# Modelo de proyectos

## Instalación

```bash

# 1. Clonar el repositorio
git https://github.com/BrayanZipa/prueba_gestion_productos.git

# 2. Instalar dependencias PHP
composer install

# 3. Crear base de datos y ejecutar migraciones y fixtures
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate

# 4. Ejecutar fixtures para generar datos de prueba
php bin/console doctrine:fixtures:load

# 5. Iniciar el servidor backend
php artisan serve

```