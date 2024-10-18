<?php
include 'connexion.php';

$sql = "SELECT id_agence, nom_agence FROM agence";
$stmt = $conn->prepare($sql);
$stmt->execute();
$agences = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($agences);
?>
