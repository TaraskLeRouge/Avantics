FROM php:7.4-fpm

ENV TIMEZONE Europe/Paris

RUN cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime
RUN echo "${TIMEZONE}" > /etc/timezone
RUN apt-get update
RUN apt-get install -y \
        libzip-dev \
        libicu-dev \
        g++ \
        zip \
        curl \
        vim 


RUN	docker-php-ext-configure intl && \
	docker-php-ext-install zip intl pdo_mysql

COPY ./entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 9000