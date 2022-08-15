FROM php:7.4-fpm

COPY php.ini /usr/local/etc/php/php.ini

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash

RUN apt-get update \
	&& apt-get install -y  \
        g++ \
        git \
        libcurl4-openssl-dev \
        pkg-config \
        libssl-dev \
        libicu-dev \
        libxml2-dev \
		libfreetype6-dev \
		libpng-dev \
		libjpeg-dev \
        zlib1g-dev \
        libzip-dev \
        zip \
        symfony-cli \
	&& docker-php-ext-configure gd \
		--with-freetype=/usr/include/ \
		--with-jpeg=/usr/include/ \
	&& docker-php-ext-install -j$(nproc) \
		gd \
   ;

RUN docker-php-ext-configure zip

RUN docker-php-ext-install -j$(nproc) \
      intl \
      zip \
      soap

RUN docker-php-ext-install opcache pdo pdo_mysql

RUN pecl install apcu xdebug;

RUN pecl clear-cache;

RUN docker-php-ext-enable \
        opcache \
        apcu \
        xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html




