<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');

$sql = "SELECT * FROM course";
$result = mysqli_query($connect, $sql);
$sqlForCategory = "SELECT * FROM category";
$resultForCategory = mysqli_query($connect, $sqlForCategory);
$sqlForLang = "SELECT * FROM language";
$resultForLang = mysqli_query($connect, $sqlForLang);
if (isset($_GET['id'])) {
  if (mysqli_query($connect, 'DELETE FROM course WHERE course_id =' . $_GET['id'])) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
    echo 'DELETE FROM course WHERE course_id =' . $_GET['id'];
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
  $addSQL = 'INSERT INTO course(`category_id`, `language_id`, `course_name`, `course_syllabus`, `course_description`, `course_comment`, `course_createdat`, `course_difficulty`, `course_hasexam`) VALUES ("' . $copy['catID'] . '","' . $copy['langID'] . '","' . $copy['courseName'] . '","' . $copy['courseSyll'] . '","' . $copy['courseDesc'] . '","' . $copy['courseComm'] . '",CURRENT_DATE(),"' . $copy['courseDiff'] . '","' . $copy['hasExam'] . '")';
  if (mysqli_query($connect, $addSQL)) {
    mysqli_close($connect);
    header('Location: ' . $_SERVER['PHP_SELF']);
  } else {
    echo 'Failed to add ' . mysqli_error($connect);
  }
}
?>

<div class="col-sm-9 mt-5">
  <p class="bg-dark text-white p-2">List of Courses</p>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Category</th>
        <th scope="col">Language</th>
        <th scope="col">Course Name</th>
        <th scope="col">Syllabus</th>
        <th scope="col">Description</th>
        <th scope="col">Comment</th>
        <th scope="col">Creation Date</th>
        <th scope="col">Difficulty</th>
        <th scope="col">Exam</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $index = 1; 
        while ($row = mysqli_fetch_assoc($result)) {
        
        $row2 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForCategory . ' where category_id = ' . $row['category_id']));
        $row3 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForLang . ' where language_id = "' . $row['language_id'].'"'));
        $b = '';
        if ($row['course_hasexam'] == 1) {
          $b = "Yes";
        } else {
          $b = "No";
        }
        echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row2['category_name'] . '</td>
              <td>' . $row3['language_name'] . '</td>
              <td>' . $row['course_name'] . '</td>
              <td>' . $row['course_syllabus'] . '</td>
              <td>' . $row['course_description'] . '</td>
              <td>' . $row['course_comment'] . '</td>
              <td>' . $row['course_createdat'] . '</td>
              <td>' . $row['course_difficulty'] . '</td>
              <td>' . $b . '</td>
              <td><a href="' . $_SERVER['PHP_SELF'] . '?id=' . $row['course_id'] . '">Delete</a></td>
              </tr>';
        $index++;
      } ?>
    </tbody>
  </table>
</div>
</div>
<div>
  <button type="button" class="btn btn-danger icons fs-4 py-1" data-bs-toggle="modal" data-bs-target="#addCourse">+</button>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addCourse" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <div class="mb-3">
            <label class="form-label">Category Name</label>
            <select class="form-select" name="catID">
              <option selected disabled>Category Name</option>
              <?php
              while ($row2 = mysqli_fetch_assoc($resultForCategory)) {
                echo '<option value="' . $row2['category_id'] . '">' . $row2['category_name'] . '</option>';
              } ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Language Name</label>
            <select class="form-select" name="langID">
              <option selected disabled>Language Name</option>
              <?php
              while ($row3 = mysqli_fetch_assoc($resultForLang)) {
                echo '<option value="' . $row3['language_id'] . '">' . $row3['language_name'] . '</option>';
              } ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Course Name</label>
            <input type="text" class="form-control" id="courseName" name="courseName" placeholder="Course Name" />
          </div>
          <div class="mb-3">
            <label class="form-label">Course Syll</label>
            <input type="text" class="form-control" id="courseSyll" name="courseSyll" placeholder="Course Syllabus" />
          </div>
          <div class="mb-3">
            <label class="form-label">Course Desc</label>
            <textarea name="courseDesc" placeholder="Description..." class="form-control" rows="5" style="resize: none;"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Course Comments</label>
            <input type="text" class="form-control" id="courseComm" name="courseComm" placeholder="Course Comments" />
          </div>
          <div class="mb-3">
            <label class="form-label">Course Difficulty</label>
            <input type="text" class="form-control" id="courseDiff" name="courseDiff" placeholder="Course Difficulty" />
          </div>
          <div class="mb-3">
          <label class="form-label">Does the course have a exam?</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="hasExam" id="hasExam1" value="1">
                <label class="form-check-label" for="hasExam1">
                  Yes
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="hasExam" id="hasExam2" value="0">
                <label class="form-check-label" for="hasExam2">
                  No
                </label>
              </div>
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