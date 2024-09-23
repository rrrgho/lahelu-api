FROM php:8.3-cli
RUN apt-get update && apt-get install -y openssl zip unzip git

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Install PGSQL extention
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/data/lahelu/postgres \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Set Working Directory
WORKDIR /var/www/html/lahelu
COPY . /var/www/html/lahelu

RUN chmod -R 775 /var/www/html/lahelu


# Install dependencies via composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install

# Run the project service
CMD php artisan key:generate
CMD php artisan serve --host=0.0.0.0 --port=8005
EXPOSE 8005