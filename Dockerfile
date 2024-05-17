# Використовуємо базовий образ з підтримкою PHP та сервером Apache на базі Linux
FROM php:7.4-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y

CMD ["apache2-foreground"]