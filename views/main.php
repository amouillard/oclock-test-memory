<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible"
              content="ie=edge">
        <title>O'clock - Test technique - Alexandre Mouillard</title>
        <link rel="stylesheet"
              href="public/css/reset.css">
        <!-- style.css est un fichier compilé depuis style.scss -->
        <link rel="stylesheet"
              href="public/css/style.css">
    </head>
    <body>
        <header>
            <h1>Jeu de mémoire</h1>
        </header>

        <main id="board">
            <!--Le contenu de cet élément est généré par la boucle cards.forEach dans public/js/script.js !-->
        </main>

        <footer>
            <progress id="progress-bar"
                      value="0"
                      max="100"></progress>
            <p>Temps restant : <span id="time-left">120</span> secondes</p>
        </footer>

        <div class="dialog-background">
            <div id="start-dialog"
                 class="dialog-box"
                 style="display: none;">
                <h1>Jeu de mémoire</h1>
                <p>Bienvenue !</p>
                <p>Le but du jeu est de trouver toutes les paires dans le temps imparti.</p>
<?php
                if(count($scores)) {
?>
                    <h3>Meilleur scores :</h3>
                    <ul id="high-scores">
<?php
                        foreach ($scores as $score) {
?>
                            <li><?= $score['playerName']; ?> : <?= $score['time']; ?></li>
<?php
                        }
?>
                    </ul>
<?php
                } else {
?>
                    <p>(Aucun score pour l'instant. A vous de jouer !)</p>
<?php
                }
?>
                <button id="start-button">Démarrer</button>
            </div>

            <div id="lose-dialog"
                 class="dialog-box"
                 style="display: none;">
                <h1>Aïe, c'est perdu...</h1>
                <p>Paires trouvées : <span id="pairs-found"></span></p>
                <button id="restart-button">Réessayer</button>
            </div>

            <div id="win-dialog"
                 class="dialog-box"
                 style="display: none;">
                <h1>Gagné, bravo !</h1>
                <p>Score : <span id="score"></span></p>

                <form action="scores"
                      method="POST">
                    <input placeholder="Nom du joueur"
                           name="playerName"
                           type="text"
                           required/>

                    <input id="score-input"
                           type="hidden"
                           name="time"/>

                    <button type="submit">Enregistrer</button>
                </form>
            </div>
        </div>

        <button id="cheat-button">Cheat mode</button>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="public/js/helpers.js"></script>
        <script src="public/js/script.js"></script>
    </body>
</html>