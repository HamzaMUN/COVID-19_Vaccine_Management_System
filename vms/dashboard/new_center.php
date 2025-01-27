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
    $center_name = $province = $district = $tehsil = $address = $contact = $errorMsg = $successMsg = "";
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      // storing value from form in local variables
      $center_name = $_POST["center-name"];
      $province = $_POST["province"];
      $district = $_POST["district"];
      $tehsil = $_POST["tehsil"];
      $address = $_POST["address"];
      $contact = $_POST["contact"];
      // Create connection
      $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
      $sql = "INSERT INTO center (center_name, province, district, tehsil, address, contact)
      VALUES ('".$center_name."', '".$province."', '".$district."', '".$tehsil."', '".$address."', '".$contact."')";
      if(mysqli_query($conn, $sql))
      {
        $successMsg = "Center added successfully. You will be redirected shortly!";
        ?>
        <script type="text/javascript">
          setTimeout("location.href = 'centers.php';",500);
        </script>
        <?php
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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add New Center | COVID-19 Vaccine Management System</title>
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
              <h1 class="page-header">Add New Center</h1>
              <ol class="breadcrumb">
                <li>
                  <i class="fa fa-tachometer"></i> <a href="index.php">Dashboard</a>
                </li>
                <li>
                  <i class="fa fa-hospital"></i> <a href="centers.php">Vaccination Centers</a>
                </li>
                <li class="active">
                  <i class="fa fa-plus"></i> Add New Center
                </li>
              </ol>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
                <form action="" method="post">
                  <div class="form-group">
                    <input class="form-control" type="text" name="center-name" placeholder="Center Name" required />
                  </div>
                  <div class="form-group">
                  <input class="form-control" type="text" name="province" placeholder="Province" required />
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" name="district" placeholder="District" required />
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" name="tehsil" placeholder="Tehsil" required />
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" name="address" placeholder="Address" required />
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" name="contact" placeholder="Contact" required />
                  </div>
                  <div class="form-group">
                    <button class="btn btn-danger" type="submit" name="add-center">Add New</button>
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
