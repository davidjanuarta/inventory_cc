# Menggunakan image dasar PHP 8.2 dengan FPM
FROM php:8.2-fpm

# Direktori kerja dalam container
WORKDIR /var/www

# Kembali ke root user sebelum menjalankan apt-get
USER root

# Install library yang diperlukan
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    curl \
    git

# Install Node.js 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Install Vite secara global (opsional)
RUN npm install -g vite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP extensions
# Install PHP extensions
RUN apt-get update && apt-get install -y libzip-dev
RUN docker-php-ext-install zip gettext intl pdo_mysql
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd


# Tambahkan user www (non-root) untuk menjalankan Laravel
RUN getent group www || groupadd -g 1000 www && \
    id -u www || useradd -u 1000 -ms /bin/bash -g www www

# Salin kode Laravel ke container

COPY src /var/www


# Berikan izin ke direktori storage dan bootstrap/cache
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache && \
    chown -R www:www /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Install dependencies proyek Laravel (Composer dan npm)
RUN composer install --no-scripts --no-autoloader
RUN npm install && npm run build

# Pindah ke user 'www' (non-root) setelah semua instalasi selesai
USER www

# Expose port untuk PHP-FPM
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]
