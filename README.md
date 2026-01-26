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

## Fonctionnalité Multilingue
L'application supporte maintenant plusieurs langues pour l'interface utilisateur.

- **Langues disponibles** :
    - Arabe (`ar`) - Langue par défaut
    - Français (`fr`)
    - Anglais (`en`)

- **Fonctionnement** :
    - Un middleware `SetLocale` détecte la langue de l'utilisateur stockée en session. Si aucune langue n'est définie, l'arabe (`ar`) est utilisé par défaut.
    - La direction du texte (`rtl` pour l'arabe, `ltr` pour les autres) est automatiquement gérée et appliquée au layout.
    - Un sélecteur de langue est disponible dans la barre de navigation (publique et admin) pour changer de langue à tout moment.

- **Fichiers de traduction** :
    - Les textes sont stockés dans le répertoire `lang/`.
    - Chaque langue a son propre sous-répertoire (`lang/ar`, `lang/fr`, `lang/en`).
    - Les fichiers contiennent des tableaux PHP associant des clés de traduction à leur valeur dans la langue concernée (ex: `__('messages.dashboard')`).

- **Ajouter une nouvelle langue** (ex: `de` pour l'allemand) :
    1.  Créez un nouveau répertoire `lang/de`.
    2.  Copiez les fichiers de `lang/en` vers `lang/de`.
    3.  Traduisez les valeurs dans les fichiers de `lang/de`.
    4.  Ajoutez `'de'` à la liste des langues supportées dans le middleware `app/Http/Middleware/SetLocale.php` et dans le contrôleur `app/Http/Controllers/LanguageController.php`.
    5.  Ajoutez le lien vers la nouvelle langue dans les sélecteurs de langue (ex: `resources/views/layouts/public.blade.php`).
