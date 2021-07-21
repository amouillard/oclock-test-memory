<?php

// On importe les modules requis, ici le routage de la requête et le modèle gérant le stockage des scores
require_once 'Router.php';
require_once 'models/ScoreModel.php';

// On initialise le modèle. Plus d'infos dans les classes Model / ScoreModel !
$scoreModel = new ScoreModel();
$scoreModel->setup();

// Instanciation du router. Toutes les requêtes passent par index.php, le router détermine l'action à effectuer selon les paramètres
$router = new Router();

// Si la requête pointe vers l'index (http://localhost:3000) on récupère les scores et on les passe à la vue
$router->get('/', function () use ($scoreModel) {
    $scores = $scoreModel->get();
    include 'views/main.php';
});

// Si la requête est un POST vers http://localhost:3000/scores, on enregistre et on renvoie sur l'index
$router->post('/scores', function ($postData) use ($router, $scoreModel) {
    $scoreModel->store([
        'playerName' => $postData['playerName'],
        'time'       => $postData['time'],
    ]);

    $router->redirect('/');
});