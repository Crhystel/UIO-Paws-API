FROM php:8.2-apache

# 1. Instalar dependencias y extensiones
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    zip \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql gd zip

# 2. Habilitar mod_rewrite
RUN a2enmod rewrite

# 3. Apache Config
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 4. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Copiar proyecto
COPY . /var/www/html

# 6. Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

# 7. Permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# 8. Solo migrar y encender
CMD php artisan config:clear && \
    php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    apache2-foreground