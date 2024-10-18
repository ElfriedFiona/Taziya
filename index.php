<?php
include 'connexion.php';

  // Vérification si le formulaire a été soumis
  if (isset($_POST['rechercher'])) {
      // Récupérer les données du formulaire
      $ville_depart = $_POST['ville_depart'];
      $ville_arrivee = $_POST['ville_arrivee'];
      $heure_depart = $_POST['heure_depart'];

      // Requête SQL pour rechercher les trajets correspondant aux critères
      $sql = "SELECT * FROM trajet_men WHERE ville_depart=:ville_depart AND ville_arrivé=:ville_arrivee AND heure_depart=:heure_depart";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':ville_depart', $ville_depart);
      $stmt->bindParam(':ville_arrivee', $ville_arrivee);
      $stmt->bindParam(':heure_depart', $heure_depart);
      $stmt->execute();
      $resultat = $stmt->fetchAll();

      // Vérification si des résultats ont été trouvés
      if ($resultat) {
          // Redirection vers la page d'accueil avec les résultats
          header('Location: agence_dispo.php?ville_depart=' . $ville_depart . '&ville_arrivee=' . $ville_arrivee . '&heure_depart=' . $heure_depart);
          exit();
      } else {
          echo "Aucun résultat trouvé.";
      }
  }
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
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


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
  <?php 
   include 'header.php';
  ?>

  <!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-left">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-left">
        <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
          <h1 class="mb-4 pb-0"><span>TAZIYA</span><br>The Travel Booking</h1>
          <p class="mb-4 pb-0">Aussi découvrer les meilleurs lieux touristiques au CAmeroun</p>
          <a href="#about" class="about-btn scrollto btn btn-primary mb-4">A propos du Site</a>
          <div class="trajet container" style="color: white;">
            <form action="agence_dispo.php" method="POST">
              <div class="row g-3 justify-content-center">
                <div class="col-md-12">
                </div>
                <div class="col-md-6">
                  <label for="ville_depart" class="form-label">Lieu de depart:</label>
                  <input type="text" class="form-control" name="ville_depart" id="ville_depart" value="Douala" placeholder="Douala" readonly>
                </div>
                <div class="col-md-6">
                  <label for="ville_arrivee" class="form-label">Lieu d'arrivée:</label>
                  <select class="form-select" name="ville_arrivee" id="ville_arrivee">
                    <option value="">select...</option>
                    <option name="ville_arrivee" id="ville_arrivee" value="Yaoundé">Yaoundé</option>
                    <option name="ville_arrivee" id="ville_arrivee" value="Kribi">Kribi</option>
                    <option name="ville_arrivee" id="ville_arrivee" value="Ngaoundéré">Ngaoundéré</option>
                    <option name="ville_arrivee" id="ville_arrivee" value="Bafoussam">Bafoussam</option>
                    <option name="ville_arrivee" id="ville_arrivee" value="Garoua">Garoua</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="heure_depart" class="form-label">Heure de depart:</label>
                  <select class="form-select" name="heure_depart" id="heure_depart" required>
                    <option value="">select...</option>
                    <?php
                      for ($i = 0; $i <= 23; $i++) {
                        $heure = str_pad($i, 2, "0", STR_PAD_LEFT); // Add a zero in front of numbers < 10
                        echo "<option value='$heure:00'>$heure:00</option>";
                      }
                    ?>
                  </select>
                </div>
                <!-- <div class="col-md-6">
                  <label for="heure_depart" class="form-label">Agence:</label>
                  <select class="form-select" name="heure_depart" id="heure_depart" required>
                    <option value="">select...</option>
                    <?php
                     $req = "SELECT nom_agence FROM agence ";// Remplacez 'utilisateurs' par le nom de votre table et 'id' par le champ utilisé pour identifier l'utilisateur
                     $result = $conn->query($req); // Exemple d'ID, à remplacer par la valeur réelle de l'ID de l'utilisateur
                     
                      // Parcourir les résultats et afficher chaque nom dans une option du select
                      while($row = $result->fetch()) {
                          echo '<option value="' . $row["nom_agence"] . '">' . $row["nom_agence"] . '</option>';
                      }
                    ?>
                  </select>
                </div> -->
                <div class="col-12">
                  <button type="submit" class="btn btn-outline-info" name="rechercher" id="rechercher">Rechercher</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section><!-- End Hero Section -->


  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about">
      <div class="container position-relative" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-6">
            <h2>A propos</h2>
            <p>TAZIYA est une plateforme de réservation de ticket de bus au Cameroun.  
            </p>
          </div>
        </div>
      </div>
    </section><!-- End About Section -->

    
    
    

    

    <!-- =======  F.A.Q Section ======= -->
    <section id="faq">

      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>F.A.Q </h2>
        </div>

        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-9">

            <ul class="faq-list">

              <li>
                <div data-bs-toggle="collapse" class="collapsed question" href="#faq1">Où? <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i></div>
                <div id="faq1" class="collapse" data-bs-parent=".faq-list">
                  <p>
                    Cameroun plus précisement à Douala
                  </p>
                </div>
              </li>

              <li>
                <div data-bs-toggle="collapse" href="#faq2" class="collapsed question">heure <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i></div>
                <div id="faq2" class="collapse" data-bs-parent=".faq-list">
                  <p>
                    24hr/24
                  </p>
                </div>
              </li>

              <!-- <li>
                <div data-bs-toggle="collapse" href="#faq3" class="collapsed question">Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi? <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i></div>
                <div id="faq3" class="collapse" data-bs-parent=".faq-list">
                  <p>
                    Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
                  </p>
                </div>
              </li>

              <li>
                <div data-bs-toggle="collapse" href="#faq4" class="collapsed question">Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla? <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i></div>
                <div id="faq4" class="collapse" data-bs-parent=".faq-list">
                  <p>
                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                  </p>
                </div>
              </li> -->


            </ul>

          </div>
        </div>

      </div>

    </section><!-- End  F.A.Q Section -->

    <!-- ======= Subscribe Section ======= -->
    <section id="subscribe">
      <div class="container" data-aos="zoom-in">
        <div class="section-header">
          <h2>Newsletter</h2>
        </div>

        <form method="POST" action="#">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10 d-flex">
              <input type="text" class="form-control" placeholder="Enter your Email">
              <button type="submit" class="ms-2">Subscribe</button>
            </div>
          </div>
        </form>

      </div>
    </section><!-- End Subscribe Section -->

    

    <style>
      .trajet{
        background-color: MIDNIGHTBLUE;
        width: 1000px;
        height: 50%;
        border-radius:20px;
      }
      /* .trajet .trajet_form{
        text-align: left;
        margin-left: 100px;
      } */
      /* .trajet .trajet_form button{
        border-radius: 10px;
      } */
    </style>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php 
   include 'footer.php';
  ?>
  
  <script src="assets/js/main.js"></script>

</body>

</html>
<!-- Page de résultats (resultats.php) -->



