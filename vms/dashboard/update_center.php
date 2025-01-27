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
      $center_id = $_POST["center-id"];
      $center_name = $_POST["center-name"];
      $province = $_POST["province"];
      $district = $_POST["district"];
      $tehsil = $_POST["tehsil"];
      $address = $_POST["address"];
      $contact = $_POST["contact"];
    }
    if(!empty($center_id))
    {
      // Create connection
      $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
      $sql = "UPDATE center SET center_name = '".$center_name."', province = '".$province."', district = '".$district."', tehsil = '".$tehsil."', address = '".$address."', contact = '".$contact."' WHERE center_id = ".$center_id;
      if(mysqli_query($conn, $sql))
      {
        ?>
        <script type="text/javascript">
          setTimeout("location.href = 'centers.php';",500);
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
