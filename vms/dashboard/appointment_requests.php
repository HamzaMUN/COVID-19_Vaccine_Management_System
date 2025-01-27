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
  <title>Appointment Requests | COVID-19 Vaccine Management System</title>
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
              <h1 class="page-header">Appointment Requests</h1>
              <ol class="breadcrumb">
                <li>
                  <i class="fa fa-tachometer"></i> <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <i class="fa fa-calendar-check"></i> Appointment Requests
                </li>
              </ol>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                  <?php
                  // Create connection
                  $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                  $sql = "SELECT * FROM appointment_request WHERE status = 'pending'";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0)
                  {
                  ?>
                  <table class="table table-bordered table-hover table-striped">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Request ID</th>
                              <th>Name</th>
                              <th>City</th>
                              <th>Date of Birth</th>
                              <th>CNIC</th>
                              <th>Email</th>
                              <th>Center</th>
                              <th>Vaccine</th>
                              <th>Status</th>
                              <th>Comments</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                  <?php
                    $serial_no = 1;
                    while($row = mysqli_fetch_assoc($result))
                    {
                      $request_id = $row["request_id"];
                      $user_id = $row["user_id"];
                      // Create connection
                      $conn2 = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                      $sql2 = "SELECT * FROM user WHERE user_id = ".$user_id;
                      $result2 = mysqli_query($conn2, $sql2);
                      if (mysqli_num_rows($result2) > 0)
                      {
                        while($row2 = mysqli_fetch_assoc($result2))
                        {
                          $full_name = $row2["full_name"];
                          $cnic2 = $row2["cnic"];
                          $cnic = substr($cnic2, 0, 5)."-".substr($cnic2, 5, 7)."-".substr($cnic2, 12, 1);
                          $email = $row2["email"];
                          $city = $row2["city"];
                          $dob = $row2["dob"];
                        }
                      }
                      mysqli_close($conn2);
                    ?>
                    <form action="appointment_action.php" method="post">
                      <input type="hidden" name="request-id" value="<?php echo $request_id; ?>">
                      <input type="hidden" name="user-id" value="<?php echo $user_id; ?>">
                      <input type="hidden" name="full-name" value="<?php echo $full_name; ?>">
                      <input type="hidden" name="city" value="<?php echo $city; ?>">
                      <input type="hidden" name="dob" value="<?php echo $dob; ?>">
                      <input type="hidden" name="cnic" value="<?php echo $cnic; ?>">
                      <input type="hidden" name="email" value="<?php echo $email; ?>">
                      <tr>
                          <td><?php echo $serial_no; ?></td>
                          <td><?php echo $request_id; ?></td>
                          <td><?php echo $full_name; ?></td>
                          <td><?php echo $city; ?></td>
                          <td><?php echo $dob; ?></td>
                          <td><?php echo $cnic; ?></td>
                          <td><?php echo $email; ?></td>
                          <td>
                            <select name="center-option">
                              <?php
                                // Create connection
                                $conn2 = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                                $sql2 = "SELECT * FROM center WHERE address LIKE '%".$city."%' ORDER BY center_name ASC";
                                $result2 = mysqli_query($conn2, $sql2);
                                if (mysqli_num_rows($result2) > 0)
                                {
                                  while($row2 = mysqli_fetch_assoc($result2))
                                  {
                                    $center_id = $row2["center_id"];
                                    $center_name = $row2["center_name"];
                                  ?>
                                    <option value="<?php echo $center_id; ?>"><?php echo $center_name; ?></option>
                                  <?php
                                  }
                                }
                                else
                                {
                                  // Create connection
                                  $conn3 = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                                  $sql3 = "SELECT * FROM center ORDER BY center_name ASC";
                                  $result3 = mysqli_query($conn3, $conn3);
                                  if (mysqli_num_rows($result3) > 0)
                                  {
                                    while($row3 = mysqli_fetch_assoc($result3))
                                    {
                                      $center_id = $row3["center_id"];
                                      $center_name = $row3["center_name"];
                                    ?>
                                      <option value="<?php echo $center_id; ?>"><?php echo $center_name; ?></option>
                                    <?php
                                    }
                                  }
                                  mysqli_close($conn3);
                                }
                                mysqli_close($conn2);
                              ?>
                            </select>
                          </td>
                          <td>
                            <select name="vaccine-option">
                              <?php
                                // Create connection
                                $conn2 = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                                $sql2 = "SELECT * FROM vaccine ORDER BY vaccine_title ASC";
                                $result2 = mysqli_query($conn2, $sql2);
                                if (mysqli_num_rows($result2) > 0)
                                {
                                  while($row2 = mysqli_fetch_assoc($result2))
                                  {
                                    $vaccine_id = $row2["vaccine_id"];
                                    $vaccine_title = $row2["vaccine_title"];
                                  ?>
                                    <option value="<?php echo $vaccine_id; ?>"><?php echo $vaccine_title; ?></option>
                                  <?php
                                  }
                                }
                                mysqli_close($conn2);
                              ?>
                            </select>
                          </td>
                          <td>
                            <select name="status-option">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                          </td>
                          <td>
                            <input type="text" name="comments" style="width:100px;" />
                          </td>
                          <td>
                            <button type="submit" name="proceed-btn">Proceed</button>
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
                    echo "<h2>No Pending Requests Found</h2>";
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
