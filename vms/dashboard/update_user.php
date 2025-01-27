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
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $user_id = $_POST["user-id"];
      $cnic = $_POST["cnic"];
      $full_name = $_POST["full-name"];
      $email = $_POST["email"];
      $city = $_POST["city"];
      $dob = $_POST["dob"];
      $user_type = $_POST["user-type"];
      $vaccine_status = $_POST["vaccine-status"];
    }
    if(!empty($user_id))
    {
      // Create connection
      $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
      $sql = "UPDATE user SET cnic = '".$cnic."', full_name = '".$full_name."', email = '".$email."', city = '".$city."', dob = '".$dob."', user_type = '".$user_type."', vaccine_status = '".$vaccine_status."' WHERE user_id = ".$user_id;
      if(mysqli_query($conn, $sql))
      {
        ?>
        <script type="text/javascript">
          setTimeout("location.href = 'users.php';",500);
        </script>
        <?php
      }
      else
      {
        $errorMsg = mysqli_error($conn);
      }
      mysqli_close($conn);
    }
  }
}
?>
