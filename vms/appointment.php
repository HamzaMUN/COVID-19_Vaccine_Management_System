<?php
//check if already logged in then redirect
session_start();

// including database credentials
// for the purpose of sequrity database credentials file is put out of apache public_html directory
include_once('../vms_connection.php');

// php code to insert data in database
$errorMsg = $successMsg = "";
date_default_timezone_set('Asia/Karachi');
$currentDateTime = date('yy-m-d H:i:s', time());
$isAlreadySubmitted = false;
$isAccepted = false;
// Create connection
$conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
$sql = "SELECT * FROM appointment_request WHERE user_id = ".$_SESSION["user_id"];
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
  while($row = mysqli_fetch_assoc($result))
  {
    $request_id = $row["request_id"];
    $vaccine_status = $row["status"];
    switch ($vaccine_status)
    {
      case 'pending':
        $isAlreadySubmitted = true;
        $errorMsg = "Your request has already submitted and is under review. You will receive a response shortly!";
        break;

      case 'rejected':
        $isAlreadySubmitted = true;
        $errorMsg = "Your request has already submitted and is rejected. Please check your email for details.";
        break;
      case 'approved':
        $isAccepted = true;
        $isAlreadySubmitted = true;
        $errorMsg = 'Your appointment has been already scheduled. <a href="appointment_form.php?r='.$request_id.'">Click here</a> to generate your appointment form.';
        break;

      default:
        $isAlreadySubmitted = true;
        break;
    }
  }
}
else
{
  $isAlreadySubmitted = false;
}
mysqli_close($conn);
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  if(!$isAlreadySubmitted)
  {
    // Create connection
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $sql = "INSERT INTO appointment_request (user_id, request_time, status)
    VALUES (".$_SESSION['user_id'].", '".$currentDateTime."', 'pending')";
    if(mysqli_query($conn, $sql))
    {
      $successMsg = "Appointment request has been submitted successfully! You will receive an email regarding your appointment status.";
      ?>
      <script type="text/javascript">
        setTimeout("location.href = 'index.php';",5000);
      </script>
      <?php
    }
    else
    {
      $errorMsg = mysqli_error($conn);
    }
    mysqli_close($conn);
  }
  else
  {
    $errorMsg = "Your request has already submitted and is under review. You will receive a response shortly!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedule Appointment | COVID-19 Vaccine Management System</title>
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
        <li>Schedule Appointment</li>
      </ol>
      <h2>Schedule Appointment</h2>
    </div>
  </section><!-- End Breadcrumbs -->

  <!-- Appointment Section -->
  <section class="appointment">
    <div class="container">
      <header class="section-header">
        <h2>Schedule Appointment</h2>
        <p>Schedule an appointment to get vaccinated</p>
      </header>
      <?php
        if($_SESSION["is_logged_in"])
        {
       ?>
      <div class="row">
        <?php
          if(!empty($errorMsg))
          {
            echo "<h4>".$errorMsg."</h4>";
          }
          if(!empty($successMsg))
          {
            echo "<h4>".$successMsg."</h4>";
          }
        ?>
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
      <?php
      if($_SESSION["vaccine_status"] == "Fully Vaccinated")
      {
      echo "<h4>Dear Patient! You are already fully vaccinated.</h4>";
      }
      else if($isAlreadySubmitted == true)
      {

      }
      else
      {
      ?>
      <div class="col-md-12 submit text-center">
        <form method="post" action="">
        <button type="submit" name="appointment-btn">Submit Request</button>
        </form>
      </div>
    <?php
      }
    }
    else
    {?>
      <p class="text-center">Please login to continue scheduling an appointment. <a href="login.php">Click here </a> to login.</p>
    <?php
    }
    ?>
    </div>
  </section><!-- End Appointment Section -->
  <?php include_once('includes/footer.php') ?>
  <!-- Javascript Files -->
  <!-- Bootstrap -->
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
