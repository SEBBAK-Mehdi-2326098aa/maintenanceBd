# 🏆 Gestion des Championnats Sportifs

Application Symfony pour la gestion des championnats, compétitions et épreuves sportives.

## 📋 Structure de l'application

L'application suit une hiérarchie à trois niveaux :

1. **Championnat** : Un ensemble de compétitions liées à un sport spécifique
2. **Compétition** : Un tournoi ou une ligue au sein d'un championnat
3. **Épreuve** : Une discipline au sein d'une compétition (individuelle, en équipe ou mixte)

### Relations entre les entités

```
Sport (1) ──── (*) Championnat (1) ──── (*) Compétition (1) ──── (*) Épreuve
```

## 🚀 Installation

```bash
# Installer les dépendances
composer install

# Créer la base de données
php bin/console doctrine:database:create

# Exécuter les migrations
php bin/console doctrine:migrations:migrate

# (Optionnel) Charger des données de test
php bin/console doctrine:fixtures:load
```

## 🧪 Tests

```bash
# Exécuter tous les tests
./vendor/bin/phpunit

# Exécuter les tests avec détails
./vendor/bin/phpunit --testdox

# Exécuter seulement les tests d'entités
./vendor/bin/phpunit tests/Entity/

# Exécuter seulement les tests de contrôleurs
./vendor/bin/phpunit tests/Controller/
```

**État actuel : 26 tests, 72 assertions - ✅ Tous passent**

## 📁 Structure du projet

### Entités (`src/Entity/`)

- **Sport** : Sport de base (ex: Football, Basketball)
- **Championnat** : Conteneur de compétitions pour un sport
- **Competition** : Tournoi ou ligue au sein d'un championnat
- **Epreuve** : Discipline spécifique (type: individuelle, équipe, mixte)

### Contrôleurs (`src/Controller/`)

#### ChampionnatController
- `GET /championnat/` - Liste tous les championnats
- `GET /championnat/new` - Formulaire de création
- `POST /championnat/new` - Création d'un championnat
- `GET /championnat/{id}` - Détails d'un championnat

#### CompetitionController
- `GET /competition/championnat/{championnatId}` - Liste des compétitions d'un championnat
- `GET /competition/new/{championnatId}` - Formulaire de création
- `POST /competition/new/{championnatId}` - Création d'une compétition
- `GET /competition/{id}` - Détails d'une compétition

#### EpreuveController
- `GET /epreuve/competition/{competitionId}` - Liste des épreuves d'une compétition
- `GET /epreuve/new/{competitionId}` - Formulaire de création
- `POST /epreuve/new/{competitionId}` - Création d'une épreuve
- `GET /epreuve/{id}` - Détails d'une épreuve

### Templates (`templates/`)

Tous les templates incluent :
- Navigation par fil d'Ariane (breadcrumb)
- Liens de navigation contextuelle
- Icônes pour une meilleure UX
- Design responsive avec CSS intégré

## 🎨 Fonctionnalités

### Navigation améliorée
- Menu de navigation global dans l'en-tête
- Fil d'Ariane sur chaque page
- Liens contextuels entre les entités
- Compteurs d'entités associées
- Icônes pour les actions courantes

### Types d'épreuves
- 👤 **Individuelle** : Compétition en solo
- 👥 **Équipe** : Compétition par équipe
- 🔀 **Mixte** : Les deux types possibles

## 🛠️ Développement

### Créer une nouvelle migration

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

### Lancer le serveur de développement

```bash
symfony server:start
# ou
php -S localhost:8000 -t public/
```

### Accéder à l'application

- Page d'accueil : http://localhost:8000/home
- Liste des championnats : http://localhost:8000/championnat/

## 📊 Base de données de test

Pour les tests, l'application utilise SQLite :

```bash
# Créer le schéma de test
php bin/console doctrine:schema:create --env=test
```

## 🤝 Contribution

Les contributions sont les bienvenues ! Assurez-vous que :
- Tous les tests passent
- Le code respecte les standards PSR-12
- Les nouvelles fonctionnalités incluent des tests

## 📝 License

Ce projet est un exercice académique pour le BUT 3 - Maintenance de Bases de Données.

