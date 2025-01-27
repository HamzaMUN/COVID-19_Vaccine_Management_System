<?php
session_start();
// including database credentials
// for the purpose of sequrity database credentials file is put out of apache public_html directory
include_once('../vms_connection.php');
// php code to validate form and insert data in database on valid values
$name = $email = $subject = $message = $errorMsg = $successMsg = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  // storing value from form in local variables
  $name = $_POST["name"];
  $email = $_POST["email"];
  $rating = $_POST["rating"];
  $message = $_POST["message"];

  date_default_timezone_set('Asia/Karachi');
  $currentDateTime = date('yy-m-d H:i:s', time());

  if(!is_numeric($rating) || $rating < 0 || $rating > 10)
  {
    $errorMsg = "Please enter a valid value of rating. i.e. 0 to 10";
  }
  else
  {
    // Create connection
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $sql = "INSERT INTO feedback (name, email, rating, feedback_msg, feedback_time, is_read)
    VALUES ('".$name."', '".$email."', '".$rating."', '".$message."', '".$currentDateTime."', 0)";
    if(mysqli_query($conn, $sql))
    {
      $successMsg = "Thank you for submitting your feedback. Your feedback helps us to improve!";
    }
    else
    {
      $errorMsg = mysqli_error($conn);
    }
    mysqli_close($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback | COVID-19 Vaccine Management System</title>
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
        <li>Feedback</li>
      </ol>
      <h2>Feedback</h2>
    </div>
  </section><!-- End Breadcrumbs -->

  <!-- Contact Section -->
  <section class="contact">
    <div class="container">
      <header class="section-header">
        <h2>Feedback</h2>
        <p>Give Feedback</p>
      </header>
      <div class="row gy-4">

          <div class="col-lg-12">
            <form action="" method="post" name="feedback-form" class="php-email-form">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                </div>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="rating" placeholder="Rating out of 10" required>
                </div>
                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                </div>
                <div class="col-md-12 text-center">
                  <?php if(!empty($successMsg)){?>
                    <div class="sent-message"><?php echo $successMsg; ?></div>
                  <?php } elseif(!empty($errorMsg)){?>
                    <div class="error-message"><?php echo $errorMsg; ?></div>
                  <?php }?>
                  <button type="submit" name="msgBtn">Submit Feedback</button>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>
  </section><!-- End Contact Section -->
  <?php include_once('includes/footer.php') ?>
  <!-- Javascript Files -->
  <!-- Bootstrap -->
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
