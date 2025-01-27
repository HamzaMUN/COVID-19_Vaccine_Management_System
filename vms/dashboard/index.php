<?php
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
    // including database credentials
    // for the purpose of sequrity database credentials file is put out of apache public_html directory
    include_once('../../vms_connection.php');
    // check appointment requests pending
    $pending_requests = 0;
    // Check pending appointment requests
    // Create connection
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $sql = "SELECT * FROM appointment_request WHERE status = 'pending'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
      $pending_requests = mysqli_num_rows($result);
    }
    else
    {
      $pending_requests = 0;
    }
    mysqli_close($conn);
    // Check new messages
    // Create connection
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $new_messages = 0;
    $sql = "SELECT * FROM contact_msg WHERE is_read = '0'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
      $new_messages = mysqli_num_rows($result);
    }
    else
    {
      $new_messages = 0;
    }
    mysqli_close($conn);
    // Check new feedbacks
    // Create connection
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $feedbacks = 0;
    $sql = "SELECT * FROM feedback WHERE is_read = '0'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
      $feedbacks = mysqli_num_rows($result);
    }
    else
    {
      $feedbacks = 0;
    }
    mysqli_close($conn);
    // Check unresolved complaints
    // Create connection
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $complaints = 0;
    $sql = "SELECT * FROM complaint WHERE is_resolved = '0'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
      $complaints = mysqli_num_rows($result);
    }
    else
    {
      $complaints = 0;
    }
    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | COVID-19 Vaccine Management System</title>
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
              <h1 class="page-header">Dashboard</h1>
              <ol class="breadcrumb">
                <li class="active">
                  <i class="fa fa-tachometer"></i> Dashboard
                </li>
              </ol>
            </div>
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-lg-3 col-md-6">
              <div class="panel panel-blue">
                <div class="panel-heading">
                  <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-calendar-check fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge"><?php echo $pending_requests; ?></div>
                      <div>New Appointment Requests!</div>
                    </div>
                  </div>
                </div>
                <a href="appointment_requests.php">
                  <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                  </div>
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-md-6">
              <div class="panel panel-green">
                <div class="panel-heading">
                  <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-envelope fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge"><?php echo $new_messages; ?></div>
                      <div>New Messages!</div>
                    </div>
                  </div>
                </div>
                <a href="messages.php">
                  <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                  </div>
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-md-6">
              <div class="panel panel-yellow">
                <div class="panel-heading">
                  <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-comment-dots fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge"><?php echo $feedbacks; ?></div>
                      <div>New Feedbacks!</div>
                    </div>
                  </div>
                </div>
                <a href="feedbacks.php">
                  <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                  </div>
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-md-6">
              <div class="panel panel-red">
                <div class="panel-heading">
                  <div class="row">
                    <div class="col-xs-3">
                      <i class="fa fa-exclamation-triangle fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <div class="huge"><?php echo $complaints; ?></div>
                      <div>New Complaints!</div>
                    </div>
                  </div>
                </div>
                <a href="complaints.php">
                  <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                  </div>
                </a>
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
