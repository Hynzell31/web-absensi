FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan CodeIgniter 4
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install intl mysqli pdo pdo_mysql zip

# Aktifkan mod_rewrite Apache (wajib untuk CI4)
RUN a2enmod rewrite

# Ubah DocumentRoot Apache ke folder public CI4
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Salin semua file ke dalam container
COPY . /var/www/html/

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies (jika vendor belum di-commit)
RUN composer install --no-dev --optimize-autoloader || true

# Atur permission folder writable
RUN chown -R www-data:www-data /var/www/html/writable /var/www/html/public/uploads
RUN chmod -R 775 /var/www/html/writable /var/www/html/public/uploads

# Port yang digunakan Render
EXPOSE 80
