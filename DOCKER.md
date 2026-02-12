Ce fichier a été écrit avec l'IA pour des raisons de temps et de simplicité!

# Documentation Docker

Guide complet pour utiliser Docker avec ce projet Symfony 8.0.

## Table des matières

- [Démarrage rapide](#démarrage-rapide)
- [Configuration](#configuration)
- [Commandes utiles](#commandes-utiles)
- [Dépannage](#dépannage)

## Démarrage rapide

### 1. Installation de Docker

Assure-toi d'avoir Docker et Docker Compose installés :

- [Docker Desktop](https://www.docker.com/products/docker-desktop) (inclut Docker et Docker Compose)

### 2. Configuration de la base de données

Édite le fichier `.env` et configure ta `DATABASE_URL` avec les identifiants d'Alwaysdata ou ton serveur MySQL/PostgreSQL :

```bash
# Copie .env.example si tu n'as pas .env
cp .env.example .env
```

Puis édite `.env` avec ta `DATABASE_URL` :

```dotenv
DATABASE_URL="mysql://username:password@mysql-username.alwaysdata.net:3306/username_dbname?serverVersion=8.0&charset=utf8mb4"
```

### 3. Démarrage du projet

**Linux/Mac (avec Makefile) :**
```bash
make up
```

**Windows (PowerShell) :**
```powershell
.\make.ps1 up
```

**Ou directement avec Docker :**
```bash
docker-compose up -d
```

L'application est maintenant accessible à : **http://localhost:8000**

## Configuration

### Variables d'environnement

Le fichier `.env` charge les variables :

- `DATABASE_URL` - Connexion à la base de données (IMPORTANT : configure-la)
- `APP_ENV` - Environnement (dev, prod, test)
- `APP_SECRET` - Clé secrète (à générer en production)

**Note :** Ne commite jamais `.env.local` en Git. Utilise `.env.example` comme référence.

### Base de données distante (Alwaysdata)

Depuis l'intérieur du container, tu peux accéder à ta base de données distante configurée dans `DATABASE_URL`.

**Exemples de connexion :**

**MySQL sur Alwaysdata :**
```
DATABASE_URL="mysql://username:password@mysql-username.alwaysdata.net:3306/username_dbname?serverVersion=8.0&charset=utf8mb4"
```

**PostgreSQL sur Alwaysdata :**
```
DATABASE_URL="postgresql://username:password@postgresql-username.alwaysdata.net:5432/username_dbname?serverVersion=15&charset=utf8"
```

**Paramètres à remplacer :**
- `username` : ton identifiant Alwaysdata
- `password` : ton mot de passe
- `mysql-username` ou `postgresql-username` : fourni par Alwaysdata
- `dbname` : nom de la base de données

## Commandes utiles

### PowerShell (Windows)

```powershell
# Démarrer les containers
.\make.ps1 up

# Démarrer avec les logs en direct
.\make.ps1 up-logs

# Arrêter les containers
.\make.ps1 down

# Voir les logs
.\make.ps1 logs

# Ouvrir un shell bash dans le container
.\make.ps1 shell

# Installer les dépendances
.\make.ps1 composer

# Exécuter les tests
.\make.ps1 test

# Exécuter le linter
.\make.ps1 lint

# Exécuter les migrations
.\make.ps1 migrate

# Vider le cache Symfony
.\make.ps1 cache

# Reconstruire complètement (supprime les données)
.\make.ps1 rebuild
```

### Makefile (Linux/Mac)

```bash
make up
make up-logs
make down
make logs
make shell
make composer
make test
make lint
make migrate
make cache
make rebuild
```

### Docker direct

```bash
# Démarrer les containers
docker-compose up -d

# Arrêter les containers
docker-compose down

# Voir les logs en direct
docker-compose logs -f

# Exécuter une commande dans le container PHP
docker exec -it symfony_app bash
docker exec -it symfony_app composer install
docker exec -it symfony_app composer test
docker exec -it symfony_app php bin/console cache:clear
docker exec -it symfony_app php bin/console doctrine:migrations:migrate
```

## Dépannage

### Erreur : "DATABASE_URL not found"

**Solution :** Assure-toi que `.env` existe et contient `DATABASE_URL`.

```bash
# Copie le fichier d'exemple si manquant
cp .env.example .env
```

### Erreur : "Connection refused to database"

**Solution :** Vérifie que tes identifiants Alwaysdata sont corrects dans `.env` et que ton serveur est accessible.

```bash
# Teste la connexion manuellement
docker exec -it symfony_app php bin/console doctrine:database:create --if-not-exists
```

### Erreur : "Permission denied" sur /app/vendor

**Solution :** Ce problème a été corrigé. Sinon, reconstruis :

```bash
docker-compose down -v
docker-compose build --no-cache
docker-compose up -d
```

### Erreur : "Port 8000 already in use"

**Solution :** Change le port dans `docker-compose.yml` :

```yaml
ports:
  - "8001:8000"  # Change 8000 en 8001 (ou autre port libre)
```

Accède à l'app sur : http://localhost:8001

### Vérifier les logs

```bash
# Tous les logs
docker-compose logs

# Logs d'un service spécifique
docker-compose logs php

# Logs en direct
docker-compose logs -f

# Dernières 100 lignes
docker-compose logs --tail=100
```

## Structure du projet

```
.
├── Dockerfile              # Configuration de l'image PHP
├── docker-compose.yml      # Configuration des services
├── .dockerignore           # Fichiers à exclure du build Docker
├── .env                    # Variables d'environnement (à configurer)
├── .env.example            # Exemple de configuration
├── Makefile                # Raccourcis de commandes (Linux/Mac)
├── make.ps1                # Raccourcis de commandes (Windows)
├── src/                    # Code source PHP
├── templates/              # Templates Twig
├── config/                 # Configuration Symfony
├── migrations/             # Migrations Doctrine
└── tests/                  # Tests PHPUnit
```

## Architecture Docker

```
┌─────────────────────────┐
│  Ton navigateur         │
│  http://localhost:8000  │
└────────────┬────────────┘
             │
             │
     ┌───────▼────────────┐
     │  symfony_app       │
     │  (PHP 8.4)         │
     │  Port 8000         │
     │  /app (volume)     │
     └───────┬────────────┘
             │
             │ DATABASE_URL
             │
     ┌───────▼──────────────┐
     │ Alwaysdata (distante)│
     │ MySQL/PostgreSQL     │
     │ Ton serveur          │
     └──────────────────────┘
```

## Notes importantes

1. **Secrets en production** : Change `APP_SECRET` en production
2. **Permissions** : Utilise le même utilisateur pour éviter les problèmes de permissions
3. **Volumes** : Les modifications locales sont synchronisées en temps réel dans le container
4. **Git** : `.env.local` est ignoré ; utilise `.env.example` pour la documentation
5. **Migrations** : Gère-les avec `php bin/console doctrine:migrations:*`
