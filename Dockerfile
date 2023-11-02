FROM registry.robi.com.bd/robiworkflow/vas-cp:base

WORKDIR /app

COPY --chown=www-data:www-data . .

RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts --prefer-dist && \
    composer dump-autoload && \
    chown -R www-data:www-data /app/storage /app/bootstrap && \
    chmod -R 777 /app/storage /app/bootstrap && \
    php artisan storage:link
