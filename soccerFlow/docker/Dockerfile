FROM php:8.2-apache
#Instalar extensiones necesarias para mysql
RUN docker-php-ext-install pdo pdo_mysql
#URLS Limpias
RUN a2enmod rewrite
#Poner config de Apache (DocumentRoot en /public)
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

COPY . /var/www/html
#Permisos
RUN chown -R www-data:www-data /var/www/html