Test technique O'clock - Alexandre Mouillard
============================================

![Screenshot application](public/img/screenshot.png?raw=true)

Application hébergée pour test
------------------------------

[https://test-oclock.mouillard.fr](https://test-oclock.mouillard.fr)

Objectif pédagogique
--------------------

Cet exercice avait pour vocation de pouvoir être utilisé comme un support pour des étudiants
en cours de formation. Le code est commenté de manière à pouvoir être lu en partant d'index.php,
tout en supposant quand même une explication directe par le formateur.

J'ai choisi de me placer dans la situation fictive d'étudiants en cours de **saison 4** du 
[socle développement web](https://oclock.io/formations/socle-developpement-web), cet exercice me paraissant adapté aux connaissances acquises sur le HTML, CSS, PHP, JS et SQL.

Organisation du code
--------------------
index.php contient un petit routeur qui permet de rediriger les requêtes sur deux routes :

+ **GET /** - l'index qui récupère les scores via le ScoreModel et les passe à la vue principale (views/main.php)
+ **POST /scores** - permettant de stocker un nouveau high score et de relancer le jeu

La classe Database est une petite surcouche sur l'accès PDO et la création du fichier SQLite.

Une classe abstraite Model permet d'aborder à la fois la notion d'héritage et d'interface pour créer
le modèle ScoreModel qui gère sa table et ses données.

L'intéraction client est gérée dans public/js/script.js, avec des options de configuration suivies du code
gérant l'affichage des cartes, les évènements et les conditions de victoire / défaite.

Explication des choix techniques
--------------------------------

+ Front-end : jQuery
+ Back-end : PHP + SQLite

J'ai volontairement évité les frameworks, outils de build et l'ES6 / CSS "moderne" (Grid / Flexbox / Responsive avec rem)
pour ne pas surcharger mes pauvres étudiants fictifs de saison 4 étant à leur 6ème semaine de développement, considérant
que la configuration de Webpack et la compréhension de React+Redux ne sont pas les priorités à ce moment :)

J'ai seulement choisi jQuery pour simplifier la gestion des évènements et modification du DOM la syntaxe vanilla JS étant plus 
verbeuse. L'objectif ici était de se concentrer sur une introduction à la POO avec un nano-framework 
(il n'y a qu'un routeur et un accès DB via modèles !) qui permettrait de parler un peu de pattern MVC et
persistance des données. 

PHP + SQLite me semblait être la meilleure combinaison pour une installation facile.

Le code est majoritairement orienté pour un navigateur Chrome, mais fonctionne aussi sous Firefox, Safari et Edge avec
quelques effets visuels manquants.

Installation
-----

D'abord, récupérer le code en clonant le repository.

```sh
git clone https://github.com/amouillard/oclock-test-memory.git
```

Deux solutions possibles :

+ Docker

```sh
docker build . --tag oclock-test
docker run --rm --mount type=bind,source="$(pwd)",target=/home/oclock -p 3000:3000 oclock-test
```

+ Serveur PHP

Le projet peut être lancé avec une installation PHP 7.4+ avec la commande
```sh
php -S localhost:3000
```
_(paquets requis : php-sqlite3, php-pdo)._

Un fichier style.css précompilé est inclus, mais en cas de modification il faudra utiliser node-sass
pour compiler le fichier .scss avec la commande suivante.

```sh
node-sass -w style.scss public/css/style.css
```

Test
----
J'ai ajouté un petit bouton "cheat code" en bas à droite qui affiche les noms des cartes pour simplifier le test :)

Attributions
------------
Images des langages de programmation :

https://github.com/abranhe/programming-languages-logos - MIT License © Carlos Abraham

Exercice Oclock
---------------

BruH.