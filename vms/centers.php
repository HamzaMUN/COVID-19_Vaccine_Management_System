<?php
// including database credentials
// for the purpose of sequrity database credentials file is put out of apache public_html directory
include_once('../vms_connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Distribution Centers | COVID-19 Vaccine Management System</title>
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
  <?php include_once('includes/header.php'); ?>

  <!-- Breadcrumbs -->
  <section class="breadcrumbs">
    <div class="container">
      <ol>
        <li><a href="index.php">Home</a></li>
        <li>Distribution Centers</li>
      </ol>
      <h2>Distribution Centers</h2>
    </div>
  </section><!-- End Breadcrumbs -->

  <!-- Centers Section -->
  <section class="centers">
    <!-- Centers Search -->
    <div class="search-center">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 text-center">
            <h4>Search Vaccination Centers</h4>
          </div>
          <div class="col-lg-6">
            <form action="" method="get">
              <input type="text" name="q" />
              <input type="submit" name="search-btn" value="Search" />
            </form>
          </div>
        </div>
      </div>
    </div><!-- End Centers Search -->
    <!-- Show Centers -->
    <div class="container">
      <!-- Center Details -->
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
        $sql = "SELECT * FROM center ORDER BY center_id ASC";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0)
        {
          while($row = mysqli_fetch_assoc($result))
          {
            $center_id = $row["center_id"];
            $center_name = $row["center_name"];
            $province = $row["province"];
            $district = $row["district"];
            $tehsil = $row["tehsil"];
            $address = $row["address"];
            $contact = $row["contact"];
            ?>
            <div class="row center-details">
              <h3><?php echo $center_name; ?></h3>
              <div class="row">
                <div class="col-xl-4 text-center">
                  <img src="assets/img/center-default.png" class="img-fluid p-4" alt="">
                </div>
                <div class="col-xl-8 d-flex content">
                  <div class="row align-self-center gy-4">
                    <div class="col-md-6 icon-box">
                      <i class="fas fa-map-marked"></i>
                      <div>
                        <h4>Province</h4>
                        <p><?php echo $province; ?></p>
                      </div>
                    </div>
                    <div class="col-md-6 icon-box">
                      <i class="fas fa-city"></i>
                      <div>
                        <h4>District</h4>
                        <p><?php echo $district; ?></p>
                      </div>
                    </div>
                    <div class="col-md-6 icon-box">
                      <i class="fas fa-road"></i>
                      <div>
                        <h4>Tehsil</h4>
                        <p><?php echo $tehsil; ?></p>
                      </div>
                    </div>
                    <div class="col-md-6 icon-box">
                      <i class="fas fa-hospital"></i>
                      <div>
                        <h4>Address</h4>
                        <p><?php echo $address; ?></p>
                      </div>
                    </div>
                    <div class="col-md-6 icon-box">
                      <i class="fas fa-phone"></i>
                      <div>
                        <h4>Contact</h4>
                        <p><?php echo $contact; ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Center Detail -->
          <?php
          }
        }
        else
        {?>
          <h4 class="no-result text-center">Ooops!! No records found.</h4>
        <?php
        }
      }
      else
      {
        // Create connection
        $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
        $sql = "SELECT * FROM center WHERE center_name LIKE '%".$searchString."%' OR address LIKE '%".$searchString."%' ORDER BY center_id ASC";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0)
        {
          while($row = mysqli_fetch_assoc($result))
          {
            $center_id = $row["center_id"];
            $center_name = $row["center_name"];
            $province = $row["province"];
            $district = $row["district"];
            $tehsil = $row["tehsil"];
            $address = $row["address"];
            $contact = $row["contact"];
            ?>
            <div class="row center-details">
              <h3><?php echo $center_name; ?></h3>
              <div class="row">
                <div class="col-xl-4 text-center">
                  <img src="assets/img/center-default.png" class="img-fluid p-4" alt="">
                </div>
                <div class="col-xl-8 d-flex content">
                  <div class="row align-self-center gy-4">
                    <div class="col-md-6 icon-box">
                      <i class="fas fa-map-marked"></i>
                      <div>
                        <h4>Province</h4>
                        <p><?php echo $province; ?></p>
                      </div>
                    </div>
                    <div class="col-md-6 icon-box">
                      <i class="fas fa-city"></i>
                      <div>
                        <h4>District</h4>
                        <p><?php echo $district; ?></p>
                      </div>
                    </div>
                    <div class="col-md-6 icon-box">
                      <i class="fas fa-road"></i>
                      <div>
                        <h4>Tehsil</h4>
                        <p><?php echo $tehsil; ?></p>
                      </div>
                    </div>
                    <div class="col-md-6 icon-box">
                      <i class="fas fa-hospital"></i>
                      <div>
                        <h4>Address</h4>
                        <p><?php echo $address; ?></p>
                      </div>
                    </div>
                    <div class="col-md-6 icon-box">
                      <i class="fas fa-phone"></i>
                      <div>
                        <h4>Contact</h4>
                        <p><?php echo $contact; ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Center Detail -->
          <?php
          }
        }
        else
        {
        ?>
          <h4 class="no-result text-center">Ooops!! No records found.</h4>
        <?php
        }
      }
      ?>
    </div>
  </section><!-- End Centers Section -->

  <?php include_once('includes/footer.php'); ?>
  <!-- Javascript Files -->
  <!-- Bootstrap -->
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
