<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
//display the course name of the in person offering and all the students in it
$sql = "SELECT * FROM in_person_enrollment WHERE in_person_offering_id = ".$_GET["IoID"];
$sqlForCourse = "SELECT * FROM course WHERE course_id = (SELECT course_id FROM in_person_offering where in_person_offering_id= ".$_GET['IoID'].")";
$sqlForStudent = "SELECT * FROM participant";
$resultForStudent = mysqli_query($connect, $sqlForStudent);
$result = mysqli_query($connect, $sql);
$resultForCourse = mysqli_query($connect, $sqlForCourse);
if(isset($_GET['id'])){
  if(mysqli_query($connect, 'DELETE FROM in_person_enrollment WHERE in_person_enrollment_id ='.$_GET['id'])) {
    mysqli_close($connect);
    header('Location: inperson-enrollment.php?IoID='.$_GET['IoID']);
  } else {
    echo 'Failed to delete';
  }
}

if(isset($_POST['submit'])) {
  $insert = 'INSERT INTO in_person_enrollment(`participant_id`,`in_person_offering_id`) VALUES ("'.$_POST['studentID'].'","'.$_GET['IoID'].'")';
  if(mysqli_query($connect, $insert)) {
    mysqli_close($connect);
    header('Location: inperson-enrollment.php?IoID='.$_GET['IoID']);
  } else {
    echo 'Failed to add '. mysqli_error($connect);
  }  
}
?>

      <div class="col-sm-9 mt-5">
        <p class="bg-dark text-white p-2">List of Current Enrollments in In Person Course <?= mysqli_fetch_assoc($resultForCourse)['course_name'];?></p>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Student Name</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $index = 1;
            while ($row = mysqli_fetch_array($result)) {
              $row3 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForStudent.' where participant_id = '.$row['participant_id'])); 
              echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row3['participant_name'] . '</td>            
              <td><a href="'.$_SERVER['PHP_SELF'].'?id='.$row['in_person_enrollment_id'].'">Delete</a></td>
              </tr>';
              $index++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <div>
      <button type="button" class="btn btn-danger icons fs-4 py-1" data-bs-toggle="modal" data-bs-target="#addEnrollmment">+</button>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addEnrollmment" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Enrollmment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="mb-3">
              <label class="form-label">Student Name</label>
              <select class="form-select" name="studentID">
                <option selected disabled>Student Name</option>
                <?php 
                  while($row3 = mysqli_fetch_assoc($resultForStudent)) {
                    echo '<option value="'.$row3['participant_id'].'">'.$row3['participant_name'].'</option>';
                  }?>
              </select>
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