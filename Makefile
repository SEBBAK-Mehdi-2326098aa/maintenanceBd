.PHONY: help build up down logs shell composer test lint migrate cache rebuild

help:
	@echo "Commandes disponibles:"
	@echo "  make build     - Construire les images Docker"
	@echo "  make up        - Demarrer les containers"
	@echo "  make down      - Arreter les containers"
	@echo "  make logs      - Voir les logs"
	@echo "  make shell     - Ouvrir un shell dans le container PHP"
	@echo "  make composer  - Executer composer install"
	@echo "  make test      - Executer les tests"
	@echo "  make lint      - Executer le linter"
	@echo "  make migrate   - Executer les migrations (sur la BD distante)"
	@echo "  make cache     - Vider le cache"
	@echo "  make rebuild   - Reconstruire completement"

build:
	docker-compose build

up:
	docker-compose up -d

up-logs:
	docker-compose up

down:
	docker-compose down

logs:
	docker-compose logs -f

shell:
	docker exec -it symfony_app bash

composer:
	docker exec -it symfony_app composer install

test:
	docker exec -it symfony_app composer test

lint:
	docker exec -it symfony_app composer lint

migrate:
	docker exec -it symfony_app php bin/console doctrine:migrations:migrate --no-interaction

cache:
	docker exec -it symfony_app php bin/console cache:clear

rebuild:
	docker-compose down -v
	docker-compose build --no-cache
	docker-compose up -d
