<?php

define('HOST', 'localhost'); // Domaine ou IP du serveur ou est située la base de données
define('USER', 'root'); // Nom d'utilisateur autorisé à se connecter à la base
define('PASS', ''); // Mot de passe de connexion à la base
define('DB', 'diw8'); // Base de données sur laquelle on va faire les requêtes

function connexion() {
    static $db;

    if (isset($db))
        return $db;

    // Tableau d'options supplémentaires pour la connexion
    $db_options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", // On force l'encodage en utf8
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // On récupère tous les résultats en tableau associatif
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING // On affiche des warnings pour les erreurs, à commenter en prod (valeur par défaut PDO::ERRMODE_SILENT)
    );

    // Connexion à la base locale diw8
    try {
        $db = new PDO('mysql:host=' . HOST . ';dbname=' . DB, USER, PASS, $db_options);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    return $db;
}