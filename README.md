# MyClubArchives

[English](#english) | [Français](#français)

---

## English

A simple web app for football clubs (and other clubs) to build an online archive of their history: match sheets, team photos, logos, press clippings, flags, banners and more.

**Features**
- Home carousel browsable by year or by category, plus a flat "All archives" page with filters
- One page per year, archives grouped by category; an archive can apply to several years
- Several images or PDFs per archive, with automatic resizing and thumbnails
- Permanent, shareable link for every archive, with social preview
- Admin area for several administrators: add, edit, hide, delete, bulk import, merge files, manage categories and accounts, download a backup
- Public "Propose an archive" form, with moderation before anything is published
- Credit and rights tracking on every item
- Security basics: hashed passwords, CSRF protection, login rate limiting, protected uploads
- Interface in English, French and Dutch: default language set in `config.php`, visitors switch with the EN / FR / NL links
- PHP + SQLite only: no database to create, no framework, works on basic shared hosting

**Requirements:** PHP 8.1+ with `pdo_sqlite` and `gd`, and Apache `mod_rewrite` (`.htaccess`).

**Installation (FTP)**
1. Copy `config.example.php` to `config.php` and adapt it (club name, registration number, colors, texts, contact).
2. Upload all files, including `.htaccess`, to the web root.
3. Open `/admin`: the first visit creates the administrator account.

One installation per club, on its own hosting. Interface languages are set in `config.php` (`lang`, `langs`); `tagline`, `home_title` and `home_text` can be a plain string or an array per language. Category names and archive content are entered once by the club and are not translated.

**License and data:** the code is released under the MIT license (see `LICENSE`). Only the code is published. Archives (`uploads/`), the database (`data/`), administrator accounts and a club's configuration (`config.php`) are never part of the repository and remain the property of each club. The archives of Union Royale Namur are not included.

First club: Union Royale Namur (registration no. 156), unionroyalenamur.be

---

## Français

Une application web simple pour les clubs de football (et autres clubs) qui veulent bâtir une archive en ligne de leur histoire : feuilles de match, photos d'équipes, logos, coupures de presse, drapeaux, bâches et plus encore.

**Fonctionnalités**
- Carrousel d'accueil par année ou par catégorie, et page "Toutes les archives" avec filtres
- Une page par année, archives classées par catégorie ; une archive peut concerner plusieurs années
- Plusieurs images ou PDF par archive, avec redimensionnement et miniatures automatiques
- Lien permanent partageable pour chaque archive, avec aperçu sur les réseaux sociaux
- Administration à plusieurs : ajout, modification, masquage, suppression, import en lot, fusion de fichiers, gestion des catégories et des comptes, sauvegarde téléchargeable
- Formulaire public "Proposer une archive", avec validation avant toute publication
- Suivi du crédit et des droits sur chaque élément
- Sécurité de base : mots de passe hachés, protection CSRF, limitation des tentatives de connexion, dossier d'envois protégé
- Interface en français, anglais et néerlandais : langue par défaut dans `config.php`, choix du visiteur via les liens EN / FR / NL
- PHP + SQLite uniquement : aucune base à créer, aucun framework, fonctionne sur un hébergement mutualisé simple

**Prérequis :** PHP 8.1 ou plus avec `pdo_sqlite` et `gd`, et Apache `mod_rewrite` (`.htaccess`).

**Installation (FTP)**
1. Copier `config.example.php` en `config.php` et l'adapter (nom du club, matricule, couleurs, textes, contact).
2. Déposer tous les fichiers, y compris `.htaccess`, à la racine du site.
3. Ouvrir `/admin` : la première visite crée le compte administrateur.

Une installation par club, sur son propre hébergement. Les langues de l'interface se règlent dans `config.php` (`lang`, `langs`) ; `tagline`, `home_title` et `home_text` peuvent être une simple phrase ou un tableau par langue. Les noms de catégories et le contenu des archives sont saisis par le club et ne sont pas traduits.

**Licence et données :** le code est publié sous licence MIT (voir `LICENSE`). Seul le code est publié. Les archives (`uploads/`), la base de données (`data/`), les comptes administrateurs et la configuration d'un club (`config.php`) ne font jamais partie du dépôt et restent la propriété de chaque club. Les archives de l'Union Royale Namur ne sont pas fournies.

Premier club : Union Royale Namur (matricule 156), unionroyalenamur.be
