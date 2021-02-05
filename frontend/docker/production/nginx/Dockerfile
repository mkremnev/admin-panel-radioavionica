FROM node:14-alpine as builder

WORKDIR /app

COPY ./public/package.json ./
RUN npm install

COPY ./public ./
RUN npm run build

FROM nginx:1.17-alpine

RUN apk add --no-cache curl

COPY ./docker/production/nginx/conf.d /etc/nginx/conf.d

WORKDIR /app

COPY --from=builder /app/dist ./public