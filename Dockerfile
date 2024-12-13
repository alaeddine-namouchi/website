FROM php:7.4-apache

# Install required PHP extensions and tools
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    vim \
    curl \
    wget \
    nodejs \
    npm && \
    docker-php-ext-install \
    intl \
    pdo_mysql \
    zip && \
    a2enmod rewrite

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Set the working directory
WORKDIR /var/www/html

#  verify exist files
RUN ls -la

# Copy Composer files and install dependencies
# COPY composer.json composer.lock /var/www/html/
# RUN composer install --no-dev --prefer-dist --no-scripts --no-interaction

# Copy the rest of the project files
COPY . /var/www/html

# Fix permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 /var/www/html

# Expose port 80
EXPOSE 80
