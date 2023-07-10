getContainerIdApi=$(shell docker ps --filter "name=laravel.test" --format "{{.ID}}")
getContainerIdDB=$(shell docker ps --filter "name=mysql" --format "{{.ID}}")

.PHONY: up local environment
up:
	docker compose up -d

.PHONY: down local environment
down:
	docker compose down

bash:
	docker exec -it $(getContainerIdApi) /bin/bash

bash_db:
	docker exec -it $(getContainerIdDB) /bin/bash
	