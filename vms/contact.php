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
  $subject = $_POST["subject"];
  $message = $_POST["message"];

  date_default_timezone_set('Asia/Karachi');
  $currentDateTime = date('yy-m-d H:i:s', time());

  // Create connection
  $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
  $sql = "INSERT INTO contact_msg (name, email, subject, msg_body, msg_time, is_read)
  VALUES ('".$name."', '".$email."', '".$subject."', '".$message."', '".$currentDateTime."', 0)";
  if(mysqli_query($conn, $sql))
  {
    $successMsg = "Your message has been sent. Thank you!";
  }
  else
  {
    $errorMsg = mysqli_error($conn);
  }
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us | COVID-19 Vaccine Management System</title>
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
        <li>Contact</li>
      </ol>
      <h2>Contact</h2>
    </div>
  </section><!-- End Breadcrumbs -->

  <!-- Contact Section -->
  <section class="contact">
    <div class="container">
      <header class="section-header">
        <h2>Contact</h2>
        <p>Contact Us</p>
      </header>
      <div class="row gy-4">
          <div class="col-lg-6">
            <div class="row gy-4">
              <div class="col-md-6">
                <div class="info-box">
                  <i class="fa fa-map-marked"></i>
                  <h3>Address</h3>
                  <p>123, ABC Street<br>
                    Lahore, 54000</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="fa fa-phone"></i>
                  <h3>Call Us</h3>
                  <p>+92 042 1234567<br>
                    +92 300 1234567</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="fa fa-envelope"></i>
                  <h3>Email Us</h3>
                  <p>contact@vms.org.pk<br>info@vms.org.pk</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="fa fa-clock"></i>
                  <h3>Open Hours</h3>
                  <p>Monday - Friday<br>9:00AM - 05:00PM</p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <form action="" method="post" name="contact-form" class="php-email-form">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                </div>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required>
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
                  <button type="submit" name="msgBtn">Send Message</button>
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
