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
    if($_SERVER["REQUEST_METHOD"] == "GET")
    {
      $vaccine_id = $_GET["id"];
    }
    if(!empty($vaccine_id))
    {
      // Create connection
      $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
      $sql = "DELETE FROM vaccine WHERE vaccine_id = ".$vaccine_id;
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
