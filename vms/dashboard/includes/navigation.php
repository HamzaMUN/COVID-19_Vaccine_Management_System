<?php
// function to get file path to check page is active for the purpose of navigation
$pageName =  basename($_SERVER['PHP_SELF'],".php");
?>
<!-- Navigations -->
<nav class="navbar navbar-fixed-top" role="navigation">
  <div class="navbar-header">
    <a class="navbar-brand" href="../index.php">COVID-19 VMS</a>
  </div>
  <!-- Top Menu Items -->
  <ul class="nav navbar-right top-nav">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION["full_name"]; ?> <b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li>
          <a href="../update_profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
        </li>
        <li>
          <a href="../change_password.php"><i class="fa fa-fw fa-key"></i> Change Password</a>
        </li>
        <li class="divider"></li>
        <li>
          <a href="../logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
        </li>
      </ul>
    </li>
  </ul>
  <!-- Sidebar -->
  <div class="collapse navbar-collapse">
    <ul class="nav navbar-nav side-nav">
      <li <?php if ($pageName == 'index')echo 'class="active"' ?>>
        <a href="index.php"><i class="fa fa-fw fa-tachometer"></i> Dashboard</a>
      </li>
      <li <?php if ($pageName == 'appointment_requests')echo 'class="active"' ?>>
        <a href="appointment_requests.php"><i class="fa fa-fw fa-calendar-check"></i> Appointment Requests</a>
      </li>
      <li <?php if ($pageName == 'appointment_form')echo 'class="active"' ?>>
        <a href="appointment_form.php"><i class="fa fa-fw fa-file"></i> Appointment Forms</a>
      </li>
      <li <?php if ($pageName == 'messages')echo 'class="active"' ?>>
        <a href="messages.php"><i class="fa fa-fw fa-envelope"></i> Messages</a>
      </li>
      <li <?php if ($pageName == 'feedbacks')echo 'class="active"' ?>>
        <a href="feedbacks.php"><i class="fa fa-fw fa-comment-dots"></i> Feedbacks</a>
      </li>
      <li <?php if ($pageName == 'complaints')echo 'class="active"' ?>>
        <a href="complaints.php"><i class="fa fa-fw fa-exclamation-triangle"></i> Complaints</a>
      </li>
      <li <?php if ($pageName == 'vaccines')echo 'class="active"' ?>>
        <a href="vaccines.php"><i class="fa fa-fw fa-syringe"></i> Vaccines</a>
      </li>
      <li <?php if ($pageName == 'centers')echo 'class="active"' ?>>
        <a href="centers.php"><i class="fa fa-fw fa-hospital"></i> Vaccination Centers</a>
      </li>
      <li <?php if ($pageName == 'users')echo 'class="active"' ?>>
        <a href="users.php"><i class="fa fa-fw fa-user"></i> Users Administration</a>
      </li>
    </ul>
  </div>
</nav><!-- End navbar -->
