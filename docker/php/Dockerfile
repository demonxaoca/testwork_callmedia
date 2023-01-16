FROM php:8.1
RUN set -xe \
   && apt-get update \
   && apt-get install -y git  procps libjpeg-dev libmcrypt-dev libonig-dev \
              curl \
              libcurl4-gnutls-dev cron \
              libz-dev \
   && rm -rf /var/lib/apt/lists/* \ 
   && docker-php-ext-install mbstring curl pdo pdo_mysql sockets \
   && docker-php-ext-enable sockets
COPY ./app /usr/src/app/app
COPY ./composer.phar /usr/src/app/composer.phar
COPY ./composer.json /usr/src/app/composer.json
WORKDIR /usr/src/app
RUN ["php","./composer.phar","install"]
CMD [ "php", "./app/threads.php" ]