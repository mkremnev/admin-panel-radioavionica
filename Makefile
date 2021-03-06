init: docker-down-clear \
 	  api-clear frontend-clear \
 	  docker-pull docker-build docker-up \
 	  api-init frontend-init
init-full: npm-build docker-down-clear api-clear docker-pull docker-build docker-up api-init
up: docker-up
down: docker-down
restart: down up
check: lint analyze validate-schema test
lint: php-lint frontend-lint
analyze: php-analyze
validate-schema: php-validate-schema
test: php-test php-fixtures
test-unit: php-test-unit
test-functional: php-test-functional php-fixtures
test-coverage: php-test-coverage
test-unit-coverage: php-test-unit-coverage
test-functional-coverage: php-test-functional-coverage php-fixtures

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

# Production build

build: build-gateway build-frontend build-backend

build-gateway:
	docker --log-level=debug build --pull --file=gateway/production/nginx/Dockerfile --tag=${REGISTRY}/radioavionica-gateway:${IMAGE_TAG} gateway

build-frontend:
	docker --log-level=debug build --pull --file=frontend/docker/production/nginx/Dockerfile --tag=${REGISTRY}/radioavionica-frontend:${IMAGE_TAG} frontend

build-backend:
	docker --log-level=debug build --pull --file=backend/docker/production/nginx/Dockerfile --tag=${REGISTRY}/radioavionica-backend-nginx:${IMAGE_TAG} backend
	docker --log-level=debug build --pull --file=backend/docker/production/php-fpm/Dockerfile --tag=${REGISTRY}/radioavionica-backend-php-fpm:${IMAGE_TAG} backend
	docker --log-level=debug build --pull --file=backend/docker/production/php-cli/Dockerfile --tag=${REGISTRY}/radioavionica-backend-php-cli:${IMAGE_TAG} backend

try-build:
	REGISTRY=localhost IMAGE_TAG=0 make build

clear-var:
	docker run --rm -v ${PWD}/backend/public:/app -w /app alpine sh -c 'rm -rf var/*'

push: push-gateway push-frontend push-backend

push-gateway:
	docker push ${REGISTRY}/radioavionica-gateway:${IMAGE_TAG}

push-backend:
	docker push ${REGISTRY}/radioavionica-backend-nginx:${IMAGE_TAG}
	docker push ${REGISTRY}/radioavionica-backend-php-fpm:${IMAGE_TAG}
	docker push ${REGISTRY}/radioavionica-backend-php-cli:${IMAGE_TAG}

push-frontend:
	docker push ${REGISTRY}/radioavionica-frontend:${IMAGE_TAG}

deploy:
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'rm -rf admin-panel_${BUILD_NUMBER}'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'mkdir admin-panel_${BUILD_NUMBER}'

	envsubst < docker-compose-production.yml > docker-compose-production-env.yml
	scp -o StrictHostKeyChecking=no -P ${PORT} docker-compose-production-env.yml deploy@${HOST}:admin-panel_${BUILD_NUMBER}/docker-compose.yml
	rm -f docker-compose-production-env.yml

	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd admin-panel_${BUILD_NUMBER} && docker-compose -f docker-compose.yml pull'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd admin-panel_${BUILD_NUMBER} && docker-compose -f docker-compose.yml down'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd admin-panel_${BUILD_NUMBER} && docker-compose -f docker-compose.yml up --build -d backend-postgres backend-php-cli'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd admin-panel_${BUILD_NUMBER} && docker-compose run backend-php-cli wait-for-it backend-postgres:5432 -t 60'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd admin-panel_${BUILD_NUMBER} && docker-compose run backend-php-cli php bin/app.php migrations:migrate --no-interaction'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd admin-panel_${BUILD_NUMBER} && docker-compose -f docker-compose.yml up --build --remove-orphans -d'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'rm -f admin-panel'
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'ln -sr admin-panel_${BUILD_NUMBER} admin-panel'

rollback:
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd admin-panel_${BUILD_NUMBER} && docker stack deploy --compose-file docker-compose.yml admin-panel --with-registry-auth --prune'

# Local build

npm-build:
	cd frontend/public && npm run build

api-clear:
	docker run --rm -v ${PWD}/backend/public:/app -w /app alpine sh -c 'rm -rf var/cache/* var/log/*'

api-init: api-permissions php-composer-install api-wait-db php-migrations php-fixtures

api-permissions:
	docker run --rm -v ${PWD}/backend/public:/app -w /app alpine chmod 777 var/cache var/log

api-wait-db:
	docker-compose run --rm backend-php-cli wait-for-it backend-postgres:5432 -t 30

php-composer-install:
	docker-compose run --rm backend-php-cli composer install

php-migrations:
	docker-compose run --rm backend-php-cli composer app migrations:migrate

php-fixtures:
	docker-compose run --rm backend-php-cli composer app fixtures:load

php-validate-schema:
	docker-compose run --rm backend-php-cli composer app orm:validate-schema

php-lint:
	docker-compose run --rm backend-php-cli composer lint
	docker-compose run --rm backend-php-cli composer check

php-fix:
	docker-compose run --rm backend-php-cli composer fix

php-require:
	docker-compose run --rm backend-php-cli composer require ${LIB} ${POS}

php-analyze:
	docker-compose run --rm backend-php-cli composer psalm

php-test:
	docker-compose run --rm backend-php-cli composer test

php-test-unit:
	docker-compose run --rm backend-php-cli composer test -- --testsuite=unit

php-test-unit-coverage:
	docker-compose run --rm backend-php-cli composer test-coverage -- --testsuite=unit

php-test-functional:
	docker-compose run --rm backend-php-cli composer test -- --testsuite=functional

php-test-functional-coverage:
	docker-compose run --rm backend-php-cli composer test-coverage -- --testsuite=functional

php-test-coverage:
	docker-compose run --rm backend-php-cli composer test-coverage

frontend-clear:
	docker run --rm -v ${PWD}/frontend/public:/app -w /app alpine sh -c 'rm -rf dist'

frontend-init: frontend-npm-install

frontend-npm-install:
	docker-compose run --rm frontend-node-cli npm install

frontend-test:
	docker-compose run --rm frontend-node-cli npm run test

frontend-lint:
	docker-compose run --rm frontend-node-cli npm run lint

testing-build: testing-build-gateway testing-build-testing-api-php-cli

testing-build-gateway:
	docker --log-level=debug build --pull --file=gateway/testing/nginx/Dockerfile --tag=${REGISTRY}/radioavionica-testing-gateway:${IMAGE_TAG} gateway

testing-build-testing-api-php-cli:
	docker --log-level=debug build --pull --file=backend/docker/testing/php-cli/Dockerfile --tag=${REGISTRY}/radioavionica-testing-backend-php-cli:${IMAGE_TAG} backend

testing-init:
	COMPOSE_PROJECT_NAME=testing docker-compose -f docker-compose-testing.yml up -d
	COMPOSE_PROJECT_NAME=testing docker-compose -f docker-compose-testing.yml run --rm backend-php-cli wait-for-it backend-postgres:5432 -t 60
	COMPOSE_PROJECT_NAME=testing docker-compose -f docker-compose-testing.yml run --rm backend-php-cli php bin/app.php migrations:migrate --no-interaction
	COMPOSE_PROJECT_NAME=testing docker-compose -f docker-compose-testing.yml run --rm testing-backend-php-cli php bin/app.php fixtures:load --no-interaction

testing-down-clear:
	COMPOSE_PROJECT_NAME=testing docker-compose -f docker-compose-testing.yml down -v --remove-orphans

try-testing: try-build try-testing-build try-testing-init try-testing-down-clear

try-testing-build:
	REGISTRY=localhost IMAGE_TAG=0 make testing-build

try-testing-init:
	REGISTRY=localhost IMAGE_TAG=0 make testing-init

try-testing-down-clear:
	REGISTRY=localhost IMAGE_TAG=0 make testing-down-clear