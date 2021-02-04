FROM node:14-alpine as builder

WORKDIR /app

COPY ./package.json ./package-lock.json ./
RUN npm install && npm cache clear

COPY ./ ./
RUN npm run build

FROM nginx:1.17-alpine

RUN apk add --no-cache curl

COPY ./docker/production/nginx/conf.d /etc/nginx/conf.d

WORKDIR /app

COPY --from=builder /app/dist ./public