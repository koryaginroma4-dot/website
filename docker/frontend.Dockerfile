FROM nginx:alpine

RUN apk add --no-cache \
    nano \
    supervisor

COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

WORKDIR /var/www/