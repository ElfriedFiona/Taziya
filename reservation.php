<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  session_start();
  if (!isset($_SESSION['SESSION_EMAIL'])) {
      header("Location: login&signup/index.php");
      die();
  }
  
  include 'connexion.php';
  
  // Récupération de l'email de la session
  $email_user = $_SESSION['SESSION_EMAIL'];
  $agence= 
  // Requête SQL pour récupérer les données de l'utilisateur via l'email
  $sql = "SELECT * FROM utilisateur WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1, $email_user);
  $stmt->execute();
  $userData = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();

  // Requête SQL pour récupérer les données de l'utilisateur via l'email
  
  $hey = "SELECT * FROM agence";
  $stmt1 = $conn->prepare($hey);
  $stmt1->execute();
  $userData1 = $stmt1->fetch(PDO::FETCH_ASSOC);
  $stmt1->closeCursor();

  // Requête SQL pour récupérer les données de l'utilisateur via l'email
  $agence= $userData1["id_agence"];
  $sql2 = "SELECT * FROM trajet_men WHERE agence_id = ?";
  $stmt2 = $conn->prepare($sql2);
  $stmt2->bindParam(1, $agence);
  $stmt2->execute();
  $userData2 = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt2->closeCursor();

  // Affichage de l'accueil de l'utilisateur
  include 'login&signup/config.php';
  $query = mysqli_query($conn, "SELECT * FROM utilisateur WHERE email='{$_SESSION['SESSION_EMAIL']}'");
  
  if (mysqli_num_rows($query) > 0) {
      $row = mysqli_fetch_assoc($query);
      echo "Welcome " . $row['prenom'] . " <a href='login&signup/logout.php'>Logout</a>";
  }
  // Récupération des informations du trajet sélectionné
  $trajet = null;
  if (isset($_GET['id']) && isset($_SESSION['trajets'])) {
      $id = $_GET['id'];
      foreach ($_SESSION['trajets'] as $t) {
          if ($t['id'] == $id) {
              $trajet = $t;
              break;
          }
      }
  }
  
  /*
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License or any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
  */
  // Traitement du formulaire de paiement
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les valeurs du formulaire
    $nombre_places = isset($_POST['NB_place']) ? intval($_POST['NB_place']) : 0;
    $poids_bagages = isset($_POST['poids_bagages']) ? intval($_POST['poids_bagages']) : 0;
    $montantNetPayer = isset($_POST['montantNet']) ? intval($_POST['montantNet']) : 0;

    // Calcul du prix des bagages
    $prix_bagages = ($poids_bagages / 10) * 1000;

    // Vérification de la variable trajet
    if (isset($trajet) && isset($trajet['prix'])) {
        $prix_place = intval($trajet['prix']);
    } else {
        $prix_place = 0; // Ou gérer l'erreur autrement
    }

    // Calcul du montant net
    $montantNet = ($nombre_places * $prix_place) + $prix_bagages;

    // Assurez-vous que les clés du tableau $trajet sont correctement définies
    $id_voyage = isset($trajet['id_voyage']) ? $trajet['id_voyage'] : '';
    $ville_depart = isset($trajet['ville_depart']) ? $trajet['ville_depart'] : '';
    $ville_arrivee = isset($trajet['ville_arrivé']) ? $trajet['ville_arrivé'] : '';
    $classe = isset($trajet['classe']) ? $trajet['classe'] : '';
    $heure_depart=isset ($trajet['heure_depart'])?$trajet['heure_depart']:'';
    $nom_agence=isset($trajet['nom_agence'])?$trajet['nom_agence']:'';
    $agence_id=isset($trajet['agence_id'])?$trajet['agence_id']:'';

    // Insérer les données dans la table reservation sans id_paiement pour l'instant
    $sql_insert = "INSERT INTO reservation (date_reservation, id_user, id_voyage, id_agence, nom_agence, nom, prenom, email, ville_depart, ville_arrivee, classe, heure_depart, nombre_places) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iiissssssssi", 
        $userData['id_user'],
        $id_voyage, 
        $agence_id,
        $nom_agence,
        $userData['nom'],
        $userData['prenom'],
        $userData['email'],
        $ville_depart,
        $ville_arrivee,
        $classe,
        $heure_depart,
        $nombre_places
    );
    $stmt_insert->execute();
    $id_reservation = $stmt_insert->insert_id; // Récupérer l'ID de la réservation insérée
    $stmt_insert->close();

    // Insérer une entrée dans la table paiement avec l'id_reservation
    $sql_paiement = "INSERT INTO paiement (mode_paiement, date_paiement, id_reservation, prix_bagages, prix_ticket, montantnetPayer) VALUES (?, NOW(), ?, ?, ?, ?)";
    $stmt_paiement = $conn->prepare($sql_paiement);
    $mode_paiement = "monetbil"; // Changez ceci selon votre contexte
    $prix_ticket = $nombre_places * $prix_place;
    $stmt_paiement->bind_param("siiii", $mode_paiement, $id_reservation, $prix_bagages, $prix_ticket, $montantNet);
    $stmt_paiement->execute();
    $id_paiement = $stmt_paiement->insert_id; // Récupérer l'ID du paiement inséré
    $stmt_paiement->close();

    // Mettre à jour la réservation avec l'id_paiement
    $sql_update_reservation = "UPDATE reservation SET id_paiement = ? WHERE id_reservation = ?";
    $stmt_update = $conn->prepare($sql_update_reservation);
    $stmt_update->bind_param("ii", $id_paiement, $id_reservation);
    $stmt_update->execute();
    $stmt_update->close();
}

    require_once 'monetbil-php-master/monetbil.php';
  
 // Setup Monetbil arguments
  Monetbil::setAmount($montantNetPayer);
  Monetbil::setCurrency('XAF');
  Monetbil::setLocale('fr'); // Display language fr or en
  Monetbil::setPhone('');
  Monetbil::setCountry('');
  Monetbil::setItem_ref('2536');
  Monetbil::setPayment_ref('d4be3535f9cb5a7aff1f84fa94e6f040');
  Monetbil::setUser(12);
  Monetbil::setFirst_name($userData['nom']);
  Monetbil::setLast_name($userData['prenom']);
  Monetbil::setEmail($userData['email']);
  Monetbil::setLogo('https://storage.googleapis.com/cdn.ucraft.me/userFiles/ukuthulamovies/images/937-your-logo.png');

  // This example show payment button
  $payment_url = Monetbil::url();
   
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
  <?php 
   include 'header.php';
  ?>
  
   <!-- ======= Buy Ticket Section ======= -->
   <section id="buy-tickets" class="section-with-bg">
      <div class="container-fuild" data-aos="fade-up">

        <div class="section-header" style="margin-top: 100px;">
          <h2>RESERVATION</h2>
        </div>
        <form id="reservationForm" method="post" action="">
        <div class="card card-primary">
        <div class="row" >
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card mb-5 mb-lg-0" style="height: 490px;">
              <div class="card-body">
               <h6 class="card-price text-center">Informations</h6>
                <hr>
                <ul class="fa-ul" style="list-style-type: none;">
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input class="form-control" type="text" name="nom" placeholder="<?php echo $userData['nom']; ?>" readonly></li>
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input class="form-control"  type="text" name="prenom" placeholder="<?php echo $userData['prenom']; ?>" readonly></li>
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input class="form-control"  type="text" name="telephone" placeholder="<?php echo $userData['telephone']; ?>" readonly></li>
                  
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input class="form-control"  type="text" id="NB_place" name="NB_place"  placeholder="Nombres de places"></li>
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input class="form-control"  type="text" style="width:300px;" id="poids_bagages" name="poids_bagages" placeholder="Poids lourd: 10kilo= 1000Fcfa"></li>
                </ul>
                <hr>
              </div>
            </div>
          </div>
          <div class="col" data-aos="fade-up" data-aos-delay="200">
           <div class="card mb-5 mb-lg-0" style="height: 490px;">
              <div class="card-body">
                <h6 class="card-price text-center">Trajet</h6>
                
                

                <hr>
                <ul class="fa-ul" style="list-style-type: none;">
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input type="text" name="agence" placeholder="nom agence" class="form-control" value="<?php echo $trajet ? $trajet['nom_agence'] : ''; ?>" readonly></li>
                  
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input type="text" name="ville_depart" placeholder="ville de depart" class="form-control" value="<?php echo $trajet ? $trajet['ville_depart'] : ''; ?>" readonly></li>
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input type="text" name="ville_arrivee" placeholder="ville d'arrivée" class="form-control" value="<?php echo $trajet ? $trajet['ville_arrivé'] : ''; ?>" readonly></li>
                  
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input type="text" name="classe" placeholder="classe" class="form-control" value="<?php echo $trajet ? $trajet['classe'] : ''; ?>" readonly></li>
                  
                </ul>
                <hr>
                
            <button id="buyNowButton" type="submit" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#buy-ticket-modal" data-ticket-type="pro-access">Buy Now</button>
          
              </div>
            </div>
          </div><br><br>
          <?php 
          include 'details_bus.php';
          ?>
          <br><br>

        </div>
        <input type="hidden" id="montantNetHidden" name="montantNet">
         
        </div>
        </form>
      </div>

      <!-- Modal Order Form -->
<div id="buy-ticket-modal" class="modal fade">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buy Tickets</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!DOCTYPE html>
      <html lang="fr">

    
        <?php

?>
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment Form - TAZIYA</title>
        <link rel="stylesheet" href="style.css">  
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
      </head>

      <body>
        <div class="wrapper">
          <h2>Paiement</h2>
          <br>
          <p>Veuillez effectuer le paiement suivant pour valider votre réservation</p>
          <br>
          <form action="" method="post">
            <!--Account Information Start-->
            <h4>Détails de vos informations personnelles</h4>
            <div class="input_group">
              <div class="input_box">
                <input type="text" name="nom" placeholder="<?php echo $userData['nom']; ?>"  class="name">
                <i class="fa fa-user icon"></i>
              </div>
              <div class="input_box">
                <input type="text" name="prenom" placeholder="<?php echo $userData['prenom']; ?>"  class="name">
                <i class="fa fa-user icon"></i>
              </div>
            </div>
            <div class="input_group">
              <div class="input_box">
                <input type="email" name="email" placeholder="<?php echo $userData['email']; ?>" class="name">
                <i class="fa fa-envelope icon"></i>
              </div>
            </div>
            <div class="input_group">
              <div class="input_box">
                <input type="text" name="ville_depart" value="<?php echo $trajet ? $trajet['ville_depart'] : ''; ?>" class="name">
                <i class="fa fa-map-marker icon" aria-hidden="true"></i>
              </div>
              <div class="input_box">
                <input type="text" name="ville_arrivee" value="<?php echo $trajet ? $trajet['ville_arrivé'] : ''; ?>" class="name">
                <i class="fa fa-institution icon"></i>
              </div>
            </div>
            <div class="input_group">
              <div class="input_box">
                <input name="classe" value="<?php echo $trajet ? $trajet['classe'] : ''; ?>" class="name">
                <i class="fa fa-institution icon"></i>
              </div>
              <div class="input_box">
                <input type="text" name="nombre_places" id="nombre_places" placeholder="Nombre de places" readonly class="name">
                <i class="fa fa-user icon"></i>
              </div>
            </div>
            <!--Account Information End-->
            <!--Payment Details Start-->
            <div class="input_group">
              <div class="input_box">
                <h4>Payment Details</h4>
                 </div>
            </div>
            <div class="input_group">
    <div class="input_box">
        <input type="number" name="prix_bagages" id="prix_bagages" placeholder="Prix des bagages" readonly class="name">
        <i class="fa fa-money icon" aria-hidden="true"></i>
    </div>
</div>
<div class="input_group">
    <div class="input_box">
        <input type="number" name="prix_ticket" id="prix_ticket" placeholder="Prix du ticket" readonly value="<?php echo $trajet ? $trajet['prix'] : ''; ?>" class="name">
        <i class="fa fa-money icon" aria-hidden="true"></i>
    </div>
</div>
<input type="hidden" id="montantNetHidden" name="montantNet">
<div class="input_group">
    <div class="input_box">
        <input type="number" id="montant_net" name="montantNet" placeholder="Montant Net à Payer" readonly class="name">
        <i class="fa fa-money icon" aria-hidden="true"></i>
    </div>
</div>
        </div>
<style type="text/css">
    .btnmnb {
        background: #3498db;
        background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
        background-image: -moz-linear-gradient(top, #3498db, #2980b9);
        background-image: -ms-linear-gradient(top, #3498db, #2980b9);
        background-image: -o-linear-gradient(top, #3498db, #2980b9);
        background-image: linear-gradient(to bottom, #3498db, #2980b9);
        font-family: Arial;
        color: #ffffff;
        font-size: 20px;
        padding: 10px 20px 10px 20px;
        text-decoration: none;
        cursor: pointer;
    }

    .btnmnb:hover {
        background: #3cb0fd;
        background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
        background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
        background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
        background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
        background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
        text-decoration: none;
    }
</style>
</form>
<?php if (Monetbil::MONETBIL_WIDGET_VERSION_V2 == Monetbil::getWidgetVersion()): ?>
    <form action="<?php echo $payment_url; ?>" method="post" data-monetbil="form">
        <button type="submit" class="btnmnb" id="monetbil-payment-widget">Pay By Mobile Money</button>
    </form>
   
<?php else: ?>
    <a class="btnmnb" href="<?php echo $payment_url; ?>" id="monetbil-payment-widget">Pay By Mobile Money</a>
<?php endif; ?>

<!-- To open widget, add JS files -->
<?php echo Monetbil::js(); ?>

<!-- To auto open widget, add JS files -->
<?php
//echo Monetbil::js(true); ?></div>
      </body>
            </html>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


    </section><!-- End Buy Ticket Section -->
      <!-- ======= Footer ======= -->
  <?php 
   include 'footer.php';
  ?>
<!-- End Venue Section -->
<script>
    
    // Récupérer les éléments du DOM
    var poidsBagagesInput = document.getElementById('poids_bagages');
    var prixTicketInput = document.getElementById('prix_ticket');
    var montantNetInput = document.getElementById('montant_net');
    var nombresplaceInput = document.getElementById('NB_place');
    var nombreplaceInput = document.getElementById('nombre_places');
    var prixbagagesInput = document.getElementById('prix_bagages');

    // Fonction pour envoyer la valeur du montant_net à PHP
    function calculerMontantNet() {
     
        // Fonction pour calculer le montant net à payer
        var prixTicket = parseFloat(prixTicketInput.value)|| 0;
        var poidsBagages = parseFloat(poidsBagagesInput.value)|| 0;
        var places = parseFloat(nombresplaceInput.value)|| 0;
        var montantBagages = poidsBagages >= 10 ? (Math.floor(poidsBagages / 10) * 1000) : 0;
        var nombreplace = places + 0;
            nombreplaceInput.value = nombreplace;
        var prixbagages = montantBagages.toFixed(2);
            prixbagagesInput.value = prixbagages;
        // Vérifier si les valeurs sont valides
        if (!isNaN(prixTicket) && !isNaN(poidsBagages)) {
            var montantNet = (prixTicket*places) + montantBagages;
            montantNetInput.value = montantNet.toFixed(2); // Afficher le montant net avec deux décimales
            
              }
    }


    // Écouter les événements de saisie dans le champ du poids des bagages
    poidsBagagesInput.addEventListener('input', calculerMontantNet);
    nombresplaceInput.addEventListener('input', calculerMontantNet);

</script>
<script>
  document.getElementById('buyNowButton').addEventListener('click', function(event) {
    // Empêcher le comportement par défaut du bouton
    event.preventDefault();
    
    // Calculer le montantNet
    var nombre_places = parseInt(document.getElementById('NB_place').value) || 0;
    var poids_bagages = parseInt(document.getElementById('poids_bagages').value) || 0;
    var prix_place = <?php echo isset($trajet) && isset($trajet['prix']) ? intval($trajet['prix']) : 0; ?>;
    
    var prix_bagages = (poids_bagages / 10) * 1000;
    var montantNet = (nombre_places * prix_place) + prix_bagages;
    
    // Mettre à jour le champ caché avec le montantNet
    document.getElementById('montantNetHidden').value = montantNet;
    
    // Soumettre le formulaire via AJAX
    var form = document.getElementById('reservationForm');
    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', form.action, true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        // Formulaire soumis avec succès, afficher la modal
        var modalElement = document.getElementById('buy-ticket-modal');
        var modal = new bootstrap.Modal(modalElement);
        modal.show();
        
        // Écouter l'événement de fermeture de la modal pour rafraîchir la page
        modalElement.addEventListener('hidden.bs.modal', function () {
          location.reload();
        });
      } else {
        // Gérer les erreurs
        console.error('Erreur lors de la soumission du formulaire.');
      }
    };
    xhr.send(formData);
  });
</script>

    <script src="assets/js/main.js"></script>
    <style>
      .fa-ul input{
        width:1000px;
      }
    </style>
  
</body>
</html>