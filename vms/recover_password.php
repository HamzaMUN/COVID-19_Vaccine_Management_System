<?php
//check if not logged in then redirect
session_start();
if($_SESSION['is_logged_in'] == true)
{
  ?>
  <script type="text/javascript">
    setTimeout("location.href = 'index.php';",500);
  </script>
  <?php
}
else
{
// including database credentials
// for the purpose of sequrity database credentials file is put out of apache public_html directory
include_once('../vms_connection.php');
// php code to validate form and update data in database on valid values
$email = $errorMsg = $successMsg = "";
$isRegistered = false;
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  // storing value from form in local variables
  $email = $_POST["email"];

  // form validations
  // Create connection
  $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
  $sql = "SELECT * FROM user WHERE email = '".$email."'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0)
  {
    $isRegistered = true;
  }
  else
  {
    $isRegistered = false;
  }
  mysqli_close($conn);

  if($isRegistered == false)
  {
    $errorMsg = "User with this email is not registered.";
  }
  else
  {
    // if data is validated then update recovery_key in database and send it in email
    // Create connection
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $random_key = random_int(100000, 999999);
    $sql = "UPDATE user SET recovery_key = '".$random_key."' WHERE email = '".$email."'";
    if(mysqli_query($conn, $sql))
    {
      //php mail function to send random key in email
      $to = $email;
      $subject = "Recover Password | COVID-19 Vaccine Management System";
      $message = "Your recovery key is: ".$random_key;
      $from = "no-reply@vms";
      if(mail($to, $subject, $message, $from))
      {
        $successMsg = "Recovery key is sent successfully! Please check your inbox.";
        $_SESSION['email'] = $email;
      ?>
      <script type="text/javascript">
        setTimeout("location.href = 'set_password.php';",1000);
      </script>
      <?php
      }
      else
      {
        $errorMsg = "An error occurred while sending email!";
      }
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
  <title>Recover Password | COVID-19 Vaccine Management System</title>
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
  <!-- Signup Section -->
  <section class="user-form">
    <div class="container">
      <header class="section-header">
        <h2>Covid-19 Vaccine Management System</h2>
        <p>Recover Password</p>
      </header>
      <div class="row gy-4 justify-content-center">
        <div class="col-lg-6">
            <form class="php-user-form" action="" method="post">
              <div class="row gy-4">
                <div class="col-md-12">
                  <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="col-md-12 text-center">
                  <button type="submit" name="generate-btn">Generate Recovery Code</button>
                </div>
                <p>
                  <a href="index.php" class="right">Go back to home</a>
                </p>
                  <?php
                  if(!empty($errorMsg))
                  {
                    echo '<div class="error-message"><p>'.$errorMsg.'</p></div>';
                  }
                  if(!empty($successMsg))
                  {
                    echo '<div class="success-message"><p>'.$successMsg.'</p></div>';
                  }
                  ?>
              </div>
            </form>
        </div>
      </div>
    </div>
  </section><!-- End Signup Section -->
  <!-- Javascript Files -->
  <!-- Bootstrap -->
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
<?php } ?>
