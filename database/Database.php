<?php

// Cette classe facilite l'accès à la base de données SQLite.
class Database
{
    private $database_file = 'database/database.db';
    private PDO $pdo;

    public function __construct()
    {
        // SQLite utilise un fichier pour stocker la base de données, on le crée s'il n'existe pas.
        if (!file_exists($this->database_file)) {
            touch($this->database_file);
        }

        // PDO est une classe présente par défaut dans PHP qui permet la communication entre PHP et la BDD.
        $this->pdo = new PDO("sqlite:{$this->database_file}");
    }

    public function get()
    {
        return $this->pdo;
    }
}