FROM php:8.2-apache

# Instalar extensiones necesarias para mysql
RUN docker-php-ext-install pdo pdo_mysql

# URLS Limpias
RUN a2enmod rewrite

# Instalar y habilitar SSL
RUN a2enmod ssl
RUN mkdir -p /etc/apache2/ssl

# Generar certificado SSL auto-firmado (para desarrollo)
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/apache2/ssl/private.key \
    -out /etc/apache2/ssl/certificate.crt \
    -subj "/C=ES/ST=Madrid/L=Madrid/O=Development/CN=localhost"

# Poner config de Apache (SOLO este archivo, ya incluye HTTP y HTTPS)
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Habilitar el sitio (esto funciona para ambos puertos)
RUN a2ensite 000-default.conf

COPY . /var/www/html

# Permisos
RUN chown -R www-data:www-data /var/www/html