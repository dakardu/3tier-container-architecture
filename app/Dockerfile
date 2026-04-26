FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Evitar warning Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copiar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar solo archivos necesarios para dependencias (cache)
COPY composer.json composer.lock ./

# Instalar dependencias (sin dev)
RUN composer install \
 --no-dev \
 --optimize-autoloader \
 --no-interaction \
 --no-progress \
 --prefer-dist

# Copiar código de la app
COPY . .

# Configuración de Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf

# Permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

USER www-data

EXPOSE 80