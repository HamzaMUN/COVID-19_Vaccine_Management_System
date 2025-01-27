<?php
//check if not logged in then redirect
session_start();
if($_SESSION['is_logged_in'] != true)
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
$old_password = $new_password = $repeat_password = $errorMsg = $successMsg = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  // storing value from form in local variables
  $old_password = $_POST["old-password"];
  $new_password = $_POST["new-password"];
  $repeat_password = $_POST["repeat-password"];

  // form validations
  if(md5($old_password) != $_SESSION['password'])
  {
    $errorMsg = "Please check your exisiting password!";
  }
  else if($new_password != $repeat_password)
  {
    $errorMsg = "Password doesn't match.";
  }
  else
  {
    // if data is validated then update it in database
    // Create connection
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $sql = "UPDATE user SET password = '".md5($new_password)."' WHERE user_id = ".$_SESSION['user_id'];
    if(mysqli_query($conn, $sql))
    {
      $successMsg = "Password is updated successfully!";
      $_SESSION["password"] = md5($new_password);
      ?>
      <script type="text/javascript">
        setTimeout("location.href = 'index.php';",1000);
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
  <title>Update Password | COVID-19 Vaccine Management System</title>
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
        <p>Update Password</p>
      </header>
      <div class="row gy-4 justify-content-center">
        <div class="col-lg-6">
            <form class="php-user-form" action="" method="post">
              <div class="row gy-4">
                <div class="col-md-12">
                  <input type="password" class="form-control" name="old-password" placeholder="Old Password" required>
                </div>
                <div class="col-md-12">
                  <input type="password" class="form-control" name="new-password" placeholder="New Password" required>
                </div>
                <div class="col-md-12">
                  <input type="password" class="form-control" name="repeat-password" placeholder="Repeat Password" required>
                </div>
                <div class="col-md-12 text-center">
                  <button type="submit" name="update-btn">Update</button>
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
