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

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy Apache configuration
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html



# Expose port 80
EXPOSE 80
