<?php
// Configuration du club : c'est le seul fichier à adapter pour un autre club.
return [
  'club'       => 'Union Royale Namur',
  'matricule'  => '156',
  'lang'       => 'fr',                   // langue par defaut : 'fr', 'en' ou 'nl' / default language
  'langs'      => ['fr', 'en', 'nl'],     // langues proposees aux visiteurs / languages offered
  // Les textes ci-dessous peuvent etre une simple phrase ou un tableau par langue.
  // These texts can be a plain string or an array per language.
  'tagline'    => ['fr' => 'Les Merles · depuis 1905', 'en' => 'Les Merles · since 1905', 'nl' => 'Les Merles · sinds 1905'],
  'color_dark' => '#1b1b1b',
  'color_main' => '#f2c400',
  'logo'       => '',          // ex. 'uploads/logo.png' (optionnel)
  'contact'    => 'contact@unionroyalenamur.be',
  'years_from' => 1905,      // première année proposée dans le formulaire
  'quota_mb' => 80,           // espace max pour les fichiers (hébergement gratuit : 100 Mo)
  'home_title' => ['fr' => "Mémoire de l'Union Royale", 'en' => 'Memory of Union Royale', 'nl' => 'Geheugen van Union Royale'],
  'home_text'  => [
    'fr' => "Feuilles de match, photos d'équipes, logos et coupures de presse, à parcourir par année ou par catégorie.",
    'en' => 'Match sheets, team photos, logos and press cuttings, to browse by year or by category.',
    'nl' => 'Wedstrijdbladen, ploegfoto\'s, logo\'s en krantenknipsels, te bekijken per jaar of per categorie.',
  ],
  'public_pdf' => false,       // true : autorise les PDF dans le formulaire public (déconseillé)
  'max_px'     => 1600,        // taille max des images publiées
  'categories' => ['Feuilles de match','Photos d\'équipe','Presse','Logos & écussons','Affiches','Équipement','Documents','Divers'],
];
