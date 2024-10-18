<?php
require_once 'monetbil.php';
require_once '../connexion.php';
// Activer le rapport d'erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Simulate a payment success
$payment_status = Monetbil::STATUS_SUCCESS;

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$ville_depart = $_POST['ville_depart'];
$ville_arrivee = $_POST['ville_arrivee'];
$classe = $_POST['classe'];
$nombre_places = $_POST['nombre_places'];
$prix_bagages = $_POST['prix_bagages'];
$prix_ticket = $_POST['prix_ticket'];
$montant_net = $_POST['montantNet'];
$date_reservation = date('Y-m-d H:i:s'); // Date actuelle pour la réservation
// Stocker les informations de réservation dans des variables de session
$_SESSION['reservation_details'] = array(
    'nom' => $nom,
    'prenom' => $prenom,
    'email' => $email,
    'ville_depart' => $ville_depart,
    'ville_arrivee' => $ville_arrivee,
    'classe' => $classe,
    'nombre_places' => $nombre_places
);

// Définir les variables nécessaires pour l'insertion
$id_user_utilisateur = 1; // Exemple : ID de l'utilisateur
$id_voyage_voyage = 1; // Exemple : ID du voyage
$id_agence_agence = 1; // Exemple : ID de l'agence
$id_paiement_paiement = NULL; // Pour le moment, l'ID du paiement est NULL jusqu'à ce que le paiement soit inséré

// Connexion à la base de données
$conn = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connexion réussie à la base de données.<br>";

// Insérer les données dans la table reservation
$stmt = $conn->prepare("INSERT INTO reservation (date_reservation, id_user_utilisateur, id_voyage_voyage, id_paiement_paiement, id_agence_agence) VALUES (?, ?, ?, ?, ?)");
if ($stmt === false) {
    die("Erreur de préparation de la requête pour reservation : " . $conn->error);
}
echo "Préparation de la requête pour reservation réussie.<br>";

$stmt->bind_param("siiii", $date_reservation, $id_user_utilisateur, $id_voyage_voyage, $id_paiement_paiement, $id_agence_agence);
$stmt->execute();
if ($stmt->affected_rows > 0) {
    echo "Données insérées dans la table reservation.<br>";
    $reservation_id = $stmt->insert_id; // Récupérer l'ID de la réservation insérée
} else {
    echo "Échec de l'insertion des données dans la table reservation.<br>";
}
$stmt->close();

// Insérer les données dans la table paiement
$mode_paiement = 'Monetbil'; // Mode de paiement utilisé
$date_paiement = date('Y-m-d H:i:s'); // Date actuelle pour le paiement

$stmt = $conn->prepare("INSERT INTO paiement (montant_total, mode_paiement, date_paiement, id_reservation_reservation) VALUES (?, ?, ?, ?)");
if ($stmt === false) {
    die("Erreur de préparation de la requête pour paiement : " . $conn->error);
}
echo "Préparation de la requête pour paiement réussie.<br>";

$stmt->bind_param("dssi", $montant_net, $mode_paiement, $date_paiement, $reservation_id);
$stmt->execute();
if ($stmt->affected_rows > 0) {
    echo "Données insérées dans la table paiement.<br>";
    $paiement_id = $stmt->insert_id; // Récupérer l'ID du paiement inséré
} else {
    echo "Échec de l'insertion des données dans la table paiement.<br>";
}
$stmt->close();

// Mettre à jour la table reservation avec l'ID du paiement
$stmt = $conn->prepare("UPDATE reservation SET id_paiement_paiement = ? WHERE id_reservation = ?");
if ($stmt === false) {
    die("Erreur de préparation de la requête pour mise à jour reservation : " . $conn->error);
}
echo "Préparation de la requête pour mise à jour reservation réussie.<br>";

$stmt->bind_param("ii", $paiement_id, $reservation_id);
$stmt->execute();
if ($stmt->affected_rows > 0) {
    echo "Table reservation mise à jour avec l'ID du paiement.<br>";
} else {
    echo "Échec de la mise à jour de la table reservation.<br>";
}
$stmt->close();

$conn->close();

// Redirection vers la page de succès ou affichage du message de succès
header('Location: return.php');
exit;
?>
