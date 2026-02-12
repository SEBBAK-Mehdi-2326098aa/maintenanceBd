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

## Choix des technologies

### Symfony 8.0

**Pourquoi Symfony ?**

- **Framework mature et robuste** : Symfony est un framework PHP de référence depuis plus de 15 ans, utilisé par de nombreuses entreprises (BlaBlaCar, Spotify, Dailymotion).
- **Architecture MVC bien structurée** : Séparation claire entre la logique métier, la présentation et les données, facilitant la maintenance et l'évolution du code.
- **Doctrine ORM intégré** : Gestion élégante de la base de données avec un ORM puissant, permettant de travailler avec des objets PHP plutôt que du SQL brut.
- **Écosystème riche** : Nombreux bundles disponibles pour étendre les fonctionnalités (API Platform, EasyAdmin, FOSUserBundle, etc.).
- **Documentation exhaustive** : Documentation officielle très complète et communauté active.
- **Outils de développement** : Profiler web, barre de debug, générateur de code (Maker Bundle), facilitant le développement et le débogage.
- **Sécurité** : Système de sécurité robuste intégré (authentification, autorisation, CSRF, XSS).
- **Tests** : Support natif de PHPUnit et facilité pour écrire des tests unitaires et fonctionnels.

**Version 8.0** : Dernière version majeure avec les améliorations de performance et les nouvelles fonctionnalités PHP 8.4.

### Twig

**Pourquoi Twig ?**

- **Moteur de template par défaut de Symfony** : Intégration native et optimale avec le framework.
- **Syntaxe claire et lisible** : Séparation nette entre la logique PHP et la présentation HTML, rendant les templates faciles à lire et à maintenir.
- **Sécurité** : Échappement automatique des variables pour prévenir les failles XSS.
- **Héritage de templates** : Système de blocs permettant de créer des layouts réutilisables et d'éviter la duplication de code.
- **Filtres et fonctions** : Large gamme de filtres (date, upper, lower, etc.) et de fonctions pour manipuler les données directement dans les templates.
- **Performance** : Templates compilés en PHP pur pour des performances optimales.
- **Extensibilité** : Possibilité de créer des extensions personnalisées pour ajouter des fonctionnalités spécifiques.
- **Séparation des responsabilités** : Les designers peuvent travailler sur les templates sans connaître PHP en profondeur.

### PHP 8.4

**Pourquoi PHP 8.4 ?**

- **Performances** : Améliorations continues des performances à chaque version (JIT compiler depuis PHP 8.0).
- **Typage fort** : Types natifs (typed properties, union types, mixed type) pour un code plus robuste.
- **Syntaxe moderne** : Nouvelles fonctionnalités comme les attributs, match expression, promoted properties.
- **Écosystème mature** : Composer, PHPUnit, PHPStan, et de nombreux outils de qualité.

### Docker

**Pourquoi Docker ?**

- **Environnement reproductible** : Tous les développeurs travaillent avec exactement la même configuration.
- **Isolation** : Pas de conflit avec d'autres projets ou versions installées sur la machine.
- **Facilité de déploiement** : Même environnement en développement, test et production.
- **Portabilité** : Fonctionne sur Windows, Mac et Linux de manière identique.
