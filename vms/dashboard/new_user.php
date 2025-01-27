<?php
// including database credentials
// for the purpose of sequrity database credentials file is put out of apache public_html directory
include_once('../../vms_connection.php');
//check if not logged in then redirect
session_start();
if($_SESSION['is_logged_in'] != true)
{
?>
  <script type="text/javascript">
    setTimeout("location.href = '../index.php';",500);
  </script>
<?php
}
else
{
  if($_SESSION['user_type'] != 'admin')
  {
  ?>
  <script type="text/javascript">
    setTimeout("location.href = '../index.php';",500);
  </script>
  <?php
  }
  else
  {
    // Add new center
    $cnic = $password = $full_name = $email = $city = $dob = $user_type = $vaccine_status = $errorMsg = $successMsg = "";
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      // storing value from form in local variables
      $cnic = $_POST["cnic"];
      $password = $_POST["password"];
      $password2 = $_POST["password2"];
      $full_name = $_POST["name"];
      $email = $_POST["email"];
      $city = $_POST["city"];
      $dob = $_POST["dob"];
      $user_type = $_POST["user-type"];
      $vaccine_status = $_POST["vaccine-status"];
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
        // Create connection
        $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
        $sql = "INSERT INTO user (cnic, password, full_name, email, city, dob, user_type, vaccine_status)
        VALUES (".$cnic.", '".md5($password)."', '".$full_name."', '".$email."', '".$city."', '".$dob."', '".$user_type."', '".$vaccine_status."')";
        if(mysqli_query($conn, $sql))
        {
          $successMsg = "User added successfully. You will be redirected shortly!";
          ?>
          <script type="text/javascript">
            setTimeout("location.href = 'users.php';",500);
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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New User | COVID-19 Vaccine Management System</title>
  <link href="../assets/img/favicon.png" rel="icon">
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="css/dashboard.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
  <div id="wrapper">
      <?php include_once('includes/navigation.php'); ?>
      <div id="page-wrapper">
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="row">
            <div class="col-lg-12">
              <h1 class="page-header">Add New User</h1>
              <ol class="breadcrumb">
                <li>
                  <i class="fa fa-tachometer"></i> <a href="index.php">Dashboard</a>
                </li>
                <li>
                  <i class="fa fa-user"></i> <a href="users.php">Users Administration</a>
                </li>
                <li class="active">
                  <i class="fa fa-plus"></i> Add New User
                </li>
              </ol>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
                <form action="" method="post">
                  <div class="form-group">
                    <input class="form-control" type="text" name="cnic" placeholder="CNIC (without dashes)" required />
                  </div>
                  <div class="form-group">
                  <input class="form-control" type="text" name="name" placeholder="Full Name" required />
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" name="dob" placeholder="Date of Birth (yyyy-mm-dd)" required />
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" name="city" placeholder="City" required />
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" name="email" placeholder="Email" required />
                  </div>
                  <div class="form-group">
                    <span>User Type: </span>
                  </div>
                  <div class="form-group">
                    <select name="user-type" class="form-control">
                      <option value="admin">Administrator</option>
                      <option value="patient">Patient</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <span>Vaccination Status: </span>
                  </div>
                  <div class="form-group">
                    <select name="vaccine-status" class="form-control">
                      <option value="Fully Vaccinated">Fully Vaccinated</option>
                      <option value="Partially Vaccinated">Partially Vaccinated</option>
                      <option value="Not Vaccinated">Not Vaccinated</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="Password" required />
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="password" name="password2" placeholder="Confirm Password" required />
                  </div>
                  <div class="form-group">
                    <button class="btn btn-danger" type="submit" name="add-user">Add New</button>
                  </div>
                </form>
                <?php
                if(!empty($successMsg))
                {
                ?>
                  <div class="alert alert-success"><?php echo $successMsg; ?></div>
                <?php
                }
                if(!empty($errorMsg))
                {
                ?>
                  <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
                <?php
                }
                ?>

            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /#page-wrapper -->
  </div>
  <!-- /#wrapper -->
  <!-- Javascript Files -->
  <!-- jQuery -->
  <script src="js/jquery.js"></script>
  <!-- Bootstrap Core JavaScript -->
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
  }
}
?>
