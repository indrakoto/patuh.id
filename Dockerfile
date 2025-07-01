FROM php:8.3-apache

# Install dependencies dan ekstensi PHP yang dibutuhkan Laravel, termasuk gd dan intl
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libicu-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
 && docker-php-ext-configure intl \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl

# Enable mod_rewrite Apache untuk Laravel routing
RUN a2enmod rewrite

# Install Composer global dari image resmi composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy source code Laravel dari folder src di host ke /var/www/html di container
COPY src/ .

# Jalankan composer install
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Buat folder upload khusus dan set permission owner ke www-data (bukan user yang tidak ada)
RUN mkdir -p /var/www/uploads \
    && chown www-data:www-data /var/www/uploads \
    && chmod 770 /var/www/uploads

# Pastikan storage Laravel dan bootstrap/cache dimiliki www-data
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Supaya folder uploads tidak bisa diakses langsung dari browser, buat aturan .htaccess untuk deny akses
RUN echo "<Directory /var/www/uploads>\n\
  Require all denied\n\
</Directory>" > /etc/apache2/conf-available/deny-uploads.conf \
  && a2enconf deny-uploads

# Ubah DocumentRoot Apache ke /var/www/html/public agar Laravel bisa diakses dengan benar
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
