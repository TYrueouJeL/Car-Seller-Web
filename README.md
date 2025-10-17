# Car Seller Web

Projet web Symfony + JavaScript pour la gestion d'une plateforme de vente et location de véhicules.

## Table des matières

1. Installation
2. Configuration
3. Commandes utiles
4. Structure du projet
5. Tests
6. Fixtures et migration de la base
7. Déploiement
8. Contribution
9. Licence

## 1. Installation

Prérequis :
- PHP 8.x
- Composer
- Node.js et npm
- Une base de données compatible (ex : MySQL, PostgreSQL)
- (Optionnel) Docker / Docker Compose

Étapes d'installation :

1. Cloner le dépôt :
    - `git clone <url-du-repo>`
    - `cd Car-Seller-Web`

2. Installer les dépendances PHP :
    - `composer install --no-interaction --optimize-autoloader`

3. Installer les dépendances JS et compiler les assets :
    - `npm install`
    - En développement : `npm run dev`
    - En production : `npm run build`

4. Configurer les variables d'environnement :
    - Copier `env` ou créer un fichier `.env.local` et définir `DATABASE_URL`, `MAILER_DSN`, etc.

## 2. Configuration

Fichiers de config principaux :
- Configuration Symfony : `config/`
- Routes : `config/routes/` et `config/routes.yaml`
- Services : `config/services.yaml`
- Webpack Encore / assets : `assets/` et sortie dans `public/build/`

Exemples :
- Définir la connexion DB dans `DATABASE_URL` (fichier `.env.local`) :
    - `DATABASE_URL="mysql://user:pass@127.0.0.1:3306/car_seller_db"`

## 3. Commandes utiles

Symfony console :
- Lancer le serveur local : `php -S 127.0.0.1:8000 -t public` ou `symfony server:start`
- Afficher les routes : `php bin/console debug:router`
- Voir les services : `php bin/console debug:container`

Doctrine :
- Créer la base : `php bin/console doctrine:database:create`
- Générer et exécuter les migrations :
    - `php bin/console make:migration`
    - `php bin/console doctrine:migrations:migrate`

Assets :
- Compilation dev : `npm run dev`
- Compilation prod : `npm run build`

Tests :
- `vendor/bin/phpunit` ou `php bin/phpunit` selon config

Docker (si présent) :
- `docker-compose -f compose.yaml up --build` (adapter selon les fichiers compose)

## 4. Structure du projet

Principaux dossiers :
- `src/` : code PHP (contrôleurs, entités, repository, services)
- `templates/` : vues Twig
- `public/` : point d'entrée web, assets publiés
- `assets/` : sources JS/CSS (Webpack Encore)
- `config/` : configuration Symfony
- `migrations/` : migrations Doctrine
- `tests/` : tests unitaires / fonctionnels
- `bin/` : binaires utiles (console, phpunit)

Fichiers clés :
- `public/index.php`
- `composer.json`
- `package.json`
- `webpack.config.js`
- `phpunit.dist.xml`

## 5. Tests

Exécuter les tests unitaires et fonctionnels :
- `php bin/phpunit` (ou `vendor/bin/phpunit`)

Ajouter de nouveaux tests dans `tests/`. Utiliser les fixtures si nécessaire (voir `src/DataFixtures/AppFixtures.php`).

## 6. Fixtures et migration de la base

Importer les fixtures (après création et migration de la DB) :
- `php bin/console doctrine:fixtures:load --no-interaction`

Migrations :
- Pour créer une migration : `php bin/console make:migration`
- Pour appliquer : `php bin/console doctrine:migrations:migrate`

## 7. Déploiement

Points importants :
- Compiler les assets en mode production (`npm run build`)
- Exécuter les migrations en production
- Mettre en cache et optimiser :
    - `php bin/console cache:clear --env=prod`
    - `php bin/console cache:warmup --env=prod`
- Configurer le serveur web pour pointer vers `public/`

Si Docker est utilisé, adapter les services DB et PHP-FPM selon `compose.yaml` / `compose.override.yaml`.

## 8. Contribution

- Forker le projet, créer une branche feature/bugfix, ouvrir une Pull Request.
- Respecter les conventions Composer / PSR-12.
- Ajouter des tests pour les nouveaux comportements.

## 9. Licence

Aucune licence spécifiée. Ajouter un fichier `LICENSE` si nécessaire.

---

Annexes :
- Points d'entrée assets : `assets/app.js`, `assets/styles/app.css`
- Build public : `public/build/` (contient `app.js`, `app.css`, manifestes)
- Fixtures : `src/DataFixtures/AppFixtures.php`
