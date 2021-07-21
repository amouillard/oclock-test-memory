<?php

require_once 'database/Database.php';

// Tout modèle a un accès à la base de données et doit implémenter ses méthodes de
// mise en place, récupération des données et enregistrement d'une ligne.
abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->get();
    }

    // Mise en place de la table du modèle.
    abstract public function setup();

    // Récupération de toutes les lignes de la table du modèle.
    abstract public function get();

    // Enregistrement d'une ligne dans la table du modèle.
    abstract public function store(array $data);
}
