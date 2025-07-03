FROM php:8.3-apache

# Update dan install dependencies plus ekstensi PHP yang penting untuk Laravel production
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
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
 && docker-php-ext-configure zip \
 && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip \
    opcache

# Install nano dan vim
RUN apt-get install -y nano vim && rm -rf /var/lib/apt/lists/*

# Enable mod_rewrite Apache yang dibutuhkan Laravel routing
RUN a2enmod rewrite

# Install Composer global dari image resmi composer (menggunakan multi-stage copy)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory ke folder Laravel di dalam container
WORKDIR /var/www/html

# Copy source code Laravel dari direktori src di host ke container
COPY src/ .

# Jalankan composer install untuk menginstall dependensi PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Buat folder khusus upload dan set permission agar www-data bisa mengakses
RUN mkdir -p /var/www/uploads \
    && chown www-data:www-data /var/www/uploads \
    && chmod 770 /var/www/uploads

# Pastikan folder storage dan bootstrap/cache dimiliki oleh user www-data (Apache)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Batasi akses ke folder uploads agar tidak bisa diakses langsung dari browser (security measure)
RUN echo "<Directory /var/www/uploads>\n\
  Require all denied\n\
</Directory>" > /etc/apache2/conf-available/deny-uploads.conf \
  && a2enconf deny-uploads

# Ubah DocumentRoot apache ke folder public Laravel agar routing Laravel berjalan benar
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf

# Expose port 80 untuk akses HTTP
EXPOSE 80

# Jalankan Apache di foreground (default command)
CMD ["apache2-foreground"]
