FROM bradb59/php7-apache-imagmagik:latest

MAINTAINER Brad Bonkoski <brad.bonkoski@gmail.com>

RUN a2enmod rewrite
#COPY . /var/www/html/
COPY app /var/www/html/app
COPY bootstrap /var/www/html/bootstrap
COPY config /var/www/html/config
COPY database /var/www/html/database
COPY public /var/www/html/public
COPY resources /var/www/html/resources
COPY routes /var/www/html/routes
COPY storage /var/www/html/storage
COPY vendor /var/www/html/vendor
COPY composer.* /var/www/html/
COPY readme.md /var/www/html/
COPY Dockerfile /var/www/html/
COPY docker-compose.yml /var/www/html/
COPY .env /var/www/html/

COPY config/imgmanage.conf /etc/apache2/sites-available/000-default.conf

