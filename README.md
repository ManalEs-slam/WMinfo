# NewsPortal (Laravel 12 / PHP 8+)

Plateforme complete de publication d actualites avec interface publique moderne et panneau admin securise.

## Prerequis XAMPP (Windows)
- PHP 8+ avec extensions `pdo_mysql` et `openssl`
- MySQL XAMPP actif (port 3306)
- Apache XAMPP actif
- Droits d ecriture sur `storage/` et `bootstrap/cache/`

## Configuration .env attendue
```
APP_NAME=NewsPortal
APP_URL=http://localhost/News/public
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=newsportal
DB_USERNAME=root
DB_PASSWORD=
```

## Installation (depuis C:\xampp\htdocs\News)
```
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

## Comptes seedes
- Admin: `admin@newsportal.test` / `password`
- Redacteur: `editor@newsportal.test` / `password`
- Lecteur: `reader@newsportal.test` / `password`

## Fonctionnalites
- Roles admin, redacteur, lecteur avec middleware `role`
- CRUD articles, categories, utilisateurs, moderation commentaires
- Tableau de bord stats avec graphique mensuel
- Interface publique: accueil, recherche, categories, videos, article detail, commentaires
- TinyMCE via CDN pour la redaction

## Tests manuels (obligatoires)
Voir `TESTS.md`.

## Commandes utiles
```
php artisan migrate --seed
php artisan storage:link
php artisan optimize:clear
```
