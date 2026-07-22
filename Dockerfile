# =========================
# BASE PYTHON STABLE
# =========================
FROM python:3.11-slim

# =========================
# SYSTÈME
# =========================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    build-essential \
    python3-dev \
    gfortran \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nodejs \
    npm \
    php \
    php-cli \
    php-mysql \
    php-mbstring \
    php-xml \
    php-zip \
    php-curl \
    php-gd \
    php-bcmath \
    php-intl \
    apache2 \
    libapache2-mod-php \
    && apt-get clean

# =========================
# MOD REWRITE (Laravel)
# =========================
RUN a2enmod rewrite

WORKDIR /var/www/html

# =========================
# COPIE PROJET
# =========================
COPY . .

# =========================
# COMPOSER
# =========================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

# =========================
# LARAVEL CACHE CLEAN
# =========================
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan storage:link || true

# =========================
# NODE / VITE BUILD
# =========================
RUN npm install
RUN npm run build

# =========================
# PYTHON VENV (IMPORTANT)
# =========================
RUN python -m venv /venv
ENV PATH="/venv/bin:$PATH"

RUN pip install --upgrade pip setuptools wheel
RUN pip install --no-cache-dir -r requirements.txt

# =========================
# PERMISSIONS
# =========================
RUN chown -R www-data:www-data storage bootstrap/cache || true

# =========================
# RUNTIME PORT RENDER (IMPORTANT)
# =========================
EXPOSE 10000

# =========================
# START (IMPORTANT FIX RENDER)
# =========================
CMD php artisan serve --host=0.0.0.0 --port=$PORT