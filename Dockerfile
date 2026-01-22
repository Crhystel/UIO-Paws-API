FROM php:8.2-apache

# 1. Instalar dependencias del sistema y extensiones de PHP para PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    zip \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql gd zip

# 2. Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# 3. Configurar Apache para apuntar a /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 4. Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Copiar el proyecto
COPY . /var/www/html

# 6. Instalar dependencias de composer
RUN composer install --no-dev --optimize-autoloader

# 7. Permisos correctos (Fundamental para evitar Error 500)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# 8. CMD Corregido: Limpiar caché -> Migrar -> Cachear de nuevo -> Arrancar
CMD php artisan config:clear && \
    php artisan migrate --seed --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    apache2-foreground