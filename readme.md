Test technique O'clock - Alexandre Mouillard
============================================

<p align="center">
Text
</p>
[https://test-oclock.mouillard.fr](https://test-oclock.mouillard.fr)

![Screenshot application](public/img/screenshot.png?raw=true)

Usage
-----
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

+ (Optionnel) Docker 

```sh
docker build . --tag oclock-test
docker run --rm --mount type=bind,source="$(pwd)",target=/home/oclock -p 3000:3000 oclock-test
```

Le code est majoritairement orienté pour un navigateur Chrome, mais fonctionne aussi sous Firefox, Safari et Edge avec 
quelques effets visuels manquants.

Explication des choix techniques
--------------------------------
Cet exercice avait pour vocation de pouvoir être utilisé comme un support pédagogique pour des étudiants
en cours de formation.

J'ai choisi de me placer dans la situation fictive d'étudiants en cours de **saison 4** du socle
développement web, cet exercice me paraissant adapté aux connaissances acquises sur le HTML, CSS, PHP, JS et SQL.

J'ai volontairement évité les frameworks, outils de build et l'ES6 / CSS "moderne" (Grid / Flexbox / Responsive avec rem), 
n'utilisant que jQuery pour simplifier la gestion des évènements et modification du DOM la syntaxe vanilla JS étant plus 
verbeuse. L'objectif ici était de se concentrer sur une introduction à la POO avec un nano-framework 
(il n'y a qu'un routeur et un accès DB via modèles !) qui permettrait de parler un peu de pattern MVC et
persistance des données. PHP + SQLite me semblait être la meilleure combinaison pour une installation facile.

Organisation du code
--------------------
index.php contient un petit routeur qui permet de rediriger les requêtes sur deux routes :

+ GET / - l'index qui récupère les scores via le ScoreModel et les passe à la vue principale (views/main.php)
+ POST /scores - permettant de stocker un nouveau high score et de relancer le jeu

La classe Database est une petite surcouche sur l'accès PDO et la création du fichier SQLite.

Une classe abstraite Model permet d'aborder à la fois la notion d'héritage et d'interface pour créer 
le modèle ScoreModel qui gère sa table et ses données.

L'intéraction client est gérée dans public/js/script.js, avec des options de configuration suivie du code
gérant l'affichage des cartes, les évènements et les conditions de victoire / défaite.

Test
----
J'ai ajouté un petit bouton "cheat code" en bas à droite qui affiche les noms des cartes pour simplifier le test :)

Attributions
------------
Images des langages de programmation :

https://github.com/abranhe/programming-languages-logos - MIT License © Carlos Abraham
