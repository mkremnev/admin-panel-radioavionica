init: npm-build docker-down docker-pull docker-build docker-up
up: docker-up
down: docker-down
clear: docker-down-clear
restart: down up

npm-build:
	cd frontend/public && npm run build

docker-up:
	docker-compose up -d

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-down:
	docker-compose down --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

build: build-gateway build-frontend build-backend

build-gateway:
	docker --log-level=debug build --pull --file=gateway/production/nginx/Dockerfile --tag=${REGISTRY}/radioavionica-gateway:${IMAGE_TAG} gateway

build-frontend:
	docker --log-level=debug build --pull --file=frontend/docker/production/nginx/Dockerfile --tag=${REGISTRY}/radioavionica-frontend:${IMAGE_TAG} frontend

build-backend:
	docker --log-level=debug build --pull --file=backend/docker/production/nginx/Dockerfile --tag=${REGISTRY}/radioavionica-backend-nginx:${IMAGE_TAG} backend
	docker --log-level=debug build --pull --file=backend/docker/production/php-fpm/Dockerfile --tag=${REGISTRY}/radioavionica-backend-php-fpm:${IMAGE_TAG} backend

try-build:
	REGISTRY=localhost IMAGE_TAG=0 make build