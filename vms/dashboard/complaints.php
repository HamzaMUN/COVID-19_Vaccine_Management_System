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
  <title>Complaints | COVID-19 Vaccine Management System</title>
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
              <h1 class="page-header">Complaints</h1>
              <ol class="breadcrumb">
                <li>
                  <i class="fa fa-tachometer"></i> <a href="index.php">Dashboard</a>
                </li>
                <li class="active">
                  <i class="fa fa-exclamation-triangle"></i> Complaints
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
                  $sql = "SELECT * FROM complaint WHERE is_resolved = 0 ORDER BY complaint_id ASC";
                  $result = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($result) > 0)
                  {
                  ?>
                  <table class="table table-bordered table-hover table-striped">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Complaint ID</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Subject</th>
                              <th>Details</th>
                              <th>Date and Time</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                  <?php
                    $serial_no = 1;
                    while($row = mysqli_fetch_assoc($result))
                    {
                      $complaint_id = $row["complaint_id"];
                      $complaint_name = $row["name"];
                      $complaint_email = $row["email"];
                      $complaint_subject = $row["subject"];
                      $complaint_body = $row["complaint_body"];
                      $complaint_time = $row["complaint_time"];
                    ?>
                      <tr>
                          <td><?php echo $serial_no; ?></td>
                          <td><?php echo $complaint_id; ?></td>
                          <td><?php echo $complaint_name; ?></td>
                          <td><?php echo $complaint_email; ?></td>
                          <td><?php echo $complaint_subject; ?></td>
                          <td><?php echo $complaint_body; ?></td>
                          <td><?php echo $complaint_time; ?></td>
                          <td>
                            <button onclick="window.location.href='mark_complaint.php?id=<?php echo $complaint_id; ?>'">Mark as resolved</button>
                          </td>
                        </tr>
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
                    echo "<h2>No Unresolved Complaints</h2>";
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
