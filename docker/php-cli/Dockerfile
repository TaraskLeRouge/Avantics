FROM php:7.4-cli

ENV TIMEZONE Europe/Paris

RUN cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime
RUN echo "${TIMEZONE}" > /etc/timezone
RUN apt-get update
RUN apt-get install -y \
		git \
		vim \
		libzip-dev \
		zip \
		gosu \
		curl && \
        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer 

RUN docker-php-ext-install zip pdo_mysql

RUN mkdir /var/www/.composer/cache -p && chmod 777 /var/www/.composer/cache 

COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]

WORKDIR /srv