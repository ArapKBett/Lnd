FROM php:8.2-fpm
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev nginx
COPY . /var/www/html
RUN composer install && npm install && npm run build
RUN php artisan migrate --seed
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
