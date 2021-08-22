<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
$sql = "SELECT * FROM language";

$result = mysqli_query($connect, $sql);
if(isset($_GET['id'])){
  if(mysqli_query($connect, 'DELETE FROM language WHERE language_id =\''.$_GET['id']."'")) {
    mysqli_close($connect);
    header('Location: '.$_SERVER['PHP_SELF']);
  } else {
    echo 'Failed to delete';
  }
}

if(isset($_POST['submit'])) {
  //escaping string for safety
  $copy = array();
  foreach($_POST as $key => $value) {
    $copy[$key] = mysqli_real_escape_string ($connect, $value);
  }
  if(mysqli_query($connect, 'INSERT INTO language VALUES ("'.$copy['languageID'].'","'.$copy['languageName'].'","'.$copy['languageComm'].'")')) {
    mysqli_close($connect);
    header('Location: '.$_SERVER['PHP_SELF']);
  } else {
    echo 'Failed to add '. mysqli_error($connect);
  }  
}
?>

      <div class="col-sm-9 mt-5">
        <p class="bg-dark text-white p-2">List of Languages</p>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Language ID</th>         
              <th scope="col">Language Name</th>
              <th scope="col">Language Comment</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_array($result)) {
              echo '<tr>
              <th scope="row">' . $row['language_id'] . '</th>
              <td>' . $row['language_name'] . '</td>            
              <td>' . $row['language_comment'] . '</td>
              <td><a href="'.$_SERVER['PHP_SELF'].'?id='.$row['language_id'].'">Delete</a></td>
              </tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <div>
      <button type="button" class="btn btn-danger icons fs-4 py-1" data-bs-toggle="modal" data-bs-target="#addLanguage">+</button>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addLanguage" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Language</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="mb-3">
              <label class="form-label">Language ID</label>
              <input type="text" class="form-control" id="languageID" name="languageID" placeholder="Language ID" />
            </div>
            <div class="mb-3">
              <label class="form-label">Language Name</label>
              <input type="text" class="form-control" id="languageName" name="languageName" placeholder="Language Name" />
            </div>
            <div class="mb-3">
              <label class="form-label">Language Comments</label>
              <input type="text" class="form-control" id="languageComm" name="languageComm" placeholder="Language Comments" />
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