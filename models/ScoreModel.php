<?php

require_once 'Model.php';

// La classe ScoreModel hérite du constructeur de Model et de sa propriété $db, référence à la base de données.
// Elle doit aussi implémenter les méthodes setup() / get() / store().
class ScoreModel extends Model
{
    // Mise en place du modèle, si sa table n'existe pas encore, on la crée.
    public function setup()
    {
        // La syntaxe <<<SQL... SQL; est une simple chaîne de caractères multi-lignes en PHP
        // elle rend plus lisible le texte et permet à certains éditeurs de comprendre qu'il s'agit de SQL.

        // Ici la table scores contiendra trois champs :
        // id - un identifiant unique numérique (integer) que nous n'avons pas à gérer, car il s'incrémente tout seul
        // playerName - une chaîne de caractères avec le nom du gagnant
        // time - le temps en seconde qu'à mis le joueur pour gagner
        $setup_sql = <<<SQL
            CREATE TABLE IF NOT EXISTS scores (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                playerName VARCHAR(50),
                time INTEGER
            )
        SQL;

        $this->db
            ->prepare($setup_sql)
            ->execute();
    }

    // On récupère la liste des meilleurs scores.
    public function get()
    {
        // La requête sélectionne tous les champs de la table score et les trie du plus petit (le meilleur) au plus grand.
        // LIMIT permet de n'afficher que les 5 meilleurs scores.
        $index_sql = <<<SQL
            SELECT id, playerName, time
            FROM scores
            ORDER BY time
            LIMIT 5;
        SQL;

        return $this->db
            ->query($index_sql)
            ->fetchAll();
    }

    // Enregistrement d'un nouveau score.
    public function store(array $data)
    {
        // On utilise une requête préparée pour des raisons de sécurité plutôt que de concaténer directement les valeurs.
        // Les explications plus détaillées arriveront normalement vers la saison 6... :)
        // Dans une vraie application il faudrait aussi valider les paramètres (que faire si le playerName est vide ?
        // si il dépasse 50 caractères ? etc.)
        $create_sql = <<<SQL
            INSERT INTO scores (playerName, time)
            VALUES (:playerName, :time)
        SQL;

        return $this->db
            ->prepare($create_sql)
            ->execute([
                'playerName' => $data['playerName'],
                'time'       => $data['time'],
            ]);
    }
}