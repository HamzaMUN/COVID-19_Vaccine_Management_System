<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About | COVID-19 Vaccine Management System</title>
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

  <!-- Breadcrumbs -->
  <section class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="index.php">Home</a></li>
        <li>About Us</li>
      </ol>
      <h2>About Us</h2>
    </div>
  </section><!-- End Breadcrumbs -->

  <!-- Start About -->
  <section class="about">
    <div class="container">
      <div class="row gx-0">
        <div class="col-lg-6 d-flex flex-column justify-content-center">
          <div class="content">
            <h3>What is COVID-19 VMS</h3>
            <h2>“COVID-19 Vaccine Management System” is an appointment scheduling system to facilitate the residents with scheduling their COVID-19 vaccine appointments.</h2>
            <p>
              The aim of this website is to manage mass vaccination, including vaccine distribution and administration. This system contains the information regarding COVID-19 virus, how it spreads, and it also provides preventive measure that individuals can take in their homes and workplaces.
            </p>
          </div>
        </div>
        <div class="col-lg-6 d-flex align-items-center">
          <img src="assets/img/about.jpg" class="img-fluid" alt="">
        </div>
      </div>
    </div>
  </section><!-- End About Section -->

  <?php include_once('includes/footer.php') ?>
  <!-- Javascript Files -->
  <!-- Bootstrap -->
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
