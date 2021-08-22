<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
include('_adminincludes/header.php');
include('_adminincludes/db_connection_inquiry.php');

//display inquiry details
$sql = "SELECT * FROM inquiry WHERE inquiry_id = ".$_GET["inquiryID"];
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
if(isset($_GET['important'])){
    if(mysqli_query($connect, 'UPDATE inquiry SET inquiry_isimportant = '.$_GET['important'].' WHERE inquiry_id ='.$_GET['inquiryID'])) {
      mysqli_close($connect);
      header('Location: '.$_SERVER['PHP_SELF'].'?inquiryID='.$_GET['inquiryID']);
    } else {
      echo 'Failed to make inquiry important';
    }
}
// this inquiry is read
mysqli_query($connect, 'UPDATE inquiry SET inquiry_isread = 1 WHERE inquiry_id = '.$_GET['inquiryID']);
?>
<style>
    .loader {
    border: 8px solid #efebe0;
    border-top: 8px solid #35363a;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 2s linear infinite;
  }
  
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
  /* Safari */
  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }
</style>
<body onload="translateiso2ToNames()">
    <div class="col-sm-9 mt-5">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-primary btn-sm" onclick="document.location=`inquiries.php`">Go Back</button>
            </div>
            <div>
                <?php
                    echo '<button type="button" class="btn btn-success btn-sm" onclick="document.location=`mailto:'.$row['inquiry_email'].'`">Send Email</button>';
                    if ($row['inquiry_isimportant'] == 0) {
                        echo '<button type="button" class="btn btn-warning btn-sm ms-3" onclick="document.location=`'.$_SERVER['PHP_SELF'].'?inquiryID='.$_GET['inquiryID'].'&important=1`">Mark as Important</button>';
                    } else {
                        echo '<button type="button" class="btn btn-warning btn-sm ms-3" onclick="document.location=`'.$_SERVER['PHP_SELF'].'?inquiryID='.$_GET['inquiryID'].'&important=0`">Do Not Mark as Important</button>';
                    }
                    echo '<button type="button" class="btn btn-secondary btn-sm ms-3" onclick="document.location=`inquiries.php?unread='.$_GET['inquiryID'].'`">Mark as Unread</button>';
                    echo '<button type="button" class="btn btn-danger btn-sm ms-3" onclick="document.location=`inquiries.php?id='.$_GET['inquiryID'].'`">Delete this Message</button>';
                ?>
                
                
                
            </div>
        </div>

        <hr>

        <div id="loader" class="loader mx-auto mt-5"></div>

        <div id="showWhenReady" class="d-none">
            <?php
                echo '<h3>Subject: '.$row['inquiry_subject'].'</h3>';
                echo '<p>Name: '.$row['inquiry_firstname'].' '.$row['inquiry_lastname'].'</p>';
                echo '<p id="location" class="'.$row['inquiry_country'].'|'.$row['inquiry_state'].'|'.$row['inquiry_city'].'">Location: </p>';
                echo '<p>Phone: '.$row['inquiry_phone'].'</p>';
                echo '<p>Email: '.$row['inquiry_email'].'</p>';
                echo '<p>Date received: '.nl2br($row['inquiry_datetime']).' UTC'.'</p>';
                echo '<br>';
                echo '<p>Message: <br>'.nl2br($row['inquiry_message']).'</p>';
            ?>
        </div>

    </div>
    <script src="../js/translateiso2.js"></script>  
</body>



<?php
include('_adminincludes/footer.php')
?>