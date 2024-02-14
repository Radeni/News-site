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