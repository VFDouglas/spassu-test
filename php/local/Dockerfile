FROM php:fpm
ARG user=desenvolvedor
ARG uid

RUN docker-php-ext-install opcache
COPY php/local/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y git libjpeg62-turbo-dev libpng-dev libfreetype6-dev libxslt-dev libzip-dev libldap2-dev bash
RUN apt-get install -y nodejs npm
RUN docker-php-ext-install intl ldap zip mysqli pdo pdo_mysql gd ftp

RUN echo "root:hb-#6Z_@cF5D:gCU]:1ukiCt" | chpasswd

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

RUN mkdir -p /var/www/html
COPY . /var/www/html
RUN chown -R $user:www-data /var/www/html
USER $user
