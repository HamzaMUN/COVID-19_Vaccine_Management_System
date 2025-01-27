<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vaccine Procedure | COVID-19 Vaccine Management System</title>
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
  <?php include_once('includes/header.php') ?>

  <!-- Breadcrumbs -->
  <section class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="index.php">Home</a></li>
        <li>Vaccine Procedure</li>
      </ol>
      <h2>Vaccine Procedure</h2>
    </div>
  </section><!-- End Breadcrumbs -->

  <!-- Vaccine Procedure Section -->
  <section class="appointment">
    <div class="container">
      <header class="section-header">
        <h2>Vaccine Procedure</h2>
        <p>Read vaccination procedure to get vaccinated</p>
      </header>
      <div class="row">
        <div class="col-lg-4">
          <div class="box">
            <img src="assets/img/appointment-1.png" alt="">
            <h3>Step 1. Request for appointment</h3>
            <p>Login with your patient account and request for appointment.</p>
          </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="box">
            <img src="assets/img/appointment-2.png" alt="">
            <h3>Step 2. Review of request by an admin</h3>
            <p>Your appointment request will be reviewed by admins and you get appointment scheduled.</p>
          </div>
        </div>
        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="box">
            <img src="assets/img/appointment-3.png" alt="">
            <h3>Step 3. Get email with appointment details</h3>
            <p>Check your appointment details from email from this page and follow instructions.</p>
          </div>
        </div>
      </div>
    </div>
  </section><!-- End Vaccine Procedure Section -->
  <?php include_once('includes/footer.php') ?>
  <!-- Javascript Files -->
  <!-- Bootstrap -->
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
