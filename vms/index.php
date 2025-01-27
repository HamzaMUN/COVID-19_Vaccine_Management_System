<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | COVID-19 Vaccine Management System</title>
  <link href="assets/img/favicon.png" rel="icon">
  <!-- Bootstrap -->
  <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  <!-- Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
  <?php include_once('includes/header.php'); ?>

  <!-- Start Banner -->
  <section class="banner d-flex align-items-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center">
          <h1>COVID-19 Situation!</h1>
          <h2>The coronavirus, or COVID-19, is inciting panic for a number of reasons. It's a new virus, meaning no one has immunity. It is highly contagious, meaning it spreads fast. Its novelty means that scientists aren't completely sure as to how it behaves since they have very little history to go on.</h2>
          <div>
            <div class="text-center text-lg-start">
              <a href="appointment.php" class="btn-schedule-appointment d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Schedule Appointment</span>
                <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 banner-img">
          <img src="assets/img/header-img.png" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </section><!-- End Banner -->

  <?php include_once('includes/footer.php') ?>
  <!-- Javascript Files -->
  <!-- Bootstrap -->
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
