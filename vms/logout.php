<?php
session_start();
session_unset();
session_destroy();
?>
<script type="text/javascript">
  setTimeout("location.href = 'login.php';",1000);
</script>
