<?php
include('db_connection_inquiry.php');
$sql = "SELECT * FROM inquiry WHERE inquiry_id = ".$_GET["inquiryID"];
$result = mysqli_query($connect, $sql);
if(isset($_GET['id'])){
    if(mysqli_query($connect, 'DELETE FROM inquiry WHERE inquiry_id ='.$_GET['id'])) {
      mysqli_close($connect);
      header('Location: '.$_SERVER['PHP_SELF']);
    } else {
      echo 'Failed to delete';
    }
}
$row = mysqli_fetch_assoc($result);
$location = array('countryiso2' => $row['inquiry_country'], 'state' => $row['inquiry_state']);
echo json_encode($location);
?>

