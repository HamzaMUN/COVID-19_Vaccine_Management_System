<?php
//check if not logged in then redirect
session_start();
// including database credentials
// for the purpose of sequrity database credentials file is put out of apache public_html directory
include_once('../vms_connection.php');
if($_SESSION['is_logged_in'] != true)
{
?>
  <script type="text/javascript">
    setTimeout("location.href = 'index.php';",500);
  </script>
<?php
}
else
{
  if($_SERVER["REQUEST_METHOD"] == "GET")
  {
    $request_id = $_GET["r"];
    // Create connection
    // load appointment details
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $sql = "SELECT * FROM appointment WHERE request_id = ".$request_id;
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
      while($row = mysqli_fetch_assoc($result))
      {
        $user_id = $row["user_id"];
        $center_id = $row["center_id"];
        $vaccine_id = $row["vaccine_id"];
        $full_name = $row["user_name"];
        $cnic = $row["cnic"];
        $dob = $row["dob"];
        $email = $row["email"];
        $city = $row["city"];
        $admin_id = $row["admin_id"];
      }
    }
    else
    {
      $errorMsg = "Unhandeled error! Please contact system administrator.";
    }
    mysqli_close($conn);
    // Create connection
    // select admin details who approved this appointment
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $sql = "SELECT * FROM user WHERE user_id = ".$admin_id;
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
      while($row = mysqli_fetch_assoc($result))
      {
        $admin_name = $row["full_name"];
      }
    }
    else
    {
      $errorMsg = "Unhandeled error! Please contact system administrator.";
    }
    mysqli_close($conn);
    // Create connection
    // load patient details
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $sql = "SELECT * FROM user WHERE user_id = ".$user_id;
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
      while($row = mysqli_fetch_assoc($result))
      {
        $vaccine_status = $row["vaccine_status"];
      }
    }
    else
    {
      $errorMsg = "Unhandeled error! Please contact system administrator.";
    }
    mysqli_close($conn);
    // Create connection
    // load vaccine details
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $sql = "SELECT * FROM vaccine WHERE vaccine_id = ".$vaccine_id;
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
      while($row = mysqli_fetch_assoc($result))
      {
        $vaccine_title = $row["vaccine_title"];
        $dose_count = $row["dose_count"];
        $second_dose = $row["second_dose"];
        $vaccine_vendor = $row["vendor_name"];
      }
    }
    else
    {
      $errorMsg = "Unhandeled error! Please contact system administrator.";
    }
    mysqli_close($conn);
    // Create connection
    // load center details
    $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
    $sql = "SELECT * FROM center WHERE center_id = ".$center_id;
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0)
    {
      while($row = mysqli_fetch_assoc($result))
      {
        $center_name = $row["center_name"];
        $center_address = $row["address"];
        $center_contact = $row["contact"];
      }
    }
    else
    {
      $errorMsg = "Unhandeled error! Please contact system administrator.";
    }
    mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Generate Appointment Form</title>
  <style>
    body{
      width: 1024px;
      font-family: Helvetica;
      font-size: 16px;
    }
    table{
      padding: 20px;
    }
    td{
      padding: 10px;
      border: 1px solid #000;
    }
    .footer{
      bottom: 0;
      width: 1024px;
      position: fixed;
    }
    .left{
      padding-left: 20px;
      float: left;
    }
    .right{
      padding-right: 20px;
      float: right;
    }
  </style>
</head>
<body>
   <?php
   if(!empty($errorMsg))
   {
     echo $errorMsg;
   }
   else
   {
   ?>
     <center>
       <h1>Patient Vaccine Appointment Form</h1>
       <div class="right"><button onclick="window.print();">Print Form</button></div>
        <table width="100%">
          <tr>
            <td colspan="4"><h2>Patient Profile:</h2></td>
          </tr>
          <tr>
            <td><b>Patient Name:</b></td>
            <td><?php echo $full_name ?></td>
            <td><b>CNIC:</b></td>
            <td><?php echo $cnic ?></td>
          </tr>
          <tr>
            <td><b>Email:</b></td>
            <td><?php echo $email ?></td>
            <td><b>Date of Birth:</b></td>
            <td><?php echo $dob ?></td>
          </tr>
          <tr>
            <td><b>City:</b></td>
            <td><?php echo $city ?></td>
            <td><b>Vaccination Status:</b></td>
            <td><?php echo $vaccine_status ?></td>
          </tr>
          <tr>
            <td colspan="4"><h2>Vaccination Center Details:</h2></td>
          </tr>
          <tr>
            <td><b>Center Name:</b></td>
            <td><?php echo $center_name ?></td>
            <td><b>Contact:</b></td>
            <td><?php echo $center_contact ?></td>
          </tr>
          <tr>
            <td><b>Address:</b></td>
            <td><?php echo $center_address ?></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td colspan="4"><h2>Vaccine Details:</h2></td>
          </tr>
          <tr>
            <td><b>Vaccine Name:</b></td>
            <td><?php echo $vaccine_title ?></td>
            <td><b>No of Dosage:</b></td>
            <td><?php echo $dose_count ?></td>
          </tr>
          <tr>
            <td><b>Second Dose:</b></td>
            <td><?php echo $second_dose ?></td>
            <td><b>Manufacturer:</b></td>
            <td><?php echo $vaccine_vendor ?></td>
          </tr>
        </table>
     </center>
     <div class="footer">
     <div class="left">
       Approved by: <?php echo $admin_name; ?>
     </div>
     <div class="right">
       Printed By: <?php echo $_SESSION['full_name']; ?>
     </div>
       <center><p style="border-top:1px solid #000">Covid-19 Vaccine Management System</p></center>
     </div>
   <?php
   }
   ?>
</body>
</html>
<?php
  }
  else
  {
?>
    <script type="text/javascript">
      setTimeout("location.href = 'index.php';",500);
    </script>
<?php
  }
}
?>
