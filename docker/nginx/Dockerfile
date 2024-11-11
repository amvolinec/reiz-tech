FROM nginx:stable

COPY nginx.conf /etc/nginx/
COPY laravel.conf /etc/nginx/sites-available/

RUN mkdir -p /etc/nginx/sites-enabled
RUN ln -s /etc/nginx/sites-available/laravel.conf /etc/nginx/sites-enabled/laravel

RUN rm /etc/nginx/conf.d/default.conf

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN usermod -u 1000 www-data

EXPOSE 80
EXPOSE 443
