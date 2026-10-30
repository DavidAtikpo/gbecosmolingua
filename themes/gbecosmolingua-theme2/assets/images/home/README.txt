Images statiques page d'accueil (thème GbeCosmoLingua)
========================================================

Ces fichiers sont servis directement par le thème via `includes/home-assets.php`.
Ils ne passent pas par la médiathèque WordPress — pratique pour le partage Git.

Fichiers principaux
-------------------
- hero-slide-01.jpg … hero-slide-07.jpg — slider bannière hero
- hero-patrimoine.jpg   — repli / fond vision-mission (copie slide 01)
- map-preview.jpg       — aperçu carte interactive

Langues (cartes)
----------------
- lang-ewe.jpg, lang-fon.jpg, lang-gen.jpg, lang-aja.jpg, lang-gun.jpg, lang-phera.jpg

Bibliothèque numérique
----------------------
- biblio-books.jpg, biblio-audio.jpg, biblio-video.jpg, biblio-photos.jpg, biblio-maps.jpg

Galerie
-------
- gallery-01.jpg … gallery-12.jpg

Recherche & innovation
----------------------
- research-map.jpg, research-book.jpg, research-code.jpg, research-manuscript.jpg, research-server.jpg, research-audio.jpg

Actualités & témoignages
------------------------
- news-01.jpg … news-03.jpg
- avatar-01.jpg … avatar-04.jpg

Régénération
------------
Placeholders thématiques (PIL) :

    python3 scripts/generate-home-images.py

Photos patrimoine culturel gbe (6 sources) :

    python3 scripts/deploy-home-user-images.py

Slider hero (7 diapositives) :

    python3 scripts/deploy-home-hero-slides.py

Sources : architecture traditionnelle, couloir à bas-reliefs, danses togolaises,
échassiers, danse raffia, village rural.
