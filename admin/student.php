<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
$sql = "SELECT * FROM participant";

$result = mysqli_query($connect, $sql);
if(isset($_GET['id'])){
  if(mysqli_query($connect, 'DELETE FROM participant WHERE participant_id ='.$_GET['id'])) {
    mysqli_close($connect);
    header('Location: '.$_SERVER['PHP_SELF']);
  } else {
    echo 'Failed to delete';
  }
}

if(isset($_POST['submit'])) {
  $copy = array();
  foreach($_POST as $key => $value) {
    $copy[$key] = mysqli_real_escape_string ($connect, $value);  
  }
  if(mysqli_query($connect, 'INSERT INTO participant(`participant_name`) VALUES ("'.$copy['participantName'].'")')) {
    mysqli_close($connect);
    header('Location: '.$_SERVER['PHP_SELF']);
  } else {
    echo 'Failed to add '. mysqli_error($connect);
  }  
}
?>

      <div class="col-sm-9 mt-5">
        <p class="bg-dark text-white p-2">List of Participants</p>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col"></th>         
              <th scope="col">Participant Name</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $index = 1;
            while ($row = mysqli_fetch_array($result)) {
              echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row['participant_name'] . '</td> 
              <td><a href="'.$_SERVER['PHP_SELF'].'?id='.$row['participant_id'].'">Delete</a></td>
              </tr>';
              $index++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <div>
      <button type="button" class="btn btn-danger icons fs-4 py-1" data-bs-toggle="modal" data-bs-target="#addParticipant">+</button>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addParticipant" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Participant</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="mb-3">
              <label class="form-label">Participant Name</label>
              <input type="text" class="form-control" id="participantName" name="participantName" placeholder="Participant Name" />
            </div>
            <input class="btn btn-success d-block ms-auto" name="submit" type="Submit" value="Submit">
          </form>
        </div>
      </div>
    </div>
  </div>
    
  
<?php
include('_adminincludes/footer.php')
?>