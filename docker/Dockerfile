FROM raftx24/base_php:0.2

COPY vhost.conf /etc/apache2/sites-enabled/000-default.conf

COPY --chown=www-data:www-data . /var/www/html

RUN cp .env.example .env

RUN a2enmod rewrite deflate setenvif headers

RUN composer install --optimize-autoloader

RUN php artisan optimize

RUN chmod +x ./init.prod.sh

CMD ./init.prod.sh