# https://github.com/docker-library/php/blob/master/7.4/buster/fpm/Dockerfile
FROM php:7.4-fpm

LABEL maintainer="Joshua Ayeni"

# Arguments defined in docker-compose.yml
#ARG DOCKER_ENV=production
#ARG user=cmc
#ARG uid=1000

#RUN echo "Building Dockerfile for the ${DOCKER_ENV} environment..."

# Set working directory
WORKDIR /var/www/html

# Copy composer.lock and composer.json
#COPY composer.lock composer.json /var/www/


RUN apt-get update \
   && apt-get install --quiet --yes --no-install-recommends \
     libzip-dev \
     unzip \
   && docker-php-ext-install zip pdo pdo_mysql \
   && pecl install -o -f redis-5.1.1 \
   && docker-php-ext-enable redis

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN groupadd --gid 1000 appuser \
    && useradd --uid 1000 -g appuser \
        -G www-data,root --shell /bin/bash \
        --create-home appuser

USER appuser

# Install dependencies
# RUN apt-get update && apt-get install -y \
#     build-essential \
#     libpng-dev \
#     libjpeg62-turbo-dev \
#     libfreetype6-dev \
#     locales \
#     zip \
#     jpegoptim optipng pngquant gifsicle \
#     vim \
#     nano \
#     unzip \
#     git \
#     curl \
#     supervisor 

# Clear cache
#RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
#RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
#RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
#RUN docker-php-ext-install gd

# Install composer
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the applicaton code to the web folder
#COPY . /var/www
#RUN chown -R www-data:www-data /var/www
#WORKDIR /var/www

# Install Composer packages
#RUN composer install --optimize-autoloader --no-dev --no-interaction

# Initialize the application
#RUN php artisan app:install

# Add user for laravel application
#RUN groupadd -g 1000 $user
#RUN useradd -u 1000 -ms /bin/bash -g $user $user

# Copy existing application directory contents
#COPY . /var/www

# Copy existing application directory permissions
#COPY --chown=$user:$user . /var/www

# Change current user
#USER $user

# Expose port 9000 and start php-fpm server
#EXPOSE 9000
#CMD ["php-fpm"]