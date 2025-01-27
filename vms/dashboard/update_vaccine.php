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
      $vaccine_id = $_POST["vaccine-id"];
      $vaccine_title = $_POST["vaccine-title"];
      $dosage_count = $_POST["dose-count"];
      $second_dose = $_POST["second-dose"];
      $vendor_name = $_POST["vendor-name"];
    }
    if(!empty($vaccine_id))
    {
      // Create connection
      $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
      $sql = "UPDATE vaccine SET vaccine_title = '".$vaccine_title."', dose_count = '".$dosage_count."', second_dose = '".$second_dose."', vendor_name = '".$vendor_name."' WHERE vaccine_id = ".$vaccine_id;
      if(mysqli_query($conn, $sql))
      {
        ?>
        <script type="text/javascript">
          setTimeout("location.href = 'vaccines.php';",500);
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
