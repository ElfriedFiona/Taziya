<!DOCTYPE html>

<html lang="en" data-bs-theme="auto">

<head><script src="../assets/js/color-modes.js"></script>
<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TAZIYA</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../../assets/img/Agent Logo.png" rel="icon">
  <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../../assets/css/style.css" rel="stylesheet">
  <style>
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
        }
 
        .container2 {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label,
        input {
            display: block;
            width: 80%;
            margin-bottom: 10px;
        }
        textarea {
            display: block;
            width: 80%;
            margin-bottom: 5px;
        }
        input[type="submit"],
        .btn {
            background-color: blue; /* Couleur bleue */
            color: white; /* Texte en blanc */
            border: none;
            padding: 10px;
            border-radius: 30px;
            cursor: pointer;
            margin-top: 10px;
            float: right; /* Aligner à droite */
        }

    </style>
    
</head>

<body>
<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center ">
    <div class="container-fluid container-xxl d-flex align-items-center">
        

      <div id="logo" class="me-auto">
        <!-- Uncomment below if you prefer to use a text logo -->
        <!-- <h1><a href="index.html">The<span>Event</span></a></h1>-->
        <a href="index.html" class="scrollto"><img src="../../assets/img/Agent Logo.png" alt="" title="" height="500" width="100"></a>
      </div>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="../../index.php">Accueil</a></li>
          <li><a class="nav-link scrollto" href="../../#about">A propos</a></li>
          <li><a class="nav-link scrollto" href="../../agence.php">Agence</a></li>
          <li><a class="nav-link scrollto" href="../../tourisme.php">Tourisme</a></li>
          <li><a class="nav-link scrollto" href="../../sponsor.php">Sponsors</a></li>
          <!-- <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="#">Drop Down 1</a></li>
            <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
              <ul>
                <li><a href="#">Deep Drop Down 1</a></li>
                <li><a href="#">Deep Drop Down 2</a></li>
                <li><a href="#">Deep Drop Down 3</a></li>
                <li><a href="#">Deep Drop Down 4</a></li>
                <li><a href="#">Deep Drop Down 5</a></li>
              </ul>
            </li>
            <li><a href="#">Drop Down 2</a></li>
            <li><a href="#">Drop Down 3</a></li>
            <li><a href="#">Drop Down 4</a></li>
          </ul>
        </li> -->
          <li><a class="nav-link scrollto" href="contact.php">Contact</a></li>
          <li><a class="nav-link scrollto" href="../../login&signup/register.php">Connexion</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      <a class="buy-tickets scrollto" href="../../reservation.php">Reservation</a>

    </div>
  </header><!-- End Header -->
  <script src="../../assets/js/main.js"></script>
  <style>
    .d-flex{
      position:relative;
      background-color: MIDNIGHTBLUE;
    }
  </style>
    </div><br>

    <div class="container2">

        <h2 style="text-align: center;">Envoyez nous un message</h2><br>

        <form id="loginForm" action="mail.php" method="POST">

            <label for="fullName">Nom Complet:</label>
            <input type="text" id="fullName" name="name" required autocomplete="off"><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required autocomplete="off"><br>

            <label for="message">Objet:</label>
            <textarea id="text" name="subject" required autocomplete="off" rows="4"></textarea>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required autocomplete="off" rows="8"></textarea>

            
            <button type="submit" name="send" class="btn btn-primary">Submit Now</button><br><br>
        </form>

    </div>
    <!-- FOOTER -->
    </section><!-- End Contact Section -->
    <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-info">
            <img src="../../assets/img/Agent Logo.png" alt="Taziyat">
            <p>TAZIYA est une plateforme de réservation de ticket de bus plus précissement à Douala.</p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Liens</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Accueil</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">A propos</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-contact">
            <h4>Contactez-nous</h4>
            <p>
              Douala-Cameroon<br>
              <strong>Tel:</strong> +237 655-061-618<br>
              <strong>Email:</strong>Ndymany15@gmail.com<br>
            </p>

            <div class="social-links">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>

          </div>

        </div>
      </div>
    </div>

    
</footer><!-- End  Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/aos/aos.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../../assets/js/main.js"></script>
<!-- End Venue Section -->
    <script src="../../assets/js/main.js"></script>
    <style>
      .container2{
        margin-top:100px;
      }
    </style>
    <div id="messageConfirmation"></div> <!-- Affichage du message de confirmation -->
</body>

</html>
