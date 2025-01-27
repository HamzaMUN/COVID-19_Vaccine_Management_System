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
// php code to validate form and insert data in database on valid values
$cnic = $name = $dob = $city = $email = $password = $password2 = $errorMsg = $successMsg = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  // storing value from form in local variables
  $cnic = $_POST["cnic"];
  $name = $_POST["name"];
  $dob = $_POST["dob"];
  $city = $_POST["city"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $password2 = $_POST["password2"];
  $isAlreadyRegistered = false;

  // form validations
  // Create connection
  $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
  $sql = "SELECT * FROM user WHERE cnic = ".$cnic." OR email = '".$email."'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0)
  {
    $isAlreadyRegistered = true;
  }
  else
  {
    $isAlreadyRegistered = false;
  }
  mysqli_close($conn);

  if(strlen($cnic) != 13 || !is_numeric($cnic))
  {
    $errorMsg = "Please check your CNIC";
  }
  else if(!checkdate(substr($dob, 5, 2), substr($dob, 8, 2), substr($dob, 0, 4)))
  {
    $errorMsg = "Please enter a valid date of birth";
  }
  else if($password != $password2)
  {
    $errorMsg = "Password doesn't match";
  }
  else if($isAlreadyRegistered)
  {
    $errorMsg = "User with this email or CNIC is already registered";
  }
  else
  {
    // if data is validated then insert it in database
    // Create connection
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $sql = "INSERT INTO user (cnic, password, full_name, email, city, dob, user_type, vaccine_status)
    VALUES (".$cnic.",'".md5($password)."', '".$name."', '".$email."', '".$city."', '".$dob."', 'patient', 'Not Vaccinated'".")";
    if(mysqli_query($conn, $sql))
    {
      $successMsg = "User account created successfully. You will be redirected to login page";
      ?>
      <script type="text/javascript">
        setTimeout("location.href = 'login.php';",1000);
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
  <title>Patient Registration | COVID-19 Vaccine Management System</title>
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
        <p>Patient Registration</p>
      </header>
      <div class="row gy-4 justify-content-center">
        <div class="col-lg-6">
            <form class="php-user-form" action="" method="post">
              <div class="row gy-4">
                <div class="col-md-12">
                  <input type="text" class="form-control" name="cnic" placeholder="CNIC (without dashes)" required>
                </div>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                </div>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="dob" placeholder="Date of Birth (yyyy-mm-dd)" required>
                </div>
                <div class="col-md-12">
                  <input type="text" class="form-control" name="city" placeholder="City" required>
                </div>
                <div class="col-md-12">
                  <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="col-md-12">
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="col-md-12">
                  <input type="password" class="form-control" name="password2" placeholder="Confirm Password" required>
                </div>
                <div class="col-md-12 text-center">
                  <button type="submit" name="submit-btn">Register</button>
                </div>
                <p>
                  <a href="login.php">Already registered? Login now</a>
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
