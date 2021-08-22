<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
$sql = "SELECT * FROM online_offering";
$sqlForCourse = "SELECT * FROM course";
$resultForCourse = mysqli_query($connect, $sqlForCourse);
$sqlForTrainer = "SELECT * FROM trainer";
$resultForTrainer = mysqli_query($connect, $sqlForTrainer);
$result = mysqli_query($connect, $sql);
if (isset($_GET['id'])) {
  if (mysqli_query($connect, 'DELETE FROM online_offering WHERE online_offering_id =' . $_GET['id'])) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
  } else {
    echo 'Failed to delete';
  }
}

if (isset($_POST['submit'])) {
  //escaping string for safety
  $copy = array();
  foreach($_POST as $key => $value) {
    $copy[$key] = mysqli_real_escape_string ($connect, $value);  
  }
  $insert = 'INSERT INTO online_offering (`course_id`, `trainer_id`, `offering_startdate`, `offering_enddate`, `offering_starttime`, `offering_endtime`, `offering_price`, `offering_isprivate`, `offering_maxstudents`, `offering_minstudents`) VALUES ("'  . $_POST['courseID'] . '","' . $_POST['trainerID'] . '","' . $_POST['stDate'] . '","' . $_POST['endDate'] . '","' . $_POST['stTime'] .':00'. '","' . $_POST['endTime'].':00' . '","' . $_POST['price'] . '","' . $_POST['priOrNot'] . '","' . $_POST['maxStu'] . '","' . $_POST['minStu'] . '")';
  if (mysqli_query($connect, $insert)) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
  } else {
    echo 'Failed to add' . mysqli_error($connect);
  }
}
?>

<div class="col-sm-9 mt-5">
  <p class="bg-dark text-white p-2">List of Current Online Offerings</p>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Course Name</th>
        <th scope="col">Trainer Name</th>
        <th scope="col">From - to dates</th>
        <th scope="col">Timings</th>
        <th scope="col">Price</th>
        <th scope="col">Private?</th>
        <th scope="col">Size</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $index = 1;
      while ($row = mysqli_fetch_array($result)) {
        
        $row2 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForCourse . ' where course_id = ' . $row['course_id']));
        if ($row['offering_isprivate'] == 1) {
          $b = "Yes";
        } else {
          $b = "No";
        }
        $row3 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForTrainer . ' where trainer_id = ' . $row['trainer_id']));
        echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row2['course_name'] . '</td>            
              <td>' . $row3['trainer_name'] . '</td>            
              <td>' . $row['offering_startdate'] . ' - ' . $row['offering_enddate'] . '</td>            
              <td>' . $row['offering_starttime'] . ' - ' . $row['offering_endtime'] . '</td>            
              <td>' . $row['offering_price'] . '</td>            
              <td>' . $b . '</td>            
              <td>' . $row['offering_maxstudents'] . ' - ' . $row['offering_minstudents'] . '</td>
              <td><div><a href="'.$_SERVER['PHP_SELF'].'?id='.$row['online_offering_id'].'">Delete</a></div><div><a href="'.'online-enrollment.php'.'?OoID='.$row['online_offering_id'].'">See enrollments</a></div></td>
              </tr>';
        $index++;
      }
      ?>
    </tbody>
  </table>
</div>
</div>
<div>
  <button type="button" class="btn btn-danger icons fs-4 py-1" data-bs-toggle="modal" data-bs-target="#addOffering">+</button>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addOffering" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Offering</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <div class="mb-3">
            <label class="form-label">Course Name</label>
            <select class="form-select" name="courseID">
              <option selected disabled>Course Name</option>
              <?php
              while ($row2 = mysqli_fetch_assoc($resultForCourse)) {
                echo '<option value="' . $row2['course_id'] . '">' . $row2['course_name'] . '</option>';
              } ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Trainer Name</label>
            <select class="form-select" name="trainerID">
              <option selected disabled>Trainer Name</option>
              <?php
              while ($row3 = mysqli_fetch_assoc($resultForTrainer)) {
                echo '<option value="' . $row3['trainer_id'] . '">' . $row3['trainer_name'] . '</option>';
              } ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Start date</label>
            <input type="date" class="form-control" id="stDate" name="stDate" />
          </div>
          <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" class="form-control" id="endDate" name="endDate" />
          </div>
          <div class="mb-3">
            <label class="form-label">Start Time</label>
            <input type="text" class="form-control" id="stTime" name="stTime" placeholder="24H format HH:MM"/>
          </div>
          <div class="mb-3">
            <label class="form-label">End Time</label>
            <input type="text" class="form-control" id="endTime" name="endTime" placeholder="24H format HH:MM"/>
          </div>
          <div class="mb-3">
            <label class="form-label">Offering Price</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="Price" />
          </div>
          <div class="mb-3">
            <label class="form-label">Is it a Private Training</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="priOrNot" id="priOrNot1" value="1">
              <label class="form-check-label" for="priOrNot1">
                Yes
              </label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="priOrNot" id="priOrNot2" value="0">
              <label class="form-check-label" for="priOrNot2">
                No
              </label>
            </div>
            <div class="mb-3">
              <label class="form-label">Max Students</label>
              <input type="number" class="form-control" id="maxStu" name="maxStu" placeholder="Max Capacity" />
            </div>
            <div class="mb-3">
              <label class="form-label">Min Students</label>
              <input type="number" class="form-control" id="minStu" name="minStu" placeholder="Min Capacity" />
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