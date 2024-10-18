<?php
include 'connexion.php';

if (isset($_POST['agence_id'])) {
    $agence_id = $_POST['agence_id'];
    
    $sql = "SELECT DISTINCT ville_depart, ville_arrivé FROM trajet_men WHERE agence_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $agence_id, PDO::PARAM_INT);
    $stmt->execute();
    $villes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($villes);
}
?>
