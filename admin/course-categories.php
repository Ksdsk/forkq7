<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
$sql = "SELECT * FROM category";
$sqlForDomain = "SELECT * FROM domain";
$resultForDomain = mysqli_query($connect, $sqlForDomain);
$result = mysqli_query($connect, $sql);
if(isset($_GET['id'])){
  if(mysqli_query($connect, 'DELETE FROM category WHERE category_id ='.$_GET['id'])) {
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
  if(mysqli_query($connect, 'INSERT INTO category(`domain_id`, `category_name`, `category_description`, `category_comment`) VALUES ("'.$copy['domainID'].'","'.$copy['categoryName'].'","'.$copy['categoryDesc'].'","'.$copy['categoryComm'].'")')) {
    mysqli_close($connect);
    header('Location: '.$_SERVER['PHP_SELF']);
  } else {
    echo 'Failed to add '. mysqli_error($connect);
  }  
}
?>

      <div class="col-sm-9 mt-5">
        <p class="bg-dark text-white p-2">List of Course-Categories</p>
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col">Domain Name</th>              
              <th scope="col">Category Name</th>
              <th scope="col">Category Description</th>
              <th scope="col">Category Comment</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $index = 1;
            while ($row = mysqli_fetch_array($result)) {
              
              $row2 = mysqli_fetch_assoc(mysqli_query($connect, $sqlForDomain.' where domain_id = '.$row['domain_id'])); 
              echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row2['domain_name'] . '</td>
              <td>' . $row['category_name'] . '</td>
              <td>' . $row['category_description'] . '</td>
              <td>' . $row['category_comment'] . '</td>
              <td><a href="'.$_SERVER['PHP_SELF'].'?id='.$row['category_id'].'">Delete</a></td>
              </tr>';
              $index++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <div>
      <button type="button" class="btn btn-danger icons fs-4 py-1" data-bs-toggle="modal" data-bs-target="#addCategory">+</button>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addCategory" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="mb-3">
              <label class="form-label">Domain Name</label>
              <select class="form-select" name="domainID">
                <option selected disabled>Domain Name</option>
                <?php 
                  while($row2 = mysqli_fetch_assoc($resultForDomain)) {
                    echo '<option value="'.$row2['domain_id'].'">'.$row2['domain_name'].'</option>';
                  }?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Category Name</label>
              <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Category Name" />
            </div>
            <div class="mb-3">
              <label class="form-label">Category Desc</label>
              <textarea name="categoryDesc" placeholder="Description..." class="form-control" rows="5" style="resize: none;"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Category Comments</label>
              <input type="text" class="form-control" id="categoryComm" name="categoryComm" placeholder="Category Comments" />
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