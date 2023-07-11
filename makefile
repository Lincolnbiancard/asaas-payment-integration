getContainerIdApi=$(shell docker ps --filter "name=laravel.test" --format "{{.ID}}")
getContainerIdDB=$(shell docker ps --filter "name=mysql" --format "{{.ID}}")

.PHONY: up local environment
up:
	vendor/bin/sail up -d

.PHONY: down local environment
down:
	vendor/bin/sail down

bash:
	docker exec -it $(getContainerIdApi) /bin/bash

bash_db:
	docker exec -it $(getContainerIdDB) /bin/bash
	
.PHONY: test
test:
	docker exec -it $(getContainerIdApi) php artisan test

.PHONY: composer install
composer-install:
	docker exec -it $(getContainerIdApi) composer install

.PHONY: run migrate
migrate:
	docker exec -it $(getContainerIdApi) php artisan migrate

.PHONY: npm install in folder /frontend
npm-install:
	docker exec -it $(getContainerIdApi) bash -c "cd frontend && npm install"
	
.PHONY: run coverage test
coverage:
	docker exec -it $(getContainerIdApi) php artisan test --coverage-html coverage