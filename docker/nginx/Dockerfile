# nginx/Dockerfile
FROM nginx:1.15.5

#RUN echo "alias ll='ls --color=auto -alF'" >> ~/.bashrc
ADD nginx.conf /etc/nginx/
ADD site.template /etc/nginx/sites-available/

RUN rm /etc/nginx/conf.d/default.conf

CMD /bin/sh -c "envsubst '\$APP_NAME \$APP_DOMAIN' < /etc/nginx/sites-available/site.template > /etc/nginx/sites-available/site.conf && nginx -g 'daemon off;' || cat /etc/nginx/nginx.conf"

RUN ln -s /etc/nginx/sites-available/site.conf /etc/nginx/conf.d/site.conf

RUN adduser -D -H -u 1000 -s /bin/bash www-data -G www-data

EXPOSE 80
EXPOSE 443
