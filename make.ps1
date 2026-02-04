# Script PowerShell équivalent au Makefile pour Windows
# Usage: .\make.ps1 <commande>

param(
    [Parameter(Position=0)]
    [string]$Command = "help"
)

function Show-Help {
    Write-Host "Commandes disponibles:" -ForegroundColor Cyan
    Write-Host "  .\make.ps1 build     - Construire les images Docker"
    Write-Host "  .\make.ps1 up        - Demarrer les containers"
    Write-Host "  .\make.ps1 up-logs   - Demarrer les containers avec les logs"
    Write-Host "  .\make.ps1 down      - Arreter les containers"
    Write-Host "  .\make.ps1 logs      - Voir les logs"
    Write-Host "  .\make.ps1 shell     - Ouvrir un shell dans le container PHP"
    Write-Host "  .\make.ps1 composer  - Executer composer install"
    Write-Host "  .\make.ps1 test      - Executer les tests"
    Write-Host "  .\make.ps1 lint      - Executer le linter"
    Write-Host "  .\make.ps1 migrate   - Executer les migrations"
    Write-Host "  .\make.ps1 db-create - Creer la base de donnees"
    Write-Host "  .\make.ps1 cache     - Vider le cache"
    Write-Host "  .\make.ps1 rebuild   - Reconstruire completement"
}

switch ($Command.ToLower()) {
    "help" {
        Show-Help
    }
    "build" {
        Write-Host "Construction des images Docker..." -ForegroundColor Green
        docker-compose build
    }
    "up" {
        Write-Host "Demarrage des containers..." -ForegroundColor Green
        docker-compose up -d
    }
    "up-logs" {
        Write-Host "Demarrage des containers avec logs..." -ForegroundColor Green
        docker-compose up
    }
    "down" {
        Write-Host "Arret des containers..." -ForegroundColor Green
        docker-compose down
    }
    "logs" {
        Write-Host "Affichage des logs..." -ForegroundColor Green
        docker-compose logs -f
    }
    "shell" {
        Write-Host "Ouverture du shell dans le container PHP..." -ForegroundColor Green
        docker exec -it symfony_app bash
    }
    "composer" {
        Write-Host "Installation des dependances..." -ForegroundColor Green
        docker exec -it symfony_app composer install
    }
    "test" {
        Write-Host "Execution des tests..." -ForegroundColor Green
        docker exec -it symfony_app composer test
    }
    "lint" {
        Write-Host "Execution du linter..." -ForegroundColor Green
        docker exec -it symfony_app composer lint
    }
    "migrate" {
        Write-Host "Execution des migrations..." -ForegroundColor Green
        docker exec -it symfony_app php bin/console doctrine:migrations:migrate --no-interaction
    }
    "db-create" {
        Write-Host "Creation de la base de donnees..." -ForegroundColor Green
        docker exec -it symfony_app php bin/console doctrine:database:create --if-not-exists
    }
    "cache" {
        Write-Host "Vidage du cache..." -ForegroundColor Green
        docker exec -it symfony_app php bin/console cache:clear
    }
    "rebuild" {
        Write-Host "Reconstruction complete..." -ForegroundColor Green
        docker-compose down -v
        docker-compose build --no-cache
        docker-compose up -d
    }
    default {
        Write-Host "Commande inconnue: $Command" -ForegroundColor Red
        Show-Help
    }
}
