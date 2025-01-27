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
    // Add new vaccine
    $vaccine_title = $dosage_count = $second_dose = $vendor_name = $errorMsg = $successMsg = "";
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      // storing value from form in local variables
      $vaccine_title = $_POST["vaccine-title"];
      $dosage_count = $_POST["dose-count"];
      $second_dose = $_POST["second-dose"];
      $vendor_name = $_POST["vendor-name"];
      // Create connection
      $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
      $sql = "INSERT INTO vaccine (vaccine_title, dose_count, second_dose, vendor_name)
      VALUES ('".$vaccine_title."', '".$dosage_count."', '".$second_dose."', '".$vendor_name."')";
      if(mysqli_query($conn, $sql))
      {
        $successMsg = "Vaccine added successfully. You will be redirected shortly!";
        ?>
        <script type="text/javascript">
          setTimeout("location.href = 'vaccines.php';",500);
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
  <title>Add New Vaccine | COVID-19 Vaccine Management System</title>
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
              <h1 class="page-header">Add New Vaccine</h1>
              <ol class="breadcrumb">
                <li>
                  <i class="fa fa-tachometer"></i> <a href="index.php">Dashboard</a>
                </li>
                <li>
                  <i class="fa fa-syringe"></i> <a href="vaccines.php">Vaccines</a>
                </li>
                <li class="active">
                  <i class="fa fa-plus"></i> Add New Vaccine
                </li>
              </ol>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
                <form action="" method="post">
                  <div class="form-group">
                    <input class="form-control" type="text" name="vaccine-title" placeholder="Vaccine Title" required />
                  </div>
                  <div class="form-group">
                  <input class="form-control" type="text" name="dose-count" placeholder="No. of dosage" required />
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" name="second-dose" placeholder="Second Dose (after)" required />
                  </div>
                  <div class="form-group">
                    <input class="form-control" type="text" name="vendor-name" placeholder="Vendor Name" required />
                  </div>
                  <div class="form-group">
                    <button class="btn btn-danger" type="submit" name="add-vaccine">Add New</button>
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
