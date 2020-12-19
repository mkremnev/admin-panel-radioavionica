FROM nginx:1.17-alpine

COPY ./production/nginx/conf.d /etc/nginx/conf.d
COPY ./common/nginx/snippets /etc/nginx/snippets

WORKDIR /app