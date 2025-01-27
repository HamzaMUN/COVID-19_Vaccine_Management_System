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
  <title>Users Administration | COVID-19 Vaccine Management System</title>
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
              <h1 class="page-header">Users Administration</h1>
              <ol class="breadcrumb">
                <li>
                  <i class="fa fa-tachometer"></i> <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <i class="fa fa-user"></i> Users Administration
                </li>
              </ol>
            </div>
          </div>
          <div class="row" style="margin-bottom:20px;">
            <div class="col-lg-12">
              <a class="btn btn-danger" href="new_user.php"><i class="fa fa-plus"></i> Add New User</a>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                  <?php
                  // Create connection
                  $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
                  $sql = "SELECT * FROM user ORDER BY user_id ASC";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0)
                  {
                  ?>
                  <table class="table table-bordered table-hover table-striped">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>User ID</th>
                              <th>CNIC</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>City</th>
                              <th>Date of Birth</th>
                              <th>User Type</th>
                              <th>Vaccination Status</th>
                              <th style="text-align: center;" colspan="2">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                  <?php
                    $serial_no = 1;
                    while($row = mysqli_fetch_assoc($result))
                    {
                      $user_id  = $row["user_id"];
                      $cnic   = $row["cnic"];
                      $full_name = $row["full_name"];
                      $email = $row["email"];
                      $city = $row["city"];
                      $dob = $row["dob"];
                      $user_type = $row["user_type"];
                      $vaccine_status = $row["vaccine_status"];
                    ?>
                    <form action="update_user.php" method="post">
                      <tr>
                        <input type="hidden" name="user-id" value="<?php echo $user_id; ?>">
                        <td><?php echo $serial_no; ?></td>
                        <td><?php echo $user_id; ?></td>
                          <td>
                            <input style="width: 120px;"  type="text" name="cnic" value="<?php echo $cnic; ?>" required />
                          </td>
                          <td>
                            <input style="width: 100px;" type="text" name="full-name" value="<?php echo $full_name; ?>" required />
                          </td>
                          <td>
                            <input style="width: 150px;" type="text" name="email" value="<?php echo $email; ?>" required />
                          </td>
                          <td>
                            <input style="width: 100px;" type="text" name="city" value="<?php echo $city; ?>" required />
                          </td>
                          <td>
                            <input style="width: 80px;" type="text" name="dob" value="<?php echo $dob; ?>" required />
                          </td>
                          <td>
                            <select name="user-type" >
                              <option value="admin" <?php if($user_type=='admin') echo 'selected'; ?>>Administrator</option>
                              <option value="patient" <?php if($user_type=='patient') echo 'selected'; ?>>Patient</option>
                            </select>
                          </td>
                          <td>
                            <select name="vaccine-status">
                              <option value="Fully Vaccinated" <?php if($vaccine_status=='Fully Vaccinated') echo 'selected'; ?>>Fully Vaccinated</option>
                              <option value="Partially Vaccinated" <?php if($vaccine_status=='Partially Vaccinated') echo 'selected'; ?>>Partially Vaccinated</option>
                              <option value="Not Vaccinated" <?php if($vaccine_status=='Not Vaccinated') echo 'selected'; ?>>Not Vaccinated</option>
                            </select>
                          </td>
                          <td>
                            <button type="submit" name="update-btn">Update</button>
                          </td>
                          <td>
                            <input type="button" onclick="window.location.href='delete_user.php?id=<?php echo $user_id; ?>'" value="Delete" />
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
