<?php
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS'])]);
session_start();
ini_set('display_errors', '0');
header('X-Content-Type-Options: nosniff'); header('X-Frame-Options: SAMEORIGIN'); header('Referrer-Policy: strict-origin-when-cross-origin');
if (!empty($_SERVER['HTTPS'])) header('Strict-Transport-Security: max-age=31536000');
$C = require __DIR__.(file_exists(__DIR__.'/config.php') ? '/config.php' : '/config.example.php');
$LANGS = array_values(array_intersect(['fr', 'en', 'nl'], (array)($C['langs'] ?? ['fr', 'en', 'nl']))) ?: ['fr'];
$L = in_array($C['lang'] ?? 'fr', $LANGS, true) ? ($C['lang'] ?? 'fr') : $LANGS[0];
if (isset($_GET['lang']) && in_array($_GET['lang'], $LANGS, true)) { $L = $_GET['lang']; setcookie('lang', $L, ['expires' => time() + 31536000, 'path' => '/', 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS'])]); }
elseif (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $LANGS, true)) $L = $_COOKIE['lang'];
$TR = [
  'fr' => [
    'matricule' => 'Matricule',
    'propose' => 'Proposer une archive',
    'all_archives' => 'Toutes les archives',
    'home' => 'Accueil',
    'home_title_def' => 'Archives - %s',
    'home_text_def' => 'Feuilles de match, photos d\'équipes, logos et coupures de presse, à parcourir par année ou par catégorie.',
    'by_year' => 'Par année',
    'by_cat' => 'Par catégorie',
    'archive' => 'archive',
    'archives_pl' => 'archives',
    'none_yet' => 'Aucune archive pour le moment.',
    'add_first' => 'Ajoutez la première depuis l\'administration.',
    'not_found' => 'Introuvable',
    'cat_nf' => 'Catégorie introuvable',
    'back_cats' => 'Retour aux catégories',
    'all_cats_back' => 'Toutes les catégories',
    'none_in_cat' => 'Aucune archive dans cette catégorie pour le moment.',
    'all_years_back' => 'Toutes les années',
    'cat_colon' => 'Catégorie :',
    'all_f' => 'Toutes',
    'goto' => 'Aller à :',
    'archives' => 'Archives',
    'arch_nf' => 'Archive introuvable',
    'open_pdf' => 'Ouvrir le document (PDF)',
    'years_colon' => 'Années :',
    'credit_lbl' => 'Crédit :',
    'author_unknown' => 'Auteur non identifié',
    'st_ok' => 'validé',
    'st_check' => 'à vérifier',
    'st_unk' => 'inconnu',
    'link_copied' => 'Lien copié',
    'share' => 'Partager cette archive',
    'concern' => 'Un élément vous concerne ? Écrivez à %s.',
    'err_session' => 'Session expirée, rechargez la page.',
    'err_rate' => 'Trop de propositions en peu de temps, réessayez plus tard.',
    'err_quota_pub' => 'Le site ne peut plus recevoir de fichiers pour le moment. Écrivez à %s.',
    'err_fields' => 'Indiquez un titre, une année et confirmez vos droits.',
    'err_nofile_pub' => 'Ajoutez au moins une photo (JPG, PNG ou WebP, 15 Mo maximum par fichier).',
    'thanks_h' => 'Merci !',
    'thanks_p' => 'Votre proposition a été transmise. Un administrateur la vérifiera avant de la publier.',
    'back_home' => 'Retour à l\'accueil',
    'propose_p' => 'Une photo, une feuille de match, un souvenir du club ? Envoyez-le : il sera vérifié par un administrateur avant publication.',
    'lbl_photos_pdf' => 'Photos ou documents (JPG, PNG, WebP, PDF)',
    'lbl_photos' => 'Photos ou scans (JPG, PNG, WebP)',
    'lbl_title' => 'Titre',
    'lbl_year_approx' => 'Année (approximative si besoin)',
    'lbl_date_pub' => 'Date ou précision (ex. « vers 1956 », « saison 1934-35 »)',
    'lbl_know' => 'Ce que vous savez (personnes, lieu, match...)',
    'lbl_author_src' => 'Auteur de la photo ou source du document (si connu)',
    'lbl_name' => 'Votre nom',
    'lbl_email' => 'Votre e-mail (pour vous poser une question, jamais publié)',
    'lbl_rights' => 'Je confirme avoir le droit de transmettre ce document pour publication.',
    'btn_send' => 'Envoyer',
    'admin' => 'Administration',
    'login' => 'Connexion',
    'create_admin' => 'Créer le compte administrateur',
    'pw_hint' => 'Choisissez un mot de passe d\'au moins 10 caractères.',
    'lbl_user' => 'Identifiant',
    'lbl_pass' => 'Mot de passe',
    'btn_login' => 'Se connecter',
    'btn_create' => 'Créer le compte',
    'err_attempts' => 'Trop de tentatives. Réessayez dans 15 minutes.',
    'err_login' => 'Identifiants incorrects.',
    'err_cat_exists' => t('err_cat_exists'),
    'err_name_used' => t('err_name_used'),
    'err_cat_inuse' => t('err_cat_inuse'),
    'back' => 'Retour',
    'categories' => 'Catégories',
    'cat_help' => 'Renommer une catégorie met à jour toutes ses archives. L\'ordre ci-dessous est celui du carrousel.',
    'btn_rename' => 'Renommer',
    'n_archives' => '%d archive(s)',
    'btn_delete' => 'Supprimer',
    'add_cat' => 'Ajouter une catégorie',
    'lbl_name_f' => 'Nom',
    'btn_add' => 'Ajouter',
    'import' => 'Import en lot',
    'err_quota_short' => 'quota atteint',
    'err_format' => 'format non reconnu ou fichier trop lourd',
    'imp_files' => 'Fichiers (JPG, PNG, WebP, PDF) : sélectionnez-en autant que vous voulez',
    'imp_defaults' => 'Valeurs par défaut pour tous les fichiers de cet envoi (modifiables ensuite) :',
    'lbl_year' => 'Année',
    'lbl_cat' => 'Catégorie',
    'cat_lower' => 'catégorie',
    'lbl_credit' => 'Crédit',
    'lbl_credit_status' => 'Statut du crédit',
    'imp_group' => 'Regrouper tous les fichiers de cet envoi en une seule archive (plusieurs images ou pages)',
    'imp_send' => 'Envoyer les fichiers',
    'js_send' => 'Envoi ',
    'js_neterr' => 'erreur réseau',
    'js_done' => ' fichier(s) envoyé(s).',
    'js_fail' => ' Échecs : ',
    'imp_todo' => 'À compléter avant publication (%d)',
    'imp_for_sel' => 'Pour la sélection : année',
    'imp_apply' => 'Appliquer à la sélection',
    'lbl_date_shown' => 'Date affichée',
    'imp_save' => 'Enregistrer les modifications',
    'imp_merge' => 'Fusionner la sélection en une archive',
    'imp_publish' => 'Publier la sélection',
    'imp_delsel' => 'Supprimer la sélection',
    'confirm_delsel' => 'Supprimer la sélection ?',
    'admins' => 'Administrateurs',
    'err_user_exists' => 'Cet identifiant existe déjà.',
    'you' => t('you'),
    'confirm_deluser' => 'Supprimer ce compte ?',
    'add_admin' => 'Ajouter un administrateur',
    'lbl_pw_min' => 'Mot de passe (10 caractères minimum)',
    'change_pw' => 'Changer mon mot de passe',
    'lbl_newpw' => 'Nouveau mot de passe',
    'btn_modify' => 'Modifier',
    'err_file_ignored' => 'Un fichier a été ignoré (formats acceptés : JPG, PNG, WebP, PDF).',
    'err_need_file' => 'Ajoutez au moins un fichier.',
    'edit_archive' => 'Modifier une archive',
    'add_archive' => 'Ajouter une archive',
    'proposed_by' => 'Proposé par',
    'current_files' => 'Fichiers actuels :',
    'lbl_addfiles' => 'Ajouter des fichiers (JPG, PNG, WebP ou PDF ; plusieurs possibles)',
    'lbl_refyear' => 'Année de référence (création ou date principale)',
    'years_concerned' => 'Années concernées',
    'years_help' => '(cochez toutes celles où l\'archive s\'applique, ex. années d\'utilisation d\'un logo ; un clic sur une décennie inverse sa sélection)',
    'lbl_date_hint' => 'Date affichée (ex. « septembre 1934 », « vers 1956 », « saison 1934-35 »)',
    'lbl_description' => 'Description',
    'lbl_author_credit' => 'Auteur / crédit',
    'published' => 'Publiée',
    'btn_save' => 'Enregistrer',
    'backup' => 'Télécharger une sauvegarde',
    'logout' => 'Déconnexion',
    'space_used' => 'Espace utilisé par les fichiers : %s Mo sur %d Mo prévus.',
    'added_by' => 'Ajouté par',
    'to_validate' => 'à valider',
    'hidden' => 'masquée',
    'proposal' => '(proposition)',
    'approve' => 'Approuver',
    'confirm_del' => 'Supprimer définitivement ?',
    'page_nf' => 'Page introuvable',
  ],
  'en' => [
    'matricule' => 'Registration no.',
    'propose' => 'Propose an archive',
    'all_archives' => 'All archives',
    'home' => 'Home',
    'home_title_def' => 'Archives - %s',
    'home_text_def' => 'Match sheets, team photos, logos and press clippings, to browse by year or by category.',
    'by_year' => 'By year',
    'by_cat' => 'By category',
    'archive' => 'archive',
    'archives_pl' => 'archives',
    'none_yet' => 'No archives yet.',
    'add_first' => 'Add the first one from the admin area.',
    'not_found' => 'Not found',
    'cat_nf' => 'Category not found',
    'back_cats' => 'Back to categories',
    'all_cats_back' => 'All categories',
    'none_in_cat' => 'No archives in this category yet.',
    'all_years_back' => 'All years',
    'cat_colon' => 'Category:',
    'all_f' => 'All',
    'goto' => 'Go to:',
    'archives' => 'Archives',
    'arch_nf' => 'Archive not found',
    'open_pdf' => 'Open the document (PDF)',
    'years_colon' => 'Years:',
    'credit_lbl' => 'Credit:',
    'author_unknown' => 'Author not identified',
    'st_ok' => 'verified',
    'st_check' => 'to verify',
    'st_unk' => 'unknown',
    'link_copied' => 'Link copied',
    'share' => 'Share this archive',
    'concern' => 'Is something here about you? Write to %s.',
    'err_session' => 'Session expired, please reload the page.',
    'err_rate' => 'Too many submissions in a short time, please try again later.',
    'err_quota_pub' => 'The site cannot receive more files right now. Write to %s.',
    'err_fields' => 'Enter a title and a year, and confirm your rights.',
    'err_nofile_pub' => 'Add at least one photo (JPG, PNG or WebP, 15 MB maximum per file).',
    'thanks_h' => 'Thank you!',
    'thanks_p' => 'Your submission has been received. An administrator will check it before publishing.',
    'back_home' => 'Back to home',
    'propose_p' => 'A photo, a match sheet, a memory of the club? Send it in: an administrator will check it before it is published.',
    'lbl_photos_pdf' => 'Photos or documents (JPG, PNG, WebP, PDF)',
    'lbl_photos' => 'Photos or scans (JPG, PNG, WebP)',
    'lbl_title' => 'Title',
    'lbl_year_approx' => 'Year (approximate if needed)',
    'lbl_date_pub' => 'Date or detail (e.g. "around 1956", "season 1934-35")',
    'lbl_know' => 'What you know (people, place, match...)',
    'lbl_author_src' => 'Photo author or document source (if known)',
    'lbl_name' => 'Your name',
    'lbl_email' => 'Your email (so we can ask you a question, never published)',
    'lbl_rights' => 'I confirm that I have the right to submit this document for publication.',
    'btn_send' => 'Send',
    'admin' => 'Administration',
    'login' => 'Login',
    'create_admin' => 'Create the administrator account',
    'pw_hint' => 'Choose a password of at least 10 characters.',
    'lbl_user' => 'Username',
    'lbl_pass' => 'Password',
    'btn_login' => 'Log in',
    'btn_create' => 'Create account',
    'err_attempts' => 'Too many attempts. Try again in 15 minutes.',
    'err_login' => 'Incorrect credentials.',
    'err_cat_exists' => 'This category already exists.',
    'err_name_used' => 'This name is already in use.',
    'err_cat_inuse' => 'Not possible: archives still use this category.',
    'back' => 'Back',
    'categories' => 'Categories',
    'cat_help' => 'Renaming a category updates all its archives. The order below is the carousel order.',
    'btn_rename' => 'Rename',
    'n_archives' => '%d archive(s)',
    'btn_delete' => 'Delete',
    'add_cat' => 'Add a category',
    'lbl_name_f' => 'Name',
    'btn_add' => 'Add',
    'import' => 'Bulk import',
    'err_quota_short' => 'quota reached',
    'err_format' => 'unrecognized format or file too large',
    'imp_files' => 'Files (JPG, PNG, WebP, PDF): select as many as you like',
    'imp_defaults' => 'Default values for all files in this upload (editable afterwards):',
    'lbl_year' => 'Year',
    'lbl_cat' => 'Category',
    'cat_lower' => 'category',
    'lbl_credit' => 'Credit',
    'lbl_credit_status' => 'Credit status',
    'imp_group' => 'Group all files of this upload into a single archive (several images or pages)',
    'imp_send' => 'Upload files',
    'js_send' => 'Uploading ',
    'js_neterr' => 'network error',
    'js_done' => ' file(s) uploaded.',
    'js_fail' => ' Failures: ',
    'imp_todo' => 'To complete before publishing (%d)',
    'imp_for_sel' => 'For the selection: year',
    'imp_apply' => 'Apply to selection',
    'lbl_date_shown' => 'Displayed date',
    'imp_save' => 'Save changes',
    'imp_merge' => 'Merge selection into one archive',
    'imp_publish' => 'Publish selection',
    'imp_delsel' => 'Delete selection',
    'confirm_delsel' => 'Delete the selection?',
    'admins' => 'Administrators',
    'err_user_exists' => 'This username already exists.',
    'you' => '(you)',
    'confirm_deluser' => 'Delete this account?',
    'add_admin' => 'Add an administrator',
    'lbl_pw_min' => 'Password (10 characters minimum)',
    'change_pw' => 'Change my password',
    'lbl_newpw' => 'New password',
    'btn_modify' => 'Edit',
    'err_file_ignored' => 'A file was ignored (accepted formats: JPG, PNG, WebP, PDF).',
    'err_need_file' => 'Add at least one file.',
    'edit_archive' => 'Edit an archive',
    'add_archive' => 'Add an archive',
    'proposed_by' => 'Proposed by',
    'current_files' => 'Current files:',
    'lbl_addfiles' => 'Add files (JPG, PNG, WebP or PDF; several allowed)',
    'lbl_refyear' => 'Reference year (creation or main date)',
    'years_concerned' => 'Years concerned',
    'years_help' => '(tick every year the archive applies to, e.g. the years a logo was used; clicking a decade toggles it)',
    'lbl_date_hint' => 'Displayed date (e.g. "September 1934", "around 1956", "season 1934-35")',
    'lbl_description' => 'Description',
    'lbl_author_credit' => 'Author / credit',
    'published' => 'Published',
    'btn_save' => 'Save',
    'backup' => 'Download a backup',
    'logout' => 'Log out',
    'space_used' => 'Space used by files: %s MB of %d MB planned.',
    'added_by' => 'Added by',
    'to_validate' => 'to validate',
    'hidden' => 'hidden',
    'proposal' => '(submission)',
    'approve' => 'Approve',
    'confirm_del' => 'Delete permanently?',
    'page_nf' => 'Page not found',
  ],
  'nl' => [
    'matricule' => 'Stamnummer',
    'propose' => 'Een archief voorstellen',
    'all_archives' => 'Alle archieven',
    'home' => 'Home',
    'home_title_def' => 'Archieven - %s',
    'home_text_def' => 'Wedstrijdbladen, ploegfoto\'s, logo\'s en krantenknipsels, te doorbladeren per jaar of per categorie.',
    'by_year' => 'Per jaar',
    'by_cat' => 'Per categorie',
    'archive' => 'archief',
    'archives_pl' => 'archieven',
    'none_yet' => 'Nog geen archieven.',
    'add_first' => 'Voeg het eerste toe via het beheer.',
    'not_found' => 'Niet gevonden',
    'cat_nf' => 'Categorie niet gevonden',
    'back_cats' => 'Terug naar de categorieën',
    'all_cats_back' => 'Alle categorieën',
    'none_in_cat' => 'Nog geen archieven in deze categorie.',
    'all_years_back' => 'Alle jaren',
    'cat_colon' => 'Categorie:',
    'all_f' => 'Alle',
    'goto' => 'Ga naar:',
    'archives' => 'Archieven',
    'arch_nf' => 'Archief niet gevonden',
    'open_pdf' => 'Document openen (PDF)',
    'years_colon' => 'Jaren:',
    'credit_lbl' => 'Bron:',
    'author_unknown' => 'Auteur onbekend',
    'st_ok' => 'geverifieerd',
    'st_check' => 'te verifiëren',
    'st_unk' => 'onbekend',
    'link_copied' => 'Link gekopieerd',
    'share' => 'Dit archief delen',
    'concern' => 'Betreft iets u? Schrijf naar %s.',
    'err_session' => 'Sessie verlopen, laad de pagina opnieuw.',
    'err_rate' => 'Te veel voorstellen in korte tijd, probeer het later opnieuw.',
    'err_quota_pub' => 'De site kan momenteel geen bestanden meer ontvangen. Schrijf naar %s.',
    'err_fields' => 'Geef een titel en een jaar op en bevestig uw rechten.',
    'err_nofile_pub' => 'Voeg minstens één foto toe (JPG, PNG of WebP, maximaal 15 MB per bestand).',
    'thanks_h' => 'Bedankt!',
    'thanks_p' => 'Uw voorstel is verzonden. Een beheerder controleert het voordat het wordt gepubliceerd.',
    'back_home' => 'Terug naar de startpagina',
    'propose_p' => 'Een foto, een wedstrijdblad, een herinnering aan de club? Stuur het in: een beheerder controleert het voor het wordt gepubliceerd.',
    'lbl_photos_pdf' => 'Foto\'s of documenten (JPG, PNG, WebP, PDF)',
    'lbl_photos' => 'Foto\'s of scans (JPG, PNG, WebP)',
    'lbl_title' => 'Titel',
    'lbl_year_approx' => 'Jaar (indien nodig bij benadering)',
    'lbl_date_pub' => 'Datum of precisie (bv. "rond 1956", "seizoen 1934-35")',
    'lbl_know' => 'Wat u weet (personen, plaats, wedstrijd...)',
    'lbl_author_src' => 'Maker van de foto of bron van het document (indien bekend)',
    'lbl_name' => 'Uw naam',
    'lbl_email' => 'Uw e-mail (om u een vraag te stellen, nooit gepubliceerd)',
    'lbl_rights' => 'Ik bevestig dat ik het recht heb dit document ter publicatie door te geven.',
    'btn_send' => 'Verzenden',
    'admin' => 'Beheer',
    'login' => 'Aanmelden',
    'create_admin' => 'Beheerdersaccount aanmaken',
    'pw_hint' => 'Kies een wachtwoord van minstens 10 tekens.',
    'lbl_user' => 'Gebruikersnaam',
    'lbl_pass' => 'Wachtwoord',
    'btn_login' => 'Aanmelden',
    'btn_create' => 'Account aanmaken',
    'err_attempts' => 'Te veel pogingen. Probeer het over 15 minuten opnieuw.',
    'err_login' => 'Onjuiste gegevens.',
    'err_cat_exists' => 'Deze categorie bestaat al.',
    'err_name_used' => 'Deze naam is al in gebruik.',
    'err_cat_inuse' => 'Niet mogelijk: er gebruiken nog archieven deze categorie.',
    'back' => 'Terug',
    'categories' => 'Categorieën',
    'cat_help' => 'Een categorie hernoemen werkt al haar archieven bij. De volgorde hieronder is die van de carrousel.',
    'btn_rename' => 'Hernoemen',
    'n_archives' => '%d archief/archieven',
    'btn_delete' => 'Verwijderen',
    'add_cat' => 'Een categorie toevoegen',
    'lbl_name_f' => 'Naam',
    'btn_add' => 'Toevoegen',
    'import' => 'Bulkimport',
    'err_quota_short' => 'quotum bereikt',
    'err_format' => 'onbekend formaat of bestand te groot',
    'imp_files' => 'Bestanden (JPG, PNG, WebP, PDF): selecteer er zoveel u wilt',
    'imp_defaults' => 'Standaardwaarden voor alle bestanden van deze upload (nadien aanpasbaar):',
    'lbl_year' => 'Jaar',
    'lbl_cat' => 'Categorie',
    'cat_lower' => 'categorie',
    'lbl_credit' => 'Bron',
    'lbl_credit_status' => 'Status van de bron',
    'imp_group' => 'Alle bestanden van deze upload in één archief samenvoegen (meerdere afbeeldingen of pagina\'s)',
    'imp_send' => 'Bestanden verzenden',
    'js_send' => 'Verzenden ',
    'js_neterr' => 'netwerkfout',
    'js_done' => ' bestand(en) verzonden.',
    'js_fail' => ' Mislukt: ',
    'imp_todo' => 'Aan te vullen voor publicatie (%d)',
    'imp_for_sel' => 'Voor de selectie: jaar',
    'imp_apply' => 'Toepassen op selectie',
    'lbl_date_shown' => 'Getoonde datum',
    'imp_save' => 'Wijzigingen opslaan',
    'imp_merge' => 'Selectie samenvoegen tot één archief',
    'imp_publish' => 'Selectie publiceren',
    'imp_delsel' => 'Selectie verwijderen',
    'confirm_delsel' => 'De selectie verwijderen?',
    'admins' => 'Beheerders',
    'err_user_exists' => 'Deze gebruikersnaam bestaat al.',
    'you' => '(u)',
    'confirm_deluser' => 'Dit account verwijderen?',
    'add_admin' => 'Een beheerder toevoegen',
    'lbl_pw_min' => 'Wachtwoord (minstens 10 tekens)',
    'change_pw' => 'Mijn wachtwoord wijzigen',
    'lbl_newpw' => 'Nieuw wachtwoord',
    'btn_modify' => 'Wijzigen',
    'err_file_ignored' => 'Een bestand werd genegeerd (toegelaten formaten: JPG, PNG, WebP, PDF).',
    'err_need_file' => 'Voeg minstens één bestand toe.',
    'edit_archive' => 'Een archief wijzigen',
    'add_archive' => 'Een archief toevoegen',
    'proposed_by' => 'Voorgesteld door',
    'current_files' => 'Huidige bestanden:',
    'lbl_addfiles' => 'Bestanden toevoegen (JPG, PNG, WebP of PDF; meerdere mogelijk)',
    'lbl_refyear' => 'Referentiejaar (creatie of hoofddatum)',
    'years_concerned' => 'Betrokken jaren',
    'years_help' => '(vink alle jaren aan waarop het archief van toepassing is, bv. de gebruiksjaren van een logo; een klik op een decennium keert de selectie om)',
    'lbl_date_hint' => 'Getoonde datum (bv. "september 1934", "rond 1956", "seizoen 1934-35")',
    'lbl_description' => 'Beschrijving',
    'lbl_author_credit' => 'Auteur / bron',
    'published' => 'Gepubliceerd',
    'btn_save' => 'Opslaan',
    'backup' => 'Een back-up downloaden',
    'logout' => 'Afmelden',
    'space_used' => 'Gebruikte ruimte door bestanden: %s MB van %d MB voorzien.',
    'added_by' => 'Toegevoegd door',
    'to_validate' => 'te valideren',
    'hidden' => 'verborgen',
    'proposal' => '(voorstel)',
    'approve' => 'Goedkeuren',
    'confirm_del' => 'Definitief verwijderen?',
    'page_nf' => 'Pagina niet gevonden',
  ],
];
function t($k, ...$a){ global $TR, $L; $s = $TR[$L][$k] ?? $TR['fr'][$k] ?? $k; return $a ? vsprintf($s, $a) : $s; }
@mkdir(__DIR__.'/data'); @mkdir(__DIR__.'/uploads');
if (!file_exists(__DIR__.'/data/.htaccess')) file_put_contents(__DIR__.'/data/.htaccess', "Require all denied\nDeny from all\n");
if (!file_exists(__DIR__.'/uploads/.htaccess')) { file_put_contents(__DIR__.'/uploads/.htaccess', "<FilesMatch \"\\.(php|phtml|phar|cgi|pl)$\">\nRequire all denied\n</FilesMatch>\n"); @touch(__DIR__.'/uploads/index.html'); }
$db = new PDO('sqlite:'.__DIR__.'/data/archive.sqlite3');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE IF NOT EXISTS items(id INTEGER PRIMARY KEY, year INT, date_label TEXT, category TEXT, title TEXT, description TEXT, file TEXT, thumb TEXT, credit TEXT, credit_status TEXT DEFAULT 'inconnu', published INT DEFAULT 1, created TEXT DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS users(id INTEGER PRIMARY KEY, username TEXT UNIQUE, hash TEXT);
CREATE TABLE IF NOT EXISTS item_files(id INTEGER PRIMARY KEY, item_id INT, file TEXT, thumb TEXT, pos INT DEFAULT 0);
CREATE TABLE IF NOT EXISTS item_years(item_id INT, year INT, PRIMARY KEY(item_id, year));
INSERT INTO item_files(item_id,file,thumb) SELECT id,file,thumb FROM items WHERE file<>'' AND id NOT IN (SELECT item_id FROM item_files);
UPDATE items SET file='', thumb='' WHERE file<>'' AND id IN (SELECT item_id FROM item_files);
INSERT INTO item_years(item_id,year) SELECT id,year FROM items WHERE id NOT IN (SELECT item_id FROM item_years);");
foreach (['submitter','submitter_contact','created_by','updated_by','batch'] as $c) if (!in_array($c, array_column($db->query("PRAGMA table_info(items)")->fetchAll(), 'name'))) $db->exec("ALTER TABLE items ADD COLUMN $c TEXT");
$db->exec("CREATE TABLE IF NOT EXISTS rate(ip TEXT, ts INT); CREATE TABLE IF NOT EXISTS loginfail(ip TEXT, ts INT)");
$db->exec("CREATE TABLE IF NOT EXISTS categories(id INTEGER PRIMARY KEY, name TEXT UNIQUE, pos INT DEFAULT 0)");
if (!$db->query("SELECT COUNT(*) FROM categories")->fetchColumn()) foreach ($C['categories'] as $i => $n) q("INSERT OR IGNORE INTO categories(name,pos) VALUES(?,?)", [$n, $i]); // config : liste de départ seulement
const STATUS = ['validé','à vérifier','inconnu']; // valeurs stockées en base (ne pas traduire) ; l'affichage passe par stl()
function stl($s){ $m = ['validé' => 'st_ok', 'à vérifier' => 'st_check', 'inconnu' => 'st_unk']; return isset($m[$s]) ? t($m[$s]) : $s; }
function stopts($sel){ return implode('', array_map(fn($x) => "<option value='".e($x)."'".($x === $sel ? ' selected' : '').">".e(stl($x))."</option>", STATUS)); }
function ct($v, $def = ''){ global $L; if ($v === null) return $def; if (is_array($v)) return $v[$L] ?? (reset($v) ?: $def); return $v; } // texte de config : chaîne ou tableau par langue
function langsw(){ global $L, $LANGS; if (count($LANGS) < 2) return ''; $qs = $_GET; unset($qs['lang'], $qs['r']); $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/'; $h = '<nav class=lg>';
  foreach ($LANGS as $x) $h .= "<a".($x === $L ? ' class=on' : '')." href='".e($path.'?'.http_build_query($qs + ['lang' => $x]))."'>$x</a>"; return $h.'</nav>'; }
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES); }
function q($sql, $a = []){ global $db; $s = $db->prepare($sql); $s->execute($a); return $s; }
function csrf(){ return $_SESSION['t'] ??= bin2hex(random_bytes(16)); }
function chk(){ if (!hash_equals($_SESSION['t'] ?? '', $_POST['t'] ?? '')) { http_response_code(400); exit(t('err_session')); } }
function go($u){ header('Location: '.$u); exit; }
function cats(){ return array_column(q("SELECT name FROM categories ORDER BY pos, id")->fetchAll(), 'name'); }
function isadmin(){ return !empty($_SESSION['u']); }
function need(){ if (!isadmin()) go('/admin'); }
$base = (isset($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'];

function img($tmp, $dst, $max){
  $i = @getimagesize($tmp); if (!$i) return false;
  $s = match($i[2]){ IMAGETYPE_JPEG => imagecreatefromjpeg($tmp), IMAGETYPE_PNG => imagecreatefrompng($tmp), IMAGETYPE_WEBP => imagecreatefromwebp($tmp), default => null };
  if (!$s) return false;
  [$w, $h] = $i; $k = min(1, $max / max($w, $h));
  return imagejpeg(imagescale($s, max(1, (int)($w*$k)), max(1, (int)($h*$k))), $dst, 82);
}
function page($title, $body, $og = []){
  global $C, $base, $L;
  $t = e($title.' - '.$C['club']);
  echo "<!doctype html><html lang=$L><head><meta charset=utf-8><meta name=viewport content='width=device-width,initial-scale=1'><title>$t</title>";
  echo "<meta property=og:title content='$t'><meta property=og:site_name content='".e($C['club'])."'>";
  if (!empty($og['desc'])) echo "<meta property=og:description content='".e($og['desc'])."'>";
  if (!empty($og['img'])) echo "<meta property=og:image content='".e($base.'/'.$og['img'])."'>";
  echo "<style>:root{--d:{$C['color_dark']};--m:{$C['color_main']}}
*{box-sizing:border-box}body{margin:0;font:16px/1.55 system-ui,sans-serif;background:#f3f3f1;color:var(--d)}
a{color:inherit}h1,h2,h3{font-family:Georgia,serif;line-height:1.15}
header{background:var(--d);color:var(--m);padding:14px 20px;display:flex;gap:14px;align-items:baseline;flex-wrap:wrap}
header a{text-decoration:none}header b{font:700 22px Georgia,serif}header span{color:#fff;opacity:.8;font-size:14px}
main{max-width:1100px;margin:0 auto;padding:24px 20px 60px}
.car{display:flex;gap:14px;overflow-x:auto;scroll-snap-type:x mandatory;padding:6px 2px 16px}
.yc{flex:0 0 170px;scroll-snap-align:start;background:var(--d);color:#fff;text-decoration:none;border-radius:4px;overflow:hidden;border-bottom:5px solid var(--m)}
.yc img,.yc i{display:block;width:100%;height:120px;object-fit:cover;background:#333}.yc div{padding:10px 12px}.yc b{font:700 28px Georgia,serif;color:var(--m);display:block}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px}
.it{background:#fff;text-decoration:none;border-radius:4px;overflow:hidden;box-shadow:0 1px 3px #0002}.it img,.it i{display:block;width:100%;height:150px;object-fit:cover;background:#ddd}.it p{margin:0;padding:8px 10px;font-size:14px}
.btn,button{background:var(--m);color:var(--d);border:0;padding:9px 16px;font:600 15px system-ui;border-radius:3px;cursor:pointer;text-decoration:none;display:inline-block}
.tag{font-size:13px;padding:2px 8px;border:1px solid var(--d);border-radius:10px}
form.f{display:grid;gap:12px;max-width:560px}label{display:grid;gap:4px;font-weight:600;font-size:14px}input,select,textarea{font:inherit;padding:8px;border:1px solid #999;border-radius:3px;width:100%}
table{border-collapse:collapse;width:100%;background:#fff}td,th{padding:8px;border-bottom:1px solid #ddd;text-align:left;font-size:14px}
.dec{display:flex;flex-wrap:wrap;gap:6px;align-items:center;margin:4px 0}.dec b{cursor:pointer;width:56px;font-size:13px}
.yr{display:inline-flex!important;gap:4px;font-weight:400!important;padding:2px 8px;border:1px solid #bbb;border-radius:10px;background:#fff}.yr input{width:auto}
.sw{margin:0 0 6px}.sw .tag{font-size:15px;padding:5px 16px;text-decoration:none;display:inline-block}.tag.on{background:var(--d);color:var(--m)}
.lg{display:flex;gap:2px}header .lg a{color:#fff;opacity:.55;font-size:13px;padding:0 4px;text-transform:uppercase}header .lg a.on{opacity:1;font-weight:700}
.full{max-width:100%;max-height:75vh;display:block;margin:0 auto 16px}</style></head><body>";
  echo "<header><a href=/>".($C['logo'] ? "<img src='/".e($C['logo'])."' height=36 alt=''> " : '')."<b>".e($C['club'])."</b></a><span>".t('matricule')." ".e($C['matricule'])." · ".e(ct($C['tagline'] ?? ''))."</span><a href=/proposer style='margin-left:auto;color:var(--m)'>".t('propose')."</a><a href=/archives style='color:#fff'>".t('all_archives')."</a>".langsw()."</header><main>$body</main></body></html>";
}
function cards($rows){
  $h = '<div class=grid>';
  foreach ($rows as $r) $h .= "<a class=it href=/archive/{$r['id']}>".($r['thumb'] ? "<img loading=lazy src='/".e($r['thumb'])."' alt='".e($r['title'])."'>" : '<i></i>')."<p><b>".e($r['title'])."</b><br>".e($r['date_label'] ?: $r['year'])."</p></a>";
  return $h.'</div>';
}
function credit($r){ return $r['credit'] ? t('credit_lbl').' '.e($r['credit']).' <span class=tag>'.e(stl($r['credit_status'])).'</span>' : t('author_unknown'); }

const COVER = "(SELECT thumb FROM item_files f WHERE f.item_id=items.id ORDER BY pos,id LIMIT 1)";
function saveup($tmp, $name){ global $C; $n = bin2hex(random_bytes(6));
  if (strtolower(pathinfo($name, PATHINFO_EXTENSION)) === 'pdf') { $f = "uploads/$n.pdf"; return move_uploaded_file($tmp, __DIR__.'/'.$f) ? [$f, ''] : null; }
  return (img($tmp, __DIR__."/uploads/$n.jpg", $C['max_px']) && img($tmp, __DIR__."/uploads/t_$n.jpg", 400)) ? ["uploads/$n.jpg", "uploads/t_$n.jpg"] : null; }
function rmfile($r){ if ($r['file']) @unlink(__DIR__.'/'.$r['file']); if ($r['thumb']) @unlink(__DIR__.'/'.$r['thumb']); }
function yearbox($sel){ global $C; $h = ''; $from = $C['years_from'] ?? 1905; $now = (int)date('Y');
  for ($d = intdiv($from, 10) * 10; $d <= $now; $d += 10) { $h .= "<div class=dec><b onclick=\"this.parentNode.querySelectorAll('input').forEach(i=>i.checked=!i.checked)\">{$d}s</b>";
    for ($y = max($d, $from); $y < $d + 10 && $y <= $now; $y++) $h .= "<label class=yr><input type=checkbox name=years[] value=$y".(in_array($y, $sel) ? ' checked' : '').">$y</label>"; $h .= '</div>'; }
  return $h; }

$p = explode('/', trim($_GET['r'] ?? '', '/'));
switch ($p[0]) {
case '': // Accueil : carrousel par année ou par catégorie
  $vue = ($_GET['vue'] ?? '') === 'categorie' ? 'categorie' : 'annee'; $items = [];
  if ($vue === 'annee') {
    $ys = q("SELECT iy.year, COUNT(*) n, (SELECT f.thumb FROM item_years y2 JOIN items i2 ON i2.id=y2.item_id JOIN item_files f ON f.item_id=i2.id WHERE y2.year=iy.year AND f.thumb<>'' AND i2.published=1 ORDER BY f.id LIMIT 1) cover FROM item_years iy JOIN items ON items.id=iy.item_id WHERE items.published=1 GROUP BY iy.year ORDER BY iy.year")->fetchAll();
    foreach ($ys as $y) $items[] = ["/annee/{$y['year']}", $y['cover'], $y['year'], $y['n'], 28];
  } else {
    $ks = q("SELECT category k, COUNT(*) n, (SELECT f.thumb FROM items i2 JOIN item_files f ON f.item_id=i2.id WHERE i2.category=items.category AND f.thumb<>'' AND i2.published=1 ORDER BY f.id LIMIT 1) cover FROM items WHERE published=1 GROUP BY category")->fetchAll();
    foreach (q("SELECT * FROM categories ORDER BY pos, id")->fetchAll() as $cat) foreach ($ks as $k) if ($k['k'] === $cat['name']) $items[] = ["/categorie/{$cat['id']}", $k['cover'], e($cat['name']), $k['n'], 19];
  }
  $b = "<h1>".e(ct($C['home_title'] ?? null, t('home_title_def', $C['club'])))."</h1><p>".e(ct($C['home_text'] ?? null, t('home_text_def')))."</p>"
     ."<p class=sw><a class='tag".($vue === 'annee' ? ' on' : '')."' href=/>".t('by_year')."</a> <a class='tag".($vue === 'categorie' ? ' on' : '')."' href='/?vue=categorie'>".t('by_cat')."</a></p><div class=car>";
  foreach ($items as $it) $b .= "<a class=yc href='{$it[0]}'>".($it[1] ? "<img src='/".e($it[1])."' alt=''>" : '<i></i>')."<div><b style='font-size:{$it[4]}px'>{$it[2]}</b>{$it[3]} ".t($it[3] > 1 ? 'archives_pl' : 'archive')."</div></a>";
  page(t('home'), $b.($items ? '</div>' : "</div><p>".t('none_yet')." <a href=/admin>".t('add_first')."</a></p>"));
  break;
case 'categorie': // Une catégorie, ses archives regroupées par année
  $c = (string)q("SELECT name FROM categories WHERE id=?", [(int)($p[1] ?? 0)])->fetchColumn();
  if (!$c) { http_response_code(404); page(t('not_found'), '<h1>'.t('cat_nf').'</h1><p><a href="/?vue=categorie">'.t('back_cats').'</a></p>'); break; }
  $by = []; foreach (q("SELECT items.*, ".COVER." thumb FROM items WHERE category=? AND published=1 ORDER BY year, id", [$c])->fetchAll() as $r) $by[$r['year']][] = $r;
  $b = "<p><a href='/?vue=categorie'>← ".t('all_cats_back')."</a></p><h1>".e($c)."</h1>";
  foreach ($by as $y => $rs) $b .= "<h2><a href=/annee/$y>$y</a></h2>".cards($rs);
  page($c, $by ? $b : $b.'<p>'.t('none_in_cat').'</p>');
  break;
case 'annee':
  $y = (int)($p[1] ?? 0); $b = "<h1>$y</h1><p><a href=/>← ".t('all_years_back')."</a></p>";
  foreach (cats() as $c) { $rs = q("SELECT items.*, ".COVER." thumb FROM items JOIN item_years iy ON iy.item_id=items.id WHERE iy.year=? AND category=? AND published=1 ORDER BY items.id", [$y, $c])->fetchAll(); if ($rs) $b .= "<h2>".e($c)."</h2>".cards($rs); }
  page((string)$y, $b);
  break;
case 'archives': // Toutes les archives : par année (défaut) ou par catégorie, avec filtre de catégorie
  $vue = ($_GET['vue'] ?? '') === 'categorie' ? 'categorie' : 'annee'; $c = $_GET['c'] ?? '';
  $qs = fn($v, $k = '') => '/archives?vue='.$v.($k !== '' ? '&c='.urlencode($k) : '');
  $b = "<h1>".t('all_archives')."</h1><p class=sw><a class='tag".($vue === 'annee' ? ' on' : '')."' href='".$qs('annee', $c)."'>".t('by_year')."</a> <a class='tag".($vue === 'categorie' ? ' on' : '')."' href='".$qs('categorie', $c)."'>".t('by_cat')."</a></p>"
     ."<p>".t('cat_colon')." <a class='tag".($c === '' ? ' on' : '')."' href='".$qs($vue)."'>".t('all_f')."</a> ";
  foreach (cats() as $k) $b .= "<a class='tag".($c === $k ? ' on' : '')."' href='".$qs($vue, $k)."'>".e($k)."</a> ";
  $b .= "</p>"; $w = $c !== '' ? ' AND items.category='.$db->quote($c) : ''; $by = [];
  if ($vue === 'annee') {
    foreach (q("SELECT iy.year y, items.*, ".COVER." thumb FROM items JOIN item_years iy ON iy.item_id=items.id WHERE published=1$w ORDER BY iy.year, items.id")->fetchAll() as $r) $by[$r['y']][] = $r;
    $b .= "<p>".t('goto')." ".implode(' ', array_map(fn($y) => "<a class=tag href='#a$y'>$y</a>", array_keys($by)))."</p>";
    foreach ($by as $y => $rs) $b .= "<h2 id=a$y><a href=/annee/$y>$y</a></h2>".cards($rs);
  } else {
    foreach (q("SELECT items.*, ".COVER." thumb FROM items WHERE published=1$w ORDER BY year, id")->fetchAll() as $r) $by[$r['category']][] = $r;
    foreach (q("SELECT * FROM categories ORDER BY pos, id")->fetchAll() as $cat) if (isset($by[$cat['name']])) $b .= "<h2><a href=/categorie/{$cat['id']}>".e($cat['name'])."</a></h2>".cards($by[$cat['name']]);
  }
  page(t('archives'), $by ? $b : $b.'<p>'.t('none_yet').'</p>');
  break;
case 'archive': // Fiche + lien de partage permanent
  $r = q("SELECT * FROM items WHERE id=? AND published=1", [(int)$p[1]])->fetch();
  if (!$r) { http_response_code(404); page(t('not_found'), '<h1>'.t('arch_nf').'</h1>'); break; }
  $g = ''; $cover = '';
  foreach (q("SELECT * FROM item_files WHERE item_id=? ORDER BY pos,id", [$r['id']])->fetchAll() as $f) {
    if ($f['thumb']) { $cover = $cover ?: $f['file']; $g .= "<img class=full src='/".e($f['file'])."' alt='".e($r['title'])."'>"; }
    else $g .= "<p><a class=btn href='/".e($f['file'])."'>".t('open_pdf')."</a></p>"; }
  $yl = implode(' ', array_map(fn($y) => "<a class=tag href=/annee/$y>$y</a>", array_column(q("SELECT year FROM item_years WHERE item_id=? ORDER BY year", [$r['id']])->fetchAll(), 'year')));
  $b = "<p><a href=/annee/{$r['year']}>← {$r['year']}</a></p><h1>".e($r['title'])."</h1>"
     .$g."<p>".t('years_colon')." $yl</p>"
     ."<p><b>".e($r['category'])."</b> · ".e($r['date_label'] ?: $r['year'])."</p><p>".nl2br(e($r['description']))."</p><p>".credit($r)."</p>"
     ."<button onclick=\"var u=location.href;navigator.share?navigator.share({title:document.title,url:u}):navigator.clipboard.writeText(u).then(()=>this.textContent='".t('link_copied')."')\">".t('share')."</button>"
     ."<p><small>".e(t('concern', $C['contact']))."</small></p>";
  page($r['title'], $b, ['desc' => $r['category'].' · '.($r['date_label'] ?: $r['year']), 'img' => $cover]);
  break;
case 'proposer': // formulaire public : la proposition attend la validation d'un admin
  $err = ''; $ok = false;
  if ($_SERVER['REQUEST_METHOD'] === 'POST') { chk();
    $ip = $_SERVER['REMOTE_ADDR'] ?? ''; q("DELETE FROM rate WHERE ts<?", [time() - 3600]);
    $used = 0; foreach (glob(__DIR__.'/uploads/*') ?: [] as $x) $used += filesize($x);
    $ti = trim($_POST['title'] ?? ''); $yr = (int)($_POST['year'] ?? 0);
    if (!empty($_POST['site'])) $ok = true; // champ piège anti-robot
    elseif (q("SELECT COUNT(*) FROM rate WHERE ip=?", [$ip])->fetchColumn() >= 5) $err = t('err_rate');
    elseif ($used > ($C['quota_mb'] ?? 80) * 1048576) $err = t('err_quota_pub', $C['contact']);
    elseif (!$ti || $yr < 1850 || empty($_POST['droits'])) $err = t('err_fields');
    else {
      $new = []; foreach (array_slice($_FILES['file']['name'] ?? [], 0, 10, true) as $i => $nm) if ($_FILES['file']['error'][$i] === 0 && $_FILES['file']['size'][$i] < 15 * 1048576 && (($C['public_pdf'] ?? false) || strtolower(pathinfo($nm, PATHINFO_EXTENSION)) !== 'pdf') && ($x = saveup($_FILES['file']['tmp_name'][$i], $nm))) $new[] = $x;
      if (!$new) $err = t('err_nofile_pub');
      else {
        q("INSERT INTO items(year,date_label,category,title,description,credit,credit_status,published,file,thumb,submitter,submitter_contact) VALUES(?,?,?,?,?,?,'à vérifier',2,'','',?,?)", [$yr, $_POST['date_label'] ?? '', in_array('Divers', cats()) ? 'Divers' : (cats()[0] ?? 'Divers'), $ti, $_POST['description'] ?? '', $_POST['credit'] ?? '', $_POST['name'] ?? '', $_POST['contact'] ?? '']);
        $id = (int)$db->lastInsertId(); foreach ($new as $x) q("INSERT INTO item_files(item_id,file,thumb) VALUES(?,?,?)", [$id, $x[0], $x[1]]);
        q("INSERT INTO item_years(item_id,year) VALUES(?,?)", [$id, $yr]); q("INSERT INTO rate VALUES(?,?)", [$ip, time()]); $ok = true; } }
  }
  $pv = fn($k) => e($_POST[$k] ?? '');
  page(t('propose'), $ok ? "<h1>".t('thanks_h')."</h1><p>".t('thanks_p')."</p><p><a href=/>".t('back_home')."</a></p>"
    : "<h1>".t('propose')."</h1><p>".t('propose_p')."</p>".($err ? "<p><b>".e($err)."</b></p>" : '')
    ."<form class=f method=post enctype=multipart/form-data><input type=hidden name=t value=".csrf()."><div style='display:none'><input name=site tabindex=-1 autocomplete=off></div>"
    ."<label>".(($C['public_pdf'] ?? false) ? t('lbl_photos_pdf') : t('lbl_photos'))."<input type=file name=file[] multiple required></label><label>".t('lbl_title')."<input name=title required value='".$pv('title')."'></label>"
    ."<label>".t('lbl_year_approx')."<input type=number name=year required min=1850 max=2100 value='".$pv('year')."'></label><label>".t('lbl_date_pub')."<input name=date_label value='".$pv('date_label')."'></label>"
    ."<label>".t('lbl_know')."<textarea name=description rows=4>".$pv('description')."</textarea></label><label>".t('lbl_author_src')."<input name=credit value='".$pv('credit')."'></label>"
    ."<label>".t('lbl_name')."<input name=name value='".$pv('name')."'></label><label>".t('lbl_email')."<input type=email name=contact value='".$pv('contact')."'></label>"
    ."<label><span><input type=checkbox name=droits value=1 style='width:auto'> ".t('lbl_rights')."</span></label><button>".t('btn_send')."</button></form>");
  break;
case 'admin':
  $a = $p[1] ?? '';
  if ($a === 'logout') { session_destroy(); go('/'); }
  $nu = (int)q("SELECT COUNT(*) FROM users")->fetchColumn();
  if (!isadmin()) { // connexion, ou création du premier compte
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { chk();
      $u = trim($_POST['u']); $pw = $_POST['pw'];
      if ($nu === 0 && strlen($pw) >= 10 && $u) { q("INSERT INTO users(username,hash) VALUES(?,?)", [$u, password_hash($pw, PASSWORD_DEFAULT)]); $_SESSION['u'] = $u; go('/admin'); }
      $ip = $_SERVER['REMOTE_ADDR'] ?? ''; q("DELETE FROM loginfail WHERE ts<?", [time() - 900]);
      if (q("SELECT COUNT(*) FROM loginfail WHERE ip=?", [$ip])->fetchColumn() >= 5) $err = t('err_attempts');
      else {
        $h = q("SELECT hash FROM users WHERE username=?", [$u])->fetchColumn();
        if ($h && password_verify($pw, $h)) { q("DELETE FROM loginfail WHERE ip=?", [$ip]); session_regenerate_id(true); $_SESSION['u'] = $u; go('/admin'); }
        q("INSERT INTO loginfail VALUES(?,?)", [$ip, time()]); $err = t('err_login'); }
    }
    page(t('admin'), "<h1>".t($nu ? 'login' : 'create_admin')."</h1>".($err ?? '').($nu ? '' : '<p>'.t('pw_hint').'</p>')."<form class=f method=post><input type=hidden name=t value=".csrf()."><label>".t('lbl_user')."<input name=u required></label><label>".t('lbl_pass')."<input type=password name=pw required></label><button>".t($nu ? 'btn_login' : 'btn_create')."</button></form>");
    break;
  }
  if ($a === 'categories') { // Gestion des catégories : ajouter, renommer (propagé aux archives), réordonner, supprimer
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { chk(); $do = $_POST['do'] ?? ''; $id = (int)($_POST['id'] ?? 0); $n = trim($_POST['name'] ?? '');
      $cur = q("SELECT * FROM categories WHERE id=?", [$id])->fetch();
      if ($do === 'add' && $n) { try { q("INSERT INTO categories(name,pos) VALUES(?,(SELECT COALESCE(MAX(pos),0)+1 FROM categories))", [$n]); } catch (Exception $x) { $_SESSION['flash'] = t('err_cat_exists'); } }
      if ($do === 'rename' && $cur && $n && $n !== $cur['name']) { try { q("UPDATE categories SET name=? WHERE id=?", [$n, $id]); q("UPDATE items SET category=? WHERE category=?", [$n, $cur['name']]); } catch (Exception $x) { $_SESSION['flash'] = t('err_name_used'); } }
      if (($do === 'up' || $do === 'down') && $cur) {
        $nb = q($do === 'up' ? "SELECT * FROM categories WHERE pos<? OR (pos=? AND id<?) ORDER BY pos DESC, id DESC LIMIT 1" : "SELECT * FROM categories WHERE pos>? OR (pos=? AND id>?) ORDER BY pos, id LIMIT 1", [$cur['pos'], $cur['pos'], $id])->fetch();
        if ($nb) { q("UPDATE categories SET pos=? WHERE id=?", [$nb['pos'], $id]); q("UPDATE categories SET pos=? WHERE id=?", [$cur['pos'], $nb['id']]); } }
      if ($do === 'del' && $cur) { if (q("SELECT COUNT(*) FROM items WHERE category=?", [$cur['name']])->fetchColumn() == 0) q("DELETE FROM categories WHERE id=?", [$id]); else $_SESSION['flash'] = t('err_cat_inuse'); }
      go('/admin/categories');
    }
    $err = $_SESSION['flash'] ?? ''; unset($_SESSION['flash']); $tk = "<input type=hidden name=t value=".csrf().">";
    $b = "<p><a href=/admin>← ".t('back')."</a></p><h1>".t('categories')."</h1><p>".t('cat_help')."</p>".($err ? "<p><b>".e($err)."</b></p>" : '')."<table>";
    foreach (q("SELECT c.*, (SELECT COUNT(*) FROM items i WHERE i.category=c.name) n FROM categories c ORDER BY pos, id")->fetchAll() as $c) {
      $b .= "<tr><td><form method=post style='display:flex;gap:6px'>$tk<input type=hidden name=id value={$c['id']}><input name=name value='".e($c['name'])."'><button name=do value=rename>".t('btn_rename')."</button></form><td>".t('n_archives', $c['n'])
          ."<td><form method=post style=display:inline>$tk<input type=hidden name=id value={$c['id']}><button name=do value=up>↑</button> <button name=do value=down>↓</button> ".($c['n'] ? '' : "<button name=do value=del>".t('btn_delete')."</button>")."</form>"; }
    page(t('categories'), $b."</table><h2>".t('add_cat')."</h2><form class=f method=post>$tk<input type=hidden name=do value=add><label>".t('lbl_name_f')."<input name=name required></label><button>".t('btn_add')."</button></form>");
    break; }
  if ($a === 'import') { // Import en lot : envoi fichier par fichier, brouillons masqués à compléter puis publier
    if (($p[2] ?? '') === 'upload') { chk(); header('Content-Type: application/json');
      $used = 0; foreach (glob(__DIR__.'/uploads/*') ?: [] as $x) $used += filesize($x);
      if ($used > ($C['quota_mb'] ?? 80) * 1048576) exit(json_encode(['ok' => false, 'error' => t('err_quota_short')]));
      $u = $_FILES['file'] ?? null; $x = ($u && $u['error'] === 0) ? saveup($u['tmp_name'], $u['name']) : null;
      if (!$x) exit(json_encode(['ok' => false, 'error' => t('err_format')]));
      $into = (int)($_POST['into'] ?? 0);
      if ($into && q("SELECT 1 FROM items WHERE id=? AND batch='1' AND published=0", [$into])->fetch()) { q("INSERT INTO item_files(item_id,file,thumb) VALUES(?,?,?)", [$into, $x[0], $x[1]]); exit(json_encode(['ok' => true, 'id' => $into])); }
      $ti = ucfirst(trim(preg_replace('/[_\-]+/', ' ', pathinfo($u['name'], PATHINFO_FILENAME)))); $yr = (int)$_POST['year'] ?: (int)date('Y');
      q("INSERT INTO items(year,date_label,category,title,description,credit,credit_status,published,file,thumb,created_by,batch) VALUES(?,'',?,?,'',?,?,0,'','',?,'1')", [$yr, $_POST['category'], $ti, $_POST['credit'], $_POST['credit_status'], $_SESSION['u']]);
      $id = (int)$db->lastInsertId(); q("INSERT INTO item_files(item_id,file,thumb) VALUES(?,?,?)", [$id, $x[0], $x[1]]); q("INSERT INTO item_years(item_id,year) VALUES(?,?)", [$id, $yr]);
      exit(json_encode(['ok' => true, 'id' => $id]));
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { chk(); $do = $_POST['do'] ?? '';
      $drafts = array_column(q("SELECT id FROM items WHERE batch='1' AND published=0")->fetchAll(), 'id');
      foreach ($_POST['r'] ?? [] as $id => $f) if (in_array((int)$id, $drafts)) { $id = (int)$id; $yr = (int)$f['year'];
        q("UPDATE items SET title=?,year=?,date_label=?,category=?,credit=?,updated_by=? WHERE id=?", [$f['title'], $yr, $f['date_label'], $f['category'], $f['credit'], $_SESSION['u'], $id]);
        q("DELETE FROM item_years WHERE item_id=?", [$id]); q("INSERT INTO item_years(item_id,year) VALUES(?,?)", [$id, $yr]); }
      foreach (array_intersect(array_map('intval', $_POST['sel'] ?? []), $drafts) as $id) {
        if ($do === 'publish') q("UPDATE items SET published=1, batch='' WHERE id=?", [$id]);
        if ($do === 'delete') { foreach (q("SELECT * FROM item_files WHERE item_id=?", [$id])->fetchAll() as $f) rmfile($f); foreach (['item_files', 'item_years'] as $t) q("DELETE FROM $t WHERE item_id=?", [$id]); q("DELETE FROM items WHERE id=?", [$id]); } }
      if ($do === 'merge') { $ids = array_values(array_intersect(array_map('intval', $_POST['sel'] ?? []), $drafts)); sort($ids); // fusion : tout dans la plus ancienne archive cochée
        if (count($ids) > 1) { $t = array_shift($ids); foreach ($ids as $o) {
          q("UPDATE item_files SET item_id=? WHERE item_id=?", [$t, $o]); q("INSERT OR IGNORE INTO item_years(item_id,year) SELECT ?,year FROM item_years WHERE item_id=?", [$t, $o]);
          q("DELETE FROM item_years WHERE item_id=?", [$o]); q("DELETE FROM items WHERE id=?", [$o]); } } }
      go('/admin/import');
    }
    $rows = q("SELECT items.*, ".COVER." thumb FROM items WHERE batch='1' AND published=0 ORDER BY id")->fetchAll(); $tk = csrf();
    $opts = fn($sel) => implode('', array_map(fn($x) => "<option".($x === $sel ? ' selected' : '').">".e($x)."</option>", cats()));
    $b = "<p><a href=/admin>← ".t('back')."</a></p><h1>".t('import')."</h1><form class=f onsubmit='return false'><label>".t('imp_files')."<input type=file id=files multiple></label>"
       ."<p>".t('imp_defaults')."</p><label>".t('lbl_year')."<input type=number id=dy value=".date('Y')." min=1850 max=2100></label><label>".t('lbl_cat')."<select id=dc>".$opts('Divers')."</select></label>"
       ."<label>".t('lbl_credit')."<input id=dcr></label><label>".t('lbl_credit_status')."<select id=ds>".stopts('')."</select></label><label><span><input type=checkbox id=one style='width:auto'> ".t('imp_group')."</span></label><button id=go type=button>".t('imp_send')."</button><p id=st></p></form>";
    $b .= str_replace(['__T__', '__L__'], [$tk, json_encode([t('js_send'), t('js_neterr'), t('js_done'), t('js_fail')], JSON_UNESCAPED_UNICODE)], <<<'JS'
<script>
const LL=__L__;
document.getElementById('go').onclick=async()=>{
 const fs=[...document.getElementById('files').files],st=document.getElementById('st');let ok=0,ko=[],into=0;
 for(let i=0;i<fs.length;i++){st.textContent=LL[0]+(i+1)+' / '+fs.length+' : '+fs[i].name;
  const d=new FormData();d.append('t','__T__');d.append('file',fs[i]);d.append('year',dy.value);d.append('category',dc.value);d.append('credit',dcr.value);d.append('credit_status',ds.value);if(one.checked&&into)d.append('into',into);
  try{const r=await(await fetch('/admin/import/upload',{method:'POST',body:d})).json();if(r.ok){ok++;if(one.checked&&!into)into=r.id}else ko.push(fs[i].name+' ('+r.error+')')}catch(e){ko.push(fs[i].name+' ('+LL[1]+')')}}
 st.textContent=ok+LL[2]+(ko.length?LL[3]+ko.join(', '):'');
 if(ok)setTimeout(()=>location.reload(),ko.length?5000:600)};
function selAll(c){document.querySelectorAll('input[name="sel[]"]').forEach(i=>i.checked=c.checked)}
function apply(){const y=by.value,c=bc.value;document.querySelectorAll('input[name="sel[]"]:checked').forEach(i=>{const r=i.closest('tr');if(y)r.querySelector('[name$="[year]"]').value=y;if(c)r.querySelector('select').value=c})}
</script>
JS);
    if ($rows) {
      $b .= "<h2>".t('imp_todo', count($rows))."</h2><form method=post><input type=hidden name=t value=$tk><p>".t('imp_for_sel')." <input type=number id=by style='width:90px' min=1850 max=2100> ".t('cat_lower')." <select id=bc><option value=''>-</option>".$opts('')."</select> <button type=button onclick=apply()>".t('imp_apply')."</button></p>"
         ."<table><tr><th><input type=checkbox onclick=selAll(this)><th><th>".t('lbl_title')."<th>".t('lbl_year')."<th>".t('lbl_date_shown')."<th>".t('lbl_cat')."<th>".t('lbl_credit');
      foreach ($rows as $r) { $i = $r['id']; $b .= "<tr><td><input type=checkbox name=sel[] value=$i><td>".implode(' ', array_map(fn($f) => $f['thumb'] ? "<img src='/".e($f['thumb'])."' height=48 alt=''>" : 'PDF', q("SELECT thumb FROM item_files WHERE item_id=? ORDER BY pos,id LIMIT 6", [$i])->fetchAll()))."<td><input name=r[$i][title] value='".e($r['title'])."'><td><input type=number style='width:90px' name=r[$i][year] value={$r['year']}><td><input name=r[$i][date_label] value='".e($r['date_label'])."'><td><select name=r[$i][category]>".$opts($r['category'])."</select><td><input name=r[$i][credit] value='".e($r['credit'])."'>"; }
      $b .= "</table><p><button name=do value=save>".t('imp_save')."</button> <button name=do value=merge>".t('imp_merge')."</button> <button name=do value=publish>".t('imp_publish')."</button> <button name=do value=delete onclick=\"return confirm('".t('confirm_delsel')."')\">".t('imp_delsel')."</button></p></form>";
    }
    page(t('import'), $b); break; }
  if ($a === 'approve' && $_SERVER['REQUEST_METHOD'] === 'POST') { chk(); q("UPDATE items SET published=1, updated_by=? WHERE id=?", [$_SESSION['u'], (int)$p[2]]); go('/admin'); }
  if ($a === 'backup') { $z = new ZipArchive; $tmp = tempnam(sys_get_temp_dir(), 'bk'); $z->open($tmp, ZipArchive::OVERWRITE);
    foreach (['data', 'uploads'] as $d) foreach (glob(__DIR__."/$d/*") ?: [] as $x) if (is_file($x)) $z->addFile($x, "$d/".basename($x));
    $z->close(); header('Content-Type: application/zip'); header('Content-Disposition: attachment; filename=backup-'.date('Y-m-d').'.zip'); readfile($tmp); unlink($tmp); exit; }
  if ($a === 'users') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { chk(); $do = $_POST['do'] ?? '';
      if ($do === 'add' && trim($_POST['u']) && strlen($_POST['pw']) >= 10) { try { q("INSERT INTO users(username,hash) VALUES(?,?)", [trim($_POST['u']), password_hash($_POST['pw'], PASSWORD_DEFAULT)]); } catch (Exception $x) { $err = t('err_user_exists'); } }
      if ($do === 'del' && $_POST['u'] !== $_SESSION['u']) q("DELETE FROM users WHERE username=?", [$_POST['u']]);
      if ($do === 'pw' && strlen($_POST['pw']) >= 10) q("UPDATE users SET hash=? WHERE username=?", [password_hash($_POST['pw'], PASSWORD_DEFAULT), $_SESSION['u']]);
      if (empty($err)) go('/admin/users');
    }
    $tk = "<input type=hidden name=t value=".csrf().">"; $b = "<p><a href=/admin>← ".t('back')."</a></p><h1>".t('admins')."</h1>".($err ?? '')."<table>";
    foreach (q("SELECT username FROM users ORDER BY username")->fetchAll() as $x) $b .= "<tr><td>".e($x['username'])."<td>".($x['username'] === $_SESSION['u'] ? t('you') : "<form method=post style=display:inline onsubmit=\"return confirm('".t('confirm_deluser')."')\">$tk<input type=hidden name=do value=del><input type=hidden name=u value='".e($x['username'])."'><button>".t('btn_delete')."</button></form>");
    page(t('admins'), $b."</table><h2>".t('add_admin')."</h2><form class=f method=post>$tk<input type=hidden name=do value=add><label>".t('lbl_user')."<input name=u required></label><label>".t('lbl_pw_min')."<input type=password name=pw minlength=10 required></label><button>".t('btn_add')."</button></form><h2>".t('change_pw')."</h2><form class=f method=post>$tk<input type=hidden name=do value=pw><label>".t('lbl_newpw')."<input type=password name=pw minlength=10 required></label><button>".t('btn_modify')."</button></form>");
    break; }
  if ($a === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') { chk();
    $r = q("SELECT * FROM items WHERE id=?", [(int)$p[2]])->fetch();
    if ($r) { foreach (q("SELECT * FROM item_files WHERE item_id=?", [$r['id']])->fetchAll() as $f) rmfile($f); foreach (['item_files', 'item_years'] as $t) q("DELETE FROM $t WHERE item_id=?", [$r['id']]); q("DELETE FROM items WHERE id=?", [$r['id']]); }
    go('/admin');
  }
  if ($a === 'new' || $a === 'edit') {
    $id = (int)($p[2] ?? 0); $r = $id ? q("SELECT * FROM items WHERE id=?", [$id])->fetch() : [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') { chk();
      $yr = (int)$_POST['year']; $ys = array_unique(array_map('intval', [...($_POST['years'] ?? []), $yr]));
      $f = [$yr, $_POST['date_label'], $_POST['category'], $_POST['title'], $_POST['description'], $_POST['credit'], $_POST['credit_status'], isset($_POST['published']) ? 1 : 0];
      $new = []; $err = '';
      foreach (($_FILES['file']['name'] ?? []) as $i => $nm) if ($_FILES['file']['error'][$i] === 0) { $x = saveup($_FILES['file']['tmp_name'][$i], $nm); if ($x) $new[] = $x; else $err = t('err_file_ignored'); }
      if (!$id && !$new) $err = t('err_need_file');
      else {
        if ($id) q("UPDATE items SET year=?,date_label=?,category=?,title=?,description=?,credit=?,credit_status=?,published=?,updated_by=? WHERE id=?", [...$f, $_SESSION['u'], $id]);
        else { q("INSERT INTO items(year,date_label,category,title,description,credit,credit_status,published,file,thumb,created_by) VALUES(?,?,?,?,?,?,?,?,'','',?)", [...$f, $_SESSION['u']]); $id = (int)$db->lastInsertId(); }
        foreach ($_POST['del'] ?? [] as $d) { $x = q("SELECT * FROM item_files WHERE id=? AND item_id=?", [(int)$d, $id])->fetch(); if ($x) { rmfile($x); q("DELETE FROM item_files WHERE id=?", [$x['id']]); } }
        foreach ($new as $x) q("INSERT INTO item_files(item_id,file,thumb) VALUES(?,?,?)", [$id, $x[0], $x[1]]);
        q("DELETE FROM item_years WHERE item_id=?", [$id]); foreach ($ys as $y) q("INSERT INTO item_years(item_id,year) VALUES(?,?)", [$id, $y]);
        if ($err) { $_SESSION['flash'] = $err; go('/admin/edit/'.$id); }
        go('/admin');
      }
    }
    $err = ($err ?? '') ?: ($_SESSION['flash'] ?? ''); unset($_SESSION['flash']);
    $fs = $id ? q("SELECT * FROM item_files WHERE item_id=? ORDER BY pos,id", [$id])->fetchAll() : [];
    $sel = $id ? array_column(q("SELECT year FROM item_years WHERE item_id=?", [$id])->fetchAll(), 'year') : [];
    $v = fn($k, $d = '') => e($r[$k] ?? $d);
    $o = fn($list, $k) => implode('', array_map(fn($x) => "<option".(($r[$k] ?? '') === $x ? ' selected' : '').">".e($x)."</option>", $list));
    $fl = ''; foreach ($fs as $x) $fl .= "<label class=yr><input type=checkbox name=del[] value={$x['id']}> ".t('btn_delete')." ".($x['thumb'] ? "<img src='/".e($x['thumb'])."' height=40 alt=''>" : 'PDF')."</label> ";
    page(t('admin'), "<p><a href=/admin>← ".t('back')."</a></p><h1>".t($id ? 'edit_archive' : 'add_archive')."</h1>".(!empty($r['submitter']) ? "<p>".t('proposed_by')." <b>".e($r['submitter'])."</b> (".e($r['submitter_contact']).")</p>" : '').($err ? "<p><b>".e($err)."</b></p>" : '')."<form class=f method=post enctype=multipart/form-data><input type=hidden name=t value=".csrf().">"
      .($fl ? "<div>".t('current_files')." $fl</div>" : '')."<label>".t('lbl_addfiles')."<input type=file name=file[] multiple></label><label>".t('lbl_title')."<input name=title required value='".$v('title')."'></label>"
      ."<label>".t('lbl_refyear')."<input type=number name=year required min=1850 max=2100 value='".$v('year')."'></label>"
      ."<div><b>".t('years_concerned')."</b> ".t('years_help').yearbox($sel)."</div>"
      ."<label>".t('lbl_date_hint')."<input name=date_label value='".$v('date_label')."'></label>"
      ."<label>".t('lbl_cat')."<select name=category>".$o(cats(), 'category')."</select></label><label>".t('lbl_description')."<textarea name=description rows=4>".$v('description')."</textarea></label>"
      ."<label>".t('lbl_author_credit')."<input name=credit value='".$v('credit')."'></label><label>".t('lbl_credit_status')."<select name=credit_status>".stopts($r['credit_status'] ?? '')."</select></label>"
      ."<label><span><input type=checkbox name=published style='width:auto' ".(($r['published'] ?? 1) ? 'checked' : '')."> ".t('published')."</span></label><button>".t('btn_save')."</button></form>");
    break;
  }
  $rs = q("SELECT * FROM items ORDER BY (published=2) DESC, year DESC, id DESC")->fetchAll(); $used = 0; foreach (glob(__DIR__.'/uploads/*') ?: [] as $x) $used += filesize($x);
  $tk = "<input type=hidden name=t value=".csrf().">";
  $b = "<h1>".t('admin')."</h1><p><a class=btn href=/admin/new>".t('add_archive')."</a> <a class=btn href=/admin/import>".t('import')."</a> <a href=/admin/categories>".t('categories')."</a> <a href=/admin/users>".t('admins')."</a> · <a href=/admin/backup>".t('backup')."</a> · <a href=/admin/logout>".t('logout')."</a></p><p>".t('space_used', round($used / 1048576, 1), $C['quota_mb'] ?? 80)."</p><table><tr><th>".t('lbl_year')."<th>".t('lbl_title')."<th>".t('lbl_cat')."<th>".t('lbl_credit')."<th>".t('added_by')."<th>";
  foreach ($rs as $r) { $pend = $r['published'] == 2;
    $b .= "<tr".($pend ? ' style="background:#fff6cc"' : '')."><td>{$r['year']}<td>".e($r['title']).($pend ? ' <span class=tag>'.t('to_validate').'</span>' : ($r['published'] ? '' : ' <span class=tag>'.t('hidden').'</span>'))."<td>".e($r['category'])."<td>".e($r['credit'])." <span class=tag>".e(stl($r['credit_status']))."</span><td>".e($r['submitter'] ? $r['submitter'].' '.t('proposal') : $r['created_by'])."<td>"
      .($pend ? "<form method=post action=/admin/approve/{$r['id']} style=display:inline>$tk<button>".t('approve')."</button></form> " : '')
      ."<a href=/admin/edit/{$r['id']}>".t('btn_modify')."</a> <form method=post action=/admin/delete/{$r['id']} style=display:inline onsubmit=\"return confirm('".t('confirm_del')."')\">$tk<button style='background:none;padding:0;text-decoration:underline'>".t('btn_delete')."</button></form>"; }
  page(t('admin'), $b.'</table>');
  break;
default:
  http_response_code(404); page(t('not_found'), '<h1>'.t('page_nf').'</h1><p><a href=/>'.t('back_home').'</a></p>');
}
