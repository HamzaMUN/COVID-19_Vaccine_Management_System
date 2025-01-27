<?php
//check if not logged in then redirect
session_start();
// including database credentials
// for the purpose of sequrity database credentials file is put out of apache public_html directory
include_once('../../vms_connection.php');
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
      //saving values from form in local variables
      $request_id = $_POST["request-id"];
      $user_id = $_POST["user-id"];
      $full_name = $_POST["full-name"];
      $city = $_POST["city"];
      $dob = $_POST["dob"];
      $cnic = $_POST["cnic"];
      $email = $_POST["email"];
      $center_id = $_POST["center-option"];
      $vaccine_id = $_POST["vaccine-option"];
      $status = $_POST["status-option"];
      $remarks = $_POST["comments"];

      switch ($status)
      {
        case 'rejected':
          // Create connection
          $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
          $sql = "UPDATE appointment_request SET status = 'rejected', remarks = '".$remarks."', admin_id = ".$_SESSION['user_id']." WHERE request_id = ".$request_id;
          if(mysqli_query($conn, $sql))
          {
            //php mail function to send random key in email
            $to = $email;
            $subject = "[Rejected] Vaccine Appointment | COVID-19 Vaccine Management System";
            $message = "Your vaccination request has been rejected. Remarks: ".$remarks;
            $from = "no-reply@vms";
            mail($to, $subject, $message, $from);
            ?>
            <script type="text/javascript">
              setTimeout("location.href = 'appointment_requests.php';",500);
            </script>
            <?php
          }
          else
          {
            ?>
            <script type="text/javascript">
              setTimeout("location.href = 'appointment_requests.php';",500);
            </script>
            <?php
          }
          mysqli_close($conn);
          break;
        case 'approved':
          // Create connection
          $conn = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
          $sql = "UPDATE appointment_request SET status = 'approved', remarks = '".$remarks."', admin_id = ".$_SESSION['user_id']." WHERE request_id = ".$request_id;
          if(mysqli_query($conn, $sql))
          {
            // Create connection
            $conn2 = mysqli_connect($servername, $dbuser, $dbpass, $dbname);
            $sql2 = "INSERT INTO appointment (user_id, request_id, center_id, vaccine_id, user_name, cnic, dob, email, city, admin_id)
            VALUES(".$user_id.", ".$request_id.", ".$center_id.", ".$vaccine_id.", '".$full_name."', '".$cnic."', '".$dob."', '".$email."', '".$city."', '".$_SESSION['user_id']."')";
            if(mysqli_query($conn2, $sql2))
            {
              //php mail function to send random key in email
              $to = $email;
              $subject = "[Approved] Vaccine Appointment | COVID-19 Vaccine Management System";
              $message = 'Your vaccination request has been apptoved. <a href="http://localhost/vms/appointment_form.php?r="'.$request_id.'>Click here</a> to download your application form.';
              $from = "no-reply@vms";
              mail($to, $subject, $message, $from);
            ?>
              <script type="text/javascript">
                setTimeout("location.href = 'appointment_requests.php';",500);
              </script>

            <?php
            }
            else
            {
              ?>
              <script type="text/javascript">
                setTimeout("location.href = 'appointment_requests.php';",500);
              </script>
              <?php
            }
            mysqli_close($conn2);
          }
          else
          {
            ?>
            <script type="text/javascript">
              setTimeout("location.href = 'appointment_requests.php';",500);
            </script>
            <?php
          }
          mysqli_close($conn);
          break;

        default:
          break;
      }


    }
  }
}
?>
