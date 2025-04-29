# syntax=docker/dockerfile:1

# --- Build stage: install Composer dependencies ---
    FROM composer:2.7 AS vendor
    WORKDIR /app
    # Only copy composer files for dependency caching
    COPY --link composer.json composer.lock ./
    RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist --optimize-autoloader
    
    # --- Build stage: node assets (optional, if you use npm build) ---
    # Uncomment if you need to build frontend assets
    FROM node:20-alpine AS assets
    WORKDIR /app
    COPY --link package.json package-lock.json ./
    RUN npm ci --omit=dev
    COPY --link resources/ ./resources/
    RUN npm run build
    
    # --- Final stage: PHP runtime ---
    FROM php:8.2-fpm-alpine AS app
    
    # Install system dependencies
    RUN apk add --no-cache \
        icu-dev libpng-dev libjpeg-turbo-dev libwebp-dev libxpm-dev \
        libzip-dev oniguruma-dev zlib-dev gmp-dev \
        bash curl git mysql-client
    
    # Install PHP extensions
    RUN docker-php-ext-install intl pdo pdo_mysql mbstring zip exif pcntl bcmath gd
    
    # Install additional PHP extensions if needed
    # RUN docker-php-ext-install opcache
    
    # Set working directory
    WORKDIR /var/www/html
    
    # Copy application code (excluding .env and other secrets)
    COPY --link . .
    
    # Copy installed vendor dependencies from build stage
    COPY --from=vendor /app/vendor ./vendor
    
    # If you built assets, copy them here
    # COPY --from=assets /app/public/build ./public/build
    
    # Create non-root user and set permissions
    RUN addgroup -S appgroup && adduser -S appuser -G appgroup \
        && mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
        && chown -R appuser:appgroup /var/www/html \
        && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache
    
    USER appuser
    
    # Expose port 9000 for php-fpm
    EXPOSE 9000
    
    # Entrypoint (php-fpm)
    
    # Ensure the cache directory exists at runtime
    CMD ["sh", "-c", "mkdir -p /var/www/html/bootstrap/cache && exec php-fpm"]
    # --- Notes ---
    # - Pass environment variables (including secrets) at runtime, not in the image.
    # - .env should be in .dockerignore and NOT copied into the image.
    # - For production, consider running `php artisan config:cache` and `php artisan route:cache` as part of the build.
    # - If you use a web server (nginx/apache), use a separate container or add it in another stage.