<?php
// Informations de connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$basededonnees = "taziya";

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$serveur;dbname=$basededonnees", $utilisateur, $motdepasse);
    // Configuration de PDO pour afficher les erreurs
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    die("Échec de la connexion : " . $e->getMessage());
}
?>
