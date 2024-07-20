FROM php:7.4-apache

COPY index.php /var/www/html/
COPY style.css /var/www/html/

EXPOSE 80

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

CMD ["apache2-foreground"]