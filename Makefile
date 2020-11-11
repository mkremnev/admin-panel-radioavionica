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

push: push-gateway push-frontend push-backend

push-gateway:
	docker push ${REGISTRY}/radioavionica-gateway:${IMAGE_TAG}

push-backend:
	docker push ${REGISTRY}/radioavionica-backend-nginx:${IMAGE_TAG}
	docker push ${REGISTRY}/radioavionica-backend-php-fpm:${IMAGE_TAG}

push-frontend:
	docker push ${REGISTRY}/radioavionica-frontend:${IMAGE_TAG}

deploy:
	cd frontend/public && npm run build
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'rm -rf admin-panel_${BUILD_NUMBER}'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'mkdir admin-panel_${BUILD_NUMBER}'

	envsubst < docker-compose-production.yml > docker-compose-production-env.yml
	scp -o StrictHostKeyChecking=no -P ${PORT} docker-compose-production-env.yml deploy@${HOST}:admin-panel_${BUILD_NUMBER}/docker-compose.yml
	rm -f docker-compose-production-env.yml

	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd admin-panel_${BUILD_NUMBER} && docker-compose -f docker-compose.yml pull'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd admin-panel_${BUILD_NUMBER} && docker-compose -f docker-compose.yml down'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd admin-panel_${BUILD_NUMBER} && docker-compose -f docker-compose.yml up -d'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'rm -f admin-panel'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'ln -sr admin-panel_${BUILD_NUMBER} admin-panel'

rollback:
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd admin-panel_${BUILD_NUMBER} && docker stack deploy --compose-file docker-compose.yml admin-panel --with-registry-auth --prune'
