Ce fichier a été écrit avec l'IA pour des raisons de temps et de simplicité!

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

### Avec PowerShell (Windows)

```powershell
.\make.ps1 build     # Construire les images
.\make.ps1 up        # Démarrer les containers
.\make.ps1 down      # Arrêter les containers
.\make.ps1 logs      # Voir les logs
.\make.ps1 shell     # Ouvrir un shell dans le container PHP
.\make.ps1 test      # Exécuter les tests
.\make.ps1 lint      # Exécuter le linter
.\make.ps1 migrate   # Exécuter les migrations
.\make.ps1 cache     # Vider le cache
```

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

### Commandes Docker directes

```bash
# Démarrer les containers
docker-compose up -d

# Arrêter les containers
docker-compose down

# Voir les logs
docker-compose logs -f

# Ouvrir un shell
docker exec -it symfony_app bash

# Exécuter une commande
docker exec -it symfony_app composer update
docker exec -it symfony_app composer test
docker exec -it symfony_app composer lint
docker exec -it symfony_app php bin/console doctrine:migrations:migrate

# Ensuite vous pouvez vous rendre sur la page d'acceuil en accédant à l'url 
localhost:8000/home
```

## Configuration

### Variables d'environnement

Les variables d'environnement sont configurées dans les fichiers suivants :

- `.env` - Configuration par défaut
- `.env.local` - Surcharges locales (non versionné, à créer)

### Base de données

Le projet utilise une **base de données distante** (par exemple sur Alwaysdata).

**Configuration :**

Édite le fichier `.env` et remplace la ligne `DATABASE_URL` avec tes identifiants :

```dotenv
# Pour MySQL (Alwaysdata)
DATABASE_URL="mysql://username:password@mysql-username.alwaysdata.net:3306/username_dbname?serverVersion=8.0&charset=utf8mb4"

# Pour PostgreSQL
DATABASE_URL="postgresql://username:password@postgresql-username.alwaysdata.net:5432/username_dbname?serverVersion=15&charset=utf8"
```

**Note :** N'oublie pas de créer la base de données sur ton serveur distant avant de lancer les migrations.

## Stack technique

- **PHP**: 8.4
- **Symfony**: 8.0
- **Base de données**: MySQL/PostgreSQL (distante - ex: Alwaysdata)
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
