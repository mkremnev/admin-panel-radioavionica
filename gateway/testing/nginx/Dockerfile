FROM nginx:1.19-alpine

RUN apk add --no-cache curl

COPY ./common/nginx/snippets /etc/nginx/snippets
COPY ./testing/nginx/conf.d /etc/nginx/conf.d

WORKDIR /app