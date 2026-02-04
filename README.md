# Maintenance Project

Projet Symfony 8.0 avec PHP 8.4

## Prérequis

- [Docker](https://www.docker.com/get-started) et Docker Compose
- Ou PHP 8.4+ et Composer (pour une installation sans Docker)

## Installation avec Docker (Recommandé)

### 1. Cloner le projet

```bash
git clone <url de notre repo>
cd maintenance_project
```

### 2. Construire et démarrer les containers

```bash
# Construire les images Docker
docker-compose build

# Démarrer les containers en arrière-plan
docker-compose up -d
```

### 3. Accéder à l'application

L'application est accessible à l'adresse : [http://localhost:8000](http://localhost:8000)

## Commandes Docker utiles

### Avec Makefile (Linux/Mac)

```bash
make build     # Construire les images
make up        # Démarrer les containers
make down      # Arrêter les containers
make logs      # Voir les logs
make shell     # Ouvrir un shell dans le container PHP
make test      # Exécuter les tests
make lint      # Exécuter le linter
make migrate   # Exécuter les migrations
make cache     # Vider le cache
```

### Sans Makefile (Windows/PowerShell)

```powershell
# Construire les images
docker-compose build

# Démarrer les containers
docker-compose up -d

# Arrêter les containers
docker-compose down

# Voir les logs
docker-compose logs -f

# Ouvrir un shell dans le container PHP
docker-compose exec php bash

# Installer les dépendances
docker-compose exec php composer install

# Exécuter les tests
docker-compose exec php composer test

# Exécuter le linter
docker-compose exec php composer lint

# Migrations de base de données
docker-compose exec php php bin/console doctrine:migrations:migrate

# Vider le cache
docker-compose exec php php bin/console cache:clear
```

## Configuration

### Variables d'environnement

Les variables d'environnement sont configurées dans les fichiers suivants :

- `.env` - Configuration par défaut
- `.env.local` - Surcharges locales (non versionné)
- `.env.docker` - Configuration spécifique Docker

### Base de données

Le projet utilise PostgreSQL 16. La configuration Docker crée automatiquement :

- **Host**: `database` (dans le réseau Docker) ou `localhost` (depuis l'hôte)
- **Port**: `5432`
- **Database**: `app`
- **User**: `app`
- **Password**: `password`

## Stack technique

- **PHP**: 8.4
- **Symfony**: 8.0
- **Base de données**: PostgreSQL 16
- **ORM**: Doctrine
- **Tests**: PHPUnit 12.5
- **Linter**: PHP-CS-Fixer 3.93
- **Analyse statique**: PHPStan 2.1

## Structure du projet

```
├── assets/              # Fichiers JavaScript/CSS
├── bin/                 # Exécutables (console, phpunit)
├── config/              # Configuration Symfony
├── migrations/          # Migrations Doctrine
├── public/              # Point d'entrée web
├── src/                 # Code source PHP
│   ├── Controller/      # Contrôleurs
│   ├── Entity/          # Entités Doctrine
│   └── Repository/      # Repositories Doctrine
├── templates/           # Templates Twig
├── tests/               # Tests PHPUnit
├── translations/        # Fichiers de traduction
├── var/                 # Cache, logs, données
└── vendor/              # Dépendances (généré)
```

## Développement

### Commandes Composer disponibles

```bash
composer test        # Exécuter les tests
composer lint:check  # Vérifier le style du code
composer lint:fix    # Corriger le style du code
composer phpstan     # Analyse statique
composer ci          # Lint + Tests (pour CI/CD)
```
