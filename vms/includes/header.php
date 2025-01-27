<?php
session_start();
// function to get file path to check page is active for the purpose of navigation
$pageName =  basename($_SERVER['PHP_SELF'],".php");
?>
<!-- Start Header -->
<header class="header fixed-top">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
    <a href="index.php" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="">
      <span>COVID-19 VMS</span>
    </a>
    <!-- Start Nav -->
    <nav id="navbar" class="navbar" role="navigation">
      <ul class="nav">
        <li><a <?php if ($pageName == 'index')echo 'class="active"' ?> href="index.php">Home</a></li>
        <li><a <?php if ($pageName == 'appointment')echo 'class="active"' ?> href="appointment.php">Schedule Appointment</a></li>
        <li><a <?php if ($pageName == 'centers')echo 'class="active"' ?> href="centers.php">Centers</a></li>
        <li><a <?php if ($pageName == 'about')echo 'class="active"' ?> href="about.php">About</a></li>
        <li><a <?php if ($pageName == 'contact')echo 'class="active"' ?> href="contact.php">Contact</a></li>
        <?php
          if($_SESSION['is_logged_in'] == true)
          {?>
            <li class="dropdown">
                    <a href="#" class="dropdown-toggle" ><i class="fa fa-user"></i><?php echo $_SESSION["full_name"]; ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <?php
                      if($_SESSION['user_type'] == 'admin')
                      {
                      ?>
                        <li>
                            <a href="dashboard/"><i class="fa fa-fw fa-tachometer"></i> Dashboard</a>
                        </li>
                      <?php
                      }
                      ?>
                        <li>
                            <a href="update_profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="change_password.php"><i class="fa fa-fw fa-key"></i> Change Password</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
          <?php
          }
          else
          {
        ?>
        <li><a <?php if ($pageName == 'login')echo 'class="active"' ?> href="login.php">Login</a></li>
        <li><a class="register" href="signup.php">Patient Registration</a></li>
      <?php } ?>
      </ul>
    </nav><!-- End Nav -->
  </div>
</header><!-- End Header -->
