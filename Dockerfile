# Використовуємо базовий образ з підтримкою PHP та сервером Apache на базі Linux
FROM php:7.4-apache

# Встановлюємо розширення mysqli для роботи з MySQL
RUN docker-php-ext-install mysqli

# Встановлюємо розширення, яке потрібне для PHPMyAdmin
RUN apt-get update \
    && apt-get install -y wget unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && wget https://files.phpmyadmin.net/phpMyAdmin/5.1.0/phpMyAdmin-5.1.0-all-languages.zip -O /tmp/phpmyadmin.zip \
    && unzip /tmp/phpmyadmin.zip -d /tmp \
    && mv /tmp/phpMyAdmin-5.1.0-all-languages /usr/share/phpmyadmin \
    && rm -rf /tmp/phpmyadmin.zip \
    && rm -rf /usr/share/phpmyadmin/setup \
    && rm -rf /usr/share/phpmyadmin/examples \
    && rm -rf /usr/share/phpmyadmin/test

# Копіюємо файли проекту до контейнера
COPY . /var/www/html

# Встановлюємо права доступу до папок та файлів
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Вказуємо робочий каталог
WORKDIR /var/www/html

# Відкриваємо порт для доступу до серверу Apache
EXPOSE 80

# Запускаємо Apache сервер
CMD ["apache2-foreground"]