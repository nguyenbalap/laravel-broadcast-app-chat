FROM php:8.1-fpm
WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql
RUN rm -rf /var/cache/apk/*

FROM node:16-alpine 
WORKDIR /var/www/html
COPY . .
RUN npm install
RUN npm run build

EXPOSE 9000
CMD ["php-fpm"]
