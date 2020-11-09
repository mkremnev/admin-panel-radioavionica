init: npm-build docker-down docker-pull docker-build docker-up
up: docker-up
down: docker-down
clear: docker-down-clear
build: docker-build
restart: down build up

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