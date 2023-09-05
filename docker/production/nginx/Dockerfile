#       FINAL
FROM nginx:1.14-alpine as nginx

COPY ./backend/ /www/html/

COPY docker/production/nginx/etc/nginx.conf /etc/nginx/conf.d/default.conf

