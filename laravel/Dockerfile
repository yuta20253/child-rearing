FROM php:8.3-fpm

# システムパッケージ・PHP拡張のインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer のインストール（公式 Composer イメージからコピー）
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 作業ディレクトリの設定
WORKDIR /var/www/html

# 権限調整（必要に応じて）
# RUN chown -R www-data:www-data /var/www/html
