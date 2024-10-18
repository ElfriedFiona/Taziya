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
    
   <div class="agence">
      <ul class="contacts">
        <li class="contact">
            <img src="https://via.placeholder.com/50" alt="Contact Image">
            <div>
                <div class="name">MEN TRAVEL</div>
            </div>
        </li>
        <li class="contact">
            <img src="https://via.placeholder.com/50" alt="Contact Image">
            <div>
                <div class="name">TOURISTIQUE</div>
            </div>
        </li>
        <li class="contact">
            <img src="https://via.placeholder.com/50" alt="Contact Image">
            <div>
                <div class="name">BUCA VOYAGE</div>
            </div>
        </li>
        <!-- Ajouter d'autres contacts ici -->
    </ul>
   </div>

      <!-- ======= Footer ======= -->
  <?php 
   include 'footer.php';
  ?>
 

<!-- End Venue Section -->
    <script src="assets/js/main.js"></script>
    <style>
        body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }

    .contacts {
        list-style-type: none;
        padding: 0;
        margin: 0;
        margin-top: 100px;
    }

    .contact {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #ccc;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .contact img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }
    .contact .name {
        font-weight: bold;
    }

    .contact .message {
        color: #888;
    }

    </style>
</body>
</html>