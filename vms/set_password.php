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
$recovery_key = $new_password = $repeat_password = $errorMsg = $successMsg = "";
$isKeyValidated = false;
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  // storing value from form in local variables
  $recovery_key = $_POST["key"];
  $new_password = $_POST["new-password"];
  $repeat_password = $_POST["repeat-password"];

  // form validations
  // Create connection
  $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
  $sql = "SELECT * FROM user WHERE email = '".$_SESSION['email']."' AND recovery_key = ".$recovery_key;
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0)
  {
    $isKeyValidated = true;
  }
  else
  {
    $isKeyValidated = false;
  }
  mysqli_close($conn);

  if(strlen($recovery_key) != 6 || !is_numeric($recovery_key))
  {
    $errorMsg = "Invalid Key! Please check your recovery key.";
  }
  else if($new_password != $repeat_password)
  {
    $errorMsg = "Password doesn't match!";
  }
  else if($isKeyValidated == false)
  {
    $errorMsg = "Wrong Key! Please check your recovery key.";
  }
  else
  {
    // if data is validated then update password and reset recovery_key in database
    // Create connection
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $sql = "UPDATE user SET password = '".md5($new_password)."', recovery_key = 0 WHERE email = '".$_SESSION['email']."'";
    if(mysqli_query($conn, $sql))
    {
      $successMsg = "Password changed successfully!";
      ?>
      <script type="text/javascript">
        setTimeout("location.href = 'logout.php';",1000);
      </script>
      <?php
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
                  <input type="email" class="form-control" name="email" value = "<?php echo $_SESSION['email']; ?>" placeholder="Email" disabled>
                </div>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="key" placeholder="Recover Key" maxlength="6" required>
                </div>
                  <div class="col-md-12">
                    <input type="password" class="form-control" name="new-password" placeholder="New Password" required>
                  </div>
                    <div class="col-md-12">
                      <input type="password" class="form-control" name="repeat-password" placeholder="Repeat Password" required>
                    </div>
                <div class="col-md-12 text-center">
                  <button type="submit" name="generate-btn">Set New Password</button>
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
