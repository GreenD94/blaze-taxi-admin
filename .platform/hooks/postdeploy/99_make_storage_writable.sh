#!/bin/bash

# Dar permisos de escritura al directorio storage
chmod -R 775 /var/app/current/storage
chmod -R 775 /var/app/current/bootstrap/cache

# Asegurar que los directorios pertenezcan al usuario correcto
chown -R webapp:webapp /var/app/current/storage
chown -R webapp:webapp /var/app/current/bootstrap/cache

# Crear el enlace simbólico para storage si no existe
if [ ! -L /var/app/current/public/storage ]; then
    cd /var/app/current
    php artisan storage:link
fi

# Limpiar y cachear la configuración
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache 