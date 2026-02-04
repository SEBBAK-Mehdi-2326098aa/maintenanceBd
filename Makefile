.PHONY: help build up down logs shell composer test lint migrate

help:
	@echo "Commandes disponibles:"
	@echo "  make build     - Construire les images Docker"
	@echo "  make up        - Démarrer les containers"
	@echo "  make down      - Arrêter les containers"
	@echo "  make logs      - Voir les logs"
	@echo "  make shell     - Ouvrir un shell dans le container PHP"
	@echo "  make composer  - Exécuter composer install"
	@echo "  make test      - Exécuter les tests"
	@echo "  make lint      - Exécuter le linter"
	@echo "  make migrate   - Exécuter les migrations"
	@echo "  make cache     - Vider le cache"

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
	docker-compose exec php bash

composer:
	docker-compose exec php composer install

test:
	docker-compose exec php composer test

lint:
	docker-compose exec php composer lint

migrate:
	docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction

db-create:
	docker-compose exec php php bin/console doctrine:database:create --if-not-exists

cache:
	docker-compose exec php php bin/console cache:clear

rebuild:
	docker-compose down -v
	docker-compose build --no-cache
	docker-compose up -d
