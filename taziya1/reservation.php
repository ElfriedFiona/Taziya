<?php
session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: login&signup/index.php");
    die();
}

include 'connexion.php';

// Récupération de l'email de la session
$email_user = $_SESSION['SESSION_EMAIL'];

// Requête SQL pour récupérer les données de l'utilisateur via l'email
$sql = "SELECT * FROM utilisateur WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $email_user);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();

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

        <div class="row" >
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card mb-5 mb-lg-0">
              <div class="card-body">
                <h6 class="card-price text-center">Informations</h6>
                <hr>
                <ul class="fa-ul" style="list-style-type: none;">
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input type="text" value="<?php echo $userData['nom']; ?>" readonly></li>
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input type="text" value="<?php echo $userData['prenom']; ?>" readonly></li>
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input type="text" value="<?php echo $userData['telephone']; ?>" readonly></li>
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input type="number" placeholder="Nombres de places"></li>
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input type="number" style="width:300px;" placeholder="Poids lourd: 10kilo= 1000Fcfa"></li>
                </ul>
                <hr>
              </div>
            </div>
          </div>
          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card mb-5 mb-lg-0" style="height: 413px;">
              <div class="card-body">
                <h6 class="card-price text-center">Trajet</h6>
                <hr>
                <ul class="fa-ul" style="list-style-type: none;">
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input type="text" value="<?php echo $trajet ? $trajet['nom_agence'] : ''; ?>" readonly></li>
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input type="text" value="<?php echo $trajet ? $trajet['ville_depart'] : ''; ?>" readonly></li>
                  <li><span class="fa-li"><i class="fa fa-check"></i></span><input type="text" value="<?php echo $trajet ? $trajet['ville_arrivé'] : ''; ?>" readonly></li>
                  <li><span class="fa-li"><i class="fa fa-check"></i></span>
                      <select name="classe" id="classe" readonly>
                        <option value=""><?php echo $trajet ? $trajet['classe'] : '---type de classe---'; ?></option>
                      </select>
                </li>
                </ul>
                <hr>
              </div>
            </div>
          </div>
          <!-- Ajouter un autre bloc si nécessaire -->
        </div>
      </div>
   </section>

          <div class="text-center" style="font-size: 15px;
          border-radius: 50px;
          padding: 10px 40px;
          transition: all 0.2s; margin-left: 550px;
          background-color: #f82249;
          border: 0;
          color: #fff; width:500px; margin-left:200px;">
            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#buy-ticket-modal" data-ticket-type="pro-access">Buy Now</button>
          </div>
        </div>

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

require_once 'monetbil-php-master/monetbil.php';

// Setup Monetbil arguments
Monetbil::setAmount(500);
Monetbil::setCurrency('XAF');
Monetbil::setLocale('fr'); // Display language fr or en
Monetbil::setPhone('');
Monetbil::setCountry('');
Monetbil::setItem_ref('2536');
Monetbil::setPayment_ref('d4be3535f9cb5a7aff1f84fa94e6f040');
Monetbil::setUser(12);
Monetbil::setFirst_name('elfried');
Monetbil::setLast_name('fiona');
Monetbil::setEmail('elfried0207@gmail.com');
Monetbil::setLogo('https://storage.googleapis.com/cdn.ucraft.me/userFiles/ukuthulamovies/images/937-your-logo.png');

// This example show payment button
$payment_url = Monetbil::url();
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
                <input type="text" placeholder="<?php echo $userData['nom']; ?>" required class="name">
                <i class="fa fa-user icon"></i>
              </div>
              <div class="input_box">
                <input type="text" placeholder="<?php echo $userData['prenom']; ?>" required class="name">
                <i class="fa fa-user icon"></i>
              </div>
            </div>
            <div class="input_group">
              <div class="input_box">
                <input type="email" placeholder="<?php echo $userData['email']; ?>" required class="name">
                <i class="fa fa-envelope icon"></i>
              </div>
            </div>
            <div class="input_group">
              <div class="input_box">
              <input type="text" value="<?php echo $trajet ? $trajet['ville_depart'] : ''; ?>" required class="name">
                <i class="fa fa-map-marker icon" aria-hidden="true"></i>
              </div>
              <div class="input_box">
              <input type="text" value="<?php echo $trajet ? $trajet['ville_arrivé'] : ''; ?>"required class="name">
                <i class="fa fa-institution icon"></i>
              </div>
            </div>
                
            <div class="input_group">
              <div class="input_box">
                <input type="text" value="<?php echo $trajet ? $trajet['classe'] : '---type de classe---'; ?>" required class="name">
                <i class="fa fa-institution icon"></i>
              </div>
              <div class="input_box">
                <input type="number" placeholder="Nombre de places" required class="name">
                <i class="fa fa-user icon"></i>
              </div>
            </div>
            <!--Account Information End-->
            <!--Payment Details Start-->
            <div class="input_group">
              <div class="input_box">
                <h4>Payment Details</h4>
                <div class="input_group">
                <div class="input_box">
                    <input type="number" placeholder="Prix des bagages" required class="name">
                    <i class="fa fa-money icon" aria-hidden="true"></i>
                </div>
            </div>
            <div class="input_group">
                <div class="input_box">
                    <input type="number" value="<?php echo $trajet ? $trajet['prix'] : ''; ?>" required class="name">
                    <i class="fa fa-money icon" aria-hidden="true"></i>
                </div>
            </div>
            <div class="input_group">
                <div class="input_box">
                    <input type="number" placeholder="Montant Net à Payer" required class="name">
                    <i class="fa fa-money icon" aria-hidden="true"></i>
                </div>
            </div>
          </form>
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
//echo Monetbil::js(true); ?>
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
    <script src="assets/js/main.js"></script>
    <style>
      .fa-ul input{
        width:1000px;
        border-radius: 10px;
        padding-left: 10px;
      }
      .fa-ul select{
        border-radius: 10px;
        padding-left: 10px;
      }
    </style>
</body>
</html>