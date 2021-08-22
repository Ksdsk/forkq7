<?php
  session_start();
  if(!isset($_SESSION['username'])) {
    header('location: login.php');
  }
  include('_adminincludes/header.php');
?>
<?php
  include('_adminincludes/footer.php')
?>