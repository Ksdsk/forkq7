<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
include('_adminincludes/header.php');
include('_adminincludes/db_connection_inquiry.php');
// display the inquiry subject and inquiry details 
$sql = "SELECT * FROM inquiry ORDER BY inquiry_id DESC";
$result = mysqli_query($connect, $sql);
if(isset($_GET['id'])){
  if(mysqli_query($connect, 'DELETE FROM inquiry WHERE inquiry_id ='.$_GET['id'])) {
    mysqli_close($connect);
    header('Location: '.$_SERVER['PHP_SELF']);
  } else {
    echo 'Failed to delete';
  }
}
if(isset($_GET['unread'])) {
    if(mysqli_query($connect, 'UPDATE inquiry SET inquiry_isread = 0 WHERE inquiry_id ='.$_GET['unread'])) {
        mysqli_close($connect);
        header('Location: '.$_SERVER['PHP_SELF']);
      } else {
        echo 'Failed to make the inquiry unread';
      }
}

?>
    <style>
        table tr {
            cursor: pointer;
        }
    </style>

      <div class="col-sm-9 mt-5">
        <p class="bg-dark text-white p-2">List of Inquiries</p>
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Inquiry Subject</th>
              <th scope="col">Inquirer Name</th>
              <th scope="col">Received</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $index = 1;
            while ($row = mysqli_fetch_array($result)) {
              // colour rows depending on its state (important, read, unread)
              if ($row['inquiry_isimportant'] == 1) {
                echo '<tr class="table-warning" onclick="document.location=`inquiries-detail.php?inquiryID='.$row['inquiry_id'].'`">';
              } elseif ($row['inquiry_isread'] == 1) {
                echo '<tr class="table-secondary" onclick="document.location=`inquiries-detail.php?inquiryID='.$row['inquiry_id'].'`">';
              } else {
                // $curr = (string)new DateTime();
                // echo '   '.$row['inquiry_id'];
                echo '<tr onclick="document.location=`inquiries-detail.php?inquiryID='.$row['inquiry_id'].'`">';
              }
              echo '<th scope="row">' . $index . '</th>';
              echo '<td>' . $row['inquiry_subject'] . '</td>';
              echo '<td>' . $row['inquiry_firstname'] . " " . $row['inquiry_lastname'] . '</td>';
              $currenttime = strtotime(gmdate("Y-m-d H:i:s", time()));
              $datereceived = strtotime($row['inquiry_datetime']);
              $interval = $currenttime - $datereceived;
              if ($interval < 3600) {
                echo '<td>'.floor($interval/60).' Minutes Ago</td>';
              } elseif ($interval < 86400) {
                echo '<td>'.floor($interval/3600).' Hours Ago</td>';
              } else {
                echo '<td>'.gmdate("Y-m-d", strtotime($row['inquiry_datetime'])).'</td>';
              }
              echo '<td><a href="'.$_SERVER['PHP_SELF'].'?id='.$row['inquiry_id'].'">Delete</a></td>';
              echo '</tr>';
              $index++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
<?php
include('_adminincludes/footer.php')
?>