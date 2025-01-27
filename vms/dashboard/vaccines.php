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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vaccines | COVID-19 Vaccine Management System</title>
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
              <h1 class="page-header">Vaccines</h1>
              <ol class="breadcrumb">
                <li>
                  <i class="fa fa-tachometer"></i> <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <i class="fa fa-syringe"></i> Vaccines
                </li>
              </ol>
            </div>
          </div>
          <div class="row" style="margin-bottom:20px;">
            <div class="col-lg-12">
              <a class="btn btn-danger" href="new_vaccine.php"><i class="fa fa-plus"></i> Add New Vaccine</a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                  <?php
                  // Create connection
                  $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                  $sql = "SELECT * FROM vaccine ORDER BY vaccine_id ASC";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0)
                  {
                  ?>
                  <table class="table table-bordered table-hover table-striped">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Vaccine ID</th>
                              <th>Vaccine Title</th>
                              <th>No. of Dosage</th>
                              <th>Second Dose</th>
                              <th>Vendor Name</th>
                              <th style="text-align: center;" colspan="2">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                  <?php
                    $serial_no = 1;
                    while($row = mysqli_fetch_assoc($result))
                    {
                      $vaccine_id  = $row["vaccine_id"];
                      $vaccine_title = $row["vaccine_title"];
                      $dose_count = $row["dose_count"];
                      $second_dose = $row["second_dose"];
                      $vendor_name = $row["vendor_name"];
                    ?>
                    <form action="update_vaccine.php" method="post">
                      <tr>
                        <input type="hidden" name="vaccine-id" value="<?php echo $vaccine_id; ?>">
                        <td><?php echo $serial_no; ?></td>
                        <td><?php echo $vaccine_id; ?></td>
                          <td>
                            <input type="text" name="vaccine-title" value="<?php echo $vaccine_title; ?>" required />
                          </td>
                          <td>
                            <input type="text" name="dose-count" value="<?php echo $dose_count; ?>" required />
                          </td>
                          <td>
                            <input type="text" name="second-dose" value="<?php echo $second_dose; ?>" required />
                          </td>
                          <td>
                            <textarea name="vendor-name" rows="2" required><?php echo $vendor_name; ?></textarea>
                          </td>
                          <td>
                            <button type="submit" name="update-btn">Update</button>
                          </td>
                          <td>
                            <input type="button" onclick="window.location.href='delete_vaccine.php?id=<?php echo $vaccine_id; ?>'" value="Delete" />
                          </td>
                        </tr>
                      </form>
                    <?php
                    $serial_no += 1;
                    }
                    ?>
                    </tbody>
                  </table>
                  <?php
                  }
                  else
                  {
                    echo "<h2>No Records Found</h2>";
                  }
                  mysqli_close($conn);
                  ?>
                </div>
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
