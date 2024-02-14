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

# Create a non-root user and switch to it
RUN groupadd -g 1000 www && \
    useradd -u 1000 -ms /bin/bash -g www www

# Copy composer.json and composer.lock
COPY ./www/composer.json ./www/composer.lock* /var/www/html/

# Change ownership of the /var/www directory
RUN chown -R www:www /var/www

# Switch to the non-root user
USER www

# Install dependencies with Composer
RUN composer install --no-interaction
