
<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    session_start();
    if (isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: welcome.php");
        die();
    }

    //Load Composer's autoloader
    require 'vendor/autoload.php';

    include 'config.php';
    $msg = "";

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($conn, $_POST['nom']);
        $surname = mysqli_real_escape_string($conn, $_POST['prenom']);
        $gender = mysqli_real_escape_string($conn, $_POST['sexe']);
        $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $adresse = mysqli_real_escape_string($conn, $_POST['adresse']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));
        $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
        $code = mysqli_real_escape_string($conn, md5(rand()));

        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM utilisateur WHERE email='{$email}'")) > 0) {
            $msg = "<div class='alert alert-danger'>{$email} - Cette adresse email existe.</div>";
        } else {
            if ($password === $confirm_password) {
                $sql = "INSERT INTO utilisateur (nom, prenom, sexe, telephone, email, adresse, password, code) VALUES ('{$name}', '{$surname}', '{$gender}', '{$telephone}', '{$email}', '{$adresse}', '{$password}', '{$code}')";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<div style='display: none;'>";
                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'elfriedfiona@gmail.com';                     //SMTP username
                        $mail->Password   = 'kqpgcqeucaxdshzy';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        //Recipients
                        $mail->setFrom('elfriedfiona@gmail.com');
                        $mail->addAddress($email);

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = 'Account Verification';
                        $mail->Body    = 'Here is the verification link <b><a href="http://localhost/taziya1/login&signup/?verification='.$code.'">http://localhost/emaillogsign/?verification='.$code.'</a></b>';

                        $mail->send();
                        echo 'Message a été envoyé';
                    } catch (Exception $e) {
                        echo "Message n'a pas été envoyé. Mailer Error: {$mail->ErrorInfo}";
                    }
                    echo "</div>";
                    $msg = "<div class='alert alert-info'>Nous avons envoyé le lien de vérification dans votre adresse mail</div>";
                } else {
                    $msg = "<div class='alert alert-danger'>Quelque chose est faux.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>mot de passe et confirmation mot de passe ne sont pas pareils</div>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  

  <!-- Favicons -->
  <link href="../assets/img/Agent Logo.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  
    <title>Login Form </title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>
<body>
    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center ">
    <div class="container-fluid container-xxl d-flex align-items-center">
        

      <div id="logo" class="me-auto">
        <!-- Uncomment below if you prefer to use a text logo -->
        <!-- <h1><a href="index.html">The<span>Event</span></a></h1>-->
        <a href="index.html" class="scrollto"><img src="../assets/img/Agent Logo.png" alt="" title="" height="500" width="100"></a>
      </div>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="../index.php">Accueil</a></li>
          <li><a class="nav-link scrollto" href="../#about">A propos</a></li>
          <li><a class="nav-link scrollto" href="../agence.php">Agence</a></li>
          <li><a class="nav-link scrollto" href="../tourisme.php">Tourisme</a></li>
          <li><a class="nav-link scrollto" href="../sponsor.php">Sponsors</a></li>
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
          <li><a class="nav-link scrollto" href="../forms/PHPMailer/contact.php">Contact</a></li>
          <li><a class="nav-link scrollto" href="login&signup/register.php">Connexion</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      <a class="buy-tickets scrollto" href="../reservation.php">Reservation</a>

    </div>
  </header><!-- End Header -->
  <script src="../assets/js/main.js"></script>
  <style>
    .d-flex{
      position:relative;
      background-color: MIDNIGHTBLUE;
    }
  </style><br><br>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close" style="background: MIDNIGHTBLUE;">
                        <span class="fa fa-close"></span>
                    </div>
                    <div class="w3l_form align-self" style="background: MIDNIGHTBLUE;">
                        <div class="left_grid_info">
                            <img src="images/image2.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Enregistrez vous</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="text" class="name" name="nom" placeholder="Entrez votre nom" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>" required>
                            <input type="text" class="name" name="prenom" placeholder="Entrez votre prénom" value="<?php if (isset($_POST['submit'])) { echo $surname; } ?>" required>
                            <select name="sexe" id="gender" class="name" required>
                                <option value="" >Genre...</option>
                                <option value="F">FEMME</option>
                                <option value="M">HOMME</option>
                            </select>
                            <input type="number" class="name" name="telephone" placeholder="Entrez votre numéro de téléphone" value="<?php if (isset($_POST['submit'])) { echo $telephone; } ?>" required>
                            <input type="email" class="email" name="email" placeholder="Entrez votre Email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                            <input type="text" class="name" name="adresse" placeholder="Entrez votre adresse" value="<?php if (isset($_POST['submit'])) { echo $adresse; } ?>" required>
                            <input type="password" class="password" name="password" placeholder="Entrez votre mot de passe" required>
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Confirmer votre mot de passe" required>
                            <button name="submit" class="btn" type="submit" style="background: MIDNIGHTBLUE;">S'inscrire</button>
                        </form>
                        <div class="social-icons">
                            <p>As-tu un compte?! <a href="index.php">Connectez-vous</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>
    <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-info">
            <img src="../assets/img/Agent Logo.png" alt="TheEvenet">
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
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
 <style>
  .w3l-mockup-form select {
    outline: none;
    margin-bottom: 15px;
    font-size: 16px;
    color: #5e5e5e;
    text-align: left;
    padding: 14px 20px;
    width: 100%;
    display: inline-block;
    box-sizing: border-box;
    border: none;
    outline: none;
    background: transparent;
    border: 1px solid #e5e5e5;
    transition: 0.3s all ease;
}

.w3l-mockup-form input:focus {
    border-color: MIDNIGHTBLUE;
}
 </style>
</body>

</html>