<?php
session_start();
include 'connexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TAZIYA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/Agent Logo.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
  <!-- ======= Header ======= -->
  <?php include 'header.php'; ?>
<br><br>
  <div class="container mt-5">
    <div class="row">
      <?php
      // Récupérer les données de l'URL
      if (isset($_POST['ville_depart'], $_POST['ville_arrivee'], $_POST['heure_depart'])) {
          $ville_depart = $_POST['ville_depart'];
          $ville_arrivee = $_POST['ville_arrivee'];
          $heure_depart = $_POST['heure_depart'];

          // Requête SQL pour récupérer les informations
          $sql = "SELECT tm.*, a.nom_agence 
                  FROM trajet_men tm 
                  JOIN agence a ON tm.agence_id = a.id_agence 
                  WHERE tm.ville_depart = :ville_depart 
                  AND tm.ville_arrivé = :ville_arrivee 
                  AND tm.heure_depart = :heure_depart";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':ville_depart', $ville_depart);
          $stmt->bindParam(':ville_arrivee', $ville_arrivee);
          $stmt->bindParam(':heure_depart', $heure_depart);
          $stmt->execute();
          $resultats = $stmt->fetchAll();

          if ($resultats) {
              $_SESSION['trajets'] = $resultats; // Stocker les résultats dans la session
              foreach ($resultats as $row) {
                  echo '<div class="col-md-4" style="margin-top: 30px;">';
                  echo '<div class="card border-primary mb-3">';
                  echo '<div class="card-header bg-primary text-white">' . $row["nom_agence"] . '</div>';
                  echo '<div class="card-body">';
                  echo '<h5 class="card-title"><i class="bi bi-map"></i> Trajet</h5>';
                  echo '<p class="card-text"><strong>Départ :</strong> ' . $row["ville_depart"] . '<br><strong>Arrivée :</strong> ' . $row["ville_arrivé"] . '</p>';
                  echo '<h5 class="card-title"><i class="bi bi-clock"></i> Horaires</h5>';
                  echo '<p class="card-text">' . $row["heure_depart"] . '- ' . $row["heure_arrivé"] . '</p>';
                  echo '<p class="card-text"><strong>Classe :</strong> ' . $row["classe"] . '</p>';
                  echo '<a href="reservation.php?id=' . $row["id"] . '" class="btn btn-primary"><i class="bi bi-calendar-check"></i> Réserver</a>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
              }
          } else {
              echo '<div class="col-12"><p class="text-center">Aucun résultat trouvé.</p></div>';
          }
      }
      ?>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- ======= Footer ======= -->
  <?php include 'footer.php'; ?>
</body>
</html>
