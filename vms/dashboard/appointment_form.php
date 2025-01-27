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
  <title>Appointment Forms | COVID-19 Vaccine Management System</title>
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
              <h1 class="page-header">Appointment Forms</h1>
              <ol class="breadcrumb">
                <li>
                  <i class="fa fa-tachometer"></i> <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <i class="fa fa-file"></i> Appointment Forms
                </li>
              </ol>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <form action="">
                <div class="form-group input-group">
                  <input type="text" class="form-control" name="q" placeholder="Type CNIC to search..">
                  <span class="input-group-btn"><button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button></span>
                </div>
              </form>
              <div class="table-responsive">
                <?php
                $searchString = "";
                if($_SERVER["REQUEST_METHOD"] == "GET")
                {
                  $searchString = $_GET["q"];
                }
                if(empty($searchString))
                {
                  // Create connection
                  $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                  $sql = "SELECT * FROM appointment";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0)
                  {
                  ?>
                  <table class="table table-bordered table-hover table-striped">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Name</th>
                              <th>City</th>
                              <th>Date of Birth</th>
                              <th>CNIC</th>
                              <th>Email</th>
                              <th>Center</th>
                              <th>Vaccine</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                    <?php
                    $serial_no = 1;
                    while($row = mysqli_fetch_assoc($result))
                    {
                      $request_id = $row["request_id"];
                      $user_name = $row["user_name"];
                      $cnic = $row["cnic"];
                      $dob = $row["dob"];
                      $email = $row["email"];
                      $city = $row["city"];
                      $center_id = $row["center_id"];
                      $vaccine_id = $row["vaccine_id"];
                      // Create connection
                      $conn2 = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                      $sql2 = "SELECT * FROM vaccine WHERE vaccine_id = ".$vaccine_id;
                      $result2 = mysqli_query($conn2, $sql2);
                      if (mysqli_num_rows($result2) > 0)
                      {
                        while($row2 = mysqli_fetch_assoc($result2))
                        {
                          $vaccine_title = $row2["vaccine_title"];
                        }
                      }
                      mysqli_close($conn2);
                      // Create connection
                      $conn2 = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                      $sql2 = "SELECT * FROM center WHERE center_id = ".$center_id;
                      $result2 = mysqli_query($conn2, $sql2);
                      if (mysqli_num_rows($result2) > 0)
                      {
                        while($row2 = mysqli_fetch_assoc($result2))
                        {
                          $center_name = $row2["center_name"];
                        }
                      }
                      mysqli_close($conn2);
                    ?>
                    <form action="appointment_action.php" method="post">
                      <tr>
                          <td><?php echo $serial_no; ?></td>
                          <td><?php echo $user_name; ?></td>
                          <td><?php echo $city; ?></td>
                          <td><?php echo $dob; ?></td>
                          <td><?php echo $cnic; ?></td>
                          <td><?php echo $email; ?></td>
                          <td><?php echo $center_name; ?></td>
                          <td><?php echo $vaccine_title; ?></td>
                          <td>
                            <a class="btn btn-sm btn-success" href="../appointment_form.php?r=<?php echo $request_id; ?>">Print</a>
                          </td>
                        </tr>
                    <?php
                    $serial_no += 1;
                    }
                  }
                  else
                  {
                    echo "<h2>No Records Found</h2>";
                  }
                  mysqli_close($conn);
                }
                else
                {
                  // Create connection
                  $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                  $sql = "SELECT * FROM appointment where cnic LIKE '%".$searchString."%'";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0)
                  {
                    $serial_no = 1;
                    while($row = mysqli_fetch_assoc($result))
                    {
                      $request_id = $row["request_id"];
                      $user_name = $row["user_name"];
                      $cnic = $row["cnic"];
                      $dob = $row["dob"];
                      $email = $row["email"];
                      $city = $row["city"];
                      $center_id = $row["center_id"];
                      $vaccine_id = $row["vaccine_id"];
                      // Create connection
                      $conn2 = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                      $sql2 = "SELECT * FROM vaccine WHERE vaccine_id = ".$vaccine_id;
                      $result2 = mysqli_query($conn2, $sql2);
                      if (mysqli_num_rows($result2) > 0)
                      {
                        while($row2 = mysqli_fetch_assoc($result2))
                        {
                          $vaccine_title = $row2["vaccine_title"];
                        }
                      }
                      mysqli_close($conn2);
                      // Create connection
                      $conn2 = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                      $sql2 = "SELECT * FROM center WHERE center_id = ".$center_id;
                      $result2 = mysqli_query($conn2, $sql2);
                      if (mysqli_num_rows($result2) > 0)
                      {
                        while($row2 = mysqli_fetch_assoc($result2))
                        {
                          $center_name = $row2["center_name"];
                        }
                      }
                      mysqli_close($conn2);
                    ?>
                    <form action="appointment_action.php" method="post">
                      <tr>
                          <td><?php echo $serial_no; ?></td>
                          <td><?php echo $user_name; ?></td>
                          <td><?php echo $city; ?></td>
                          <td><?php echo $dob; ?></td>
                          <td><?php echo $cnic; ?></td>
                          <td><?php echo $email; ?></td>
                          <td><?php echo $center_name; ?></td>
                          <td><?php echo $vaccine_title; ?></td>
                          <td>
                            <a class="btn btn-sm btn-success" href="../appointment_form.php?r=<?php echo $request_id; ?>">Print</a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <?php
                    $serial_no += 1;
                    }
                  }
                  else
                  {
                    echo "<h2>No Records Found</h2>";
                  }
                  mysqli_close($conn);
                }
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
