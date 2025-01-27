<?php
//check if already logged in then redirect
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

// php code to authenticate form and start session on authentication
$cnic = $password = $errorMsg = $successMsg = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  // storing value from form in local variables
  $cnic = $_POST["cnic"];
  $password = $_POST["password"];

  // authenticating user credentials
  // Create connection
  $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
  $sql = "SELECT * FROM user WHERE cnic = ".$cnic." AND password = '".md5($password)."'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0)
  {
    $isAuthenticated = true;
    while($row = mysqli_fetch_assoc($result))
    {
      $_SESSION["is_logged_in"] = true;
      $_SESSION["user_id"] = $row["user_id"];
      $_SESSION["cnic"] = $row["cnic"];
      $_SESSION["password"] = $row["password"];
      $_SESSION["full_name"] = $row["full_name"];
      $_SESSION["email"] = $row["email"];
      $_SESSION["city"] = $row["city"];
      $_SESSION["dob"] = $row["dob"];
      $_SESSION["user_type"] = $row["user_type"];
      $_SESSION["vaccine_status"] = $row["vaccine_status"];
    }
  }
  else
  {
    $isAuthenticated = false;
  }
  mysqli_close($conn);

  if(strlen($cnic) != 13 || !is_numeric($cnic))
  {
    $errorMsg = "Please check your CNIC";
  }
  else if(!$isAuthenticated)
  {
    $errorMsg = "Please check your CNIC and password!";
  }
  else
  {
    $successMsg = "You are logged in successfully. You will be redirected soon.";
    // redirecting user to dashboard or home page depending on user_type
    switch($_SESSION["user_type"])
    {
      case "admin":
      {
        ?>
        <script type="text/javascript">
          setTimeout("location.href = 'dashboard/index.php';",1000);
        </script>
        <?php
        break;
      }
      case "patient":
      {
        ?>
        <script type="text/javascript">
          setTimeout("location.href = 'index.php';",1000);
        </script>
        <?php
        break;
      }
      default:
      {
        ?>
        <script type="text/javascript">
          setTimeout("location.href = 'index.php';",1000);
        </script>
        <?php
        break;
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | COVID-19 Vaccine Management System</title>
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
  <!-- Login Section -->
  <section class="user-form">
    <div class="container">
      <header class="section-header">
        <h2>Covid-19 Vaccine Management System</h2>
        <p>Login</p>
      </header>
      <div class="row gy-4 justify-content-center">
        <div class="col-lg-6">
            <form class="php-user-form" method="post" action="">
              <div class="row gy-4">
                <div class="col-md-12">
                  <input type="text" name="cnic" class="form-control" placeholder="CNIC (without dashes)" required>
                </div>
                <div class="col-md-12">
                  <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <p><a href="recover_password.php">Forgot your password?</a></p>
                <div class="col-md-12 text-center">
                  <button type="submit" name="login-btn">Login</button>
                </div>
                <p>
                  <a href="signup.php">Not registered? Register now</a>
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
  </section><!-- End Login Section -->
  <!-- Javascript Files -->
  <!-- Bootstrap -->
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
<?php } ?>
