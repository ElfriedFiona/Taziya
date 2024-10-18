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
    <!-- ======= Gallery Section ======= -->
    <section id="gallery">

      <div class="container" data-aos="fade-up">
        <div class="section-header">
          <h2>Tourisme</h2>
          <p>Decouvrez les nombreuses lieux touristiques</p>
        </div>
      </div>

      <div class="gallery-slider swiper">
        <div class="swiper-wrapper align-items-center">
          <div class="swiper-slide"><a href="tourisme/cmr1.php" class="gallery-lightbox"><img src="assets/img/gallery/cmr1.jpeg" class="img-fluid" alt=""></a></div>
          <div class="swiper-slide"><a href="tourisme/cmr2.jpeg" class="gallery-lightbox"><img src="assets/img/gallery/cmr2.jpeg" class="img-fluid" alt=""></a></div>
          <div class="swiper-slide"><a href="tourisme/kribi.php" class="gallery-lightbox"><img src="assets/img/gallery/lobe.jpeg" class="img-fluid" alt=""></a></div>
          <div class="swiper-slide"><a href="tourisme/nv1.php" class="gallery-lightbox"><img src="assets/img/gallery/nv1.jpg" class="img-fluid" alt=""></a></div>
          <div class="swiper-slide"><a href="tourisme/nv2.php" class="gallery-lightbox"><img src="assets/img/gallery/nv2.jpg" class="img-fluid" alt=""></a></div>
          <div class="swiper-slide"><a href="tourisme/nv3.php" class="gallery-lightbox"><img src="assets/img/gallery/nv3.jpg" class="img-fluid" alt=""></a></div>
          <div class="swiper-slide"><a href="tourisme/nv4.php" class="gallery-lightbox"><img src="assets/img/gallery/nv4.jpg" class="img-fluid" alt=""></a></div>
          <div class="swiper-slide"><a href="tourisme/nv5.php" class="gallery-lightbox"><img src="assets/img/gallery/nv5.jpg" class="img-fluid" alt=""></a></div>
        </div>
        <div class="swiper-pagination"></div>
      </div>

    </section><!-- End Gallery Section -->
      <!-- ======= Footer ======= -->
  <?php 
   include 'footer.php';
  ?>
<!-- End Venue Section -->
    <script src="assets/js/main.js"></script>
    <style>
      #gallery{
        margin-top:50px;
      }
    </style>
</body>
</html>