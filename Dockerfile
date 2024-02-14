FROM php:8.2-apache
RUN chmod 755 /var/www/html
RUN docker-php-ext-install mysqli
RUN apt-get update && apt-get install -y --no-install-recommends \
    && \
apt-get clean && \
rm -rf /var/lib/apt/lists/*


EXPOSE 3306
EXPOSE 8000
EXPOSE 8001
RUN docker-php-ext-install mysqli pdo pdo_mysql
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory to where your PHP project is
WORKDIR /var/www/html

# Run Composer to install the dependencies specified in composer.json
RUN composer install
