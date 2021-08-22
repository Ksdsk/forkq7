<?php
include('_adminincludes/db_connection_user.php');

if (isset($_POST['submit'])) {
  $username = $_POST["user"];
  $password = $_POST["pass"];

  // Get hashedpw
  $pwsql = "SELECT person_hashedpassword FROM person_detail WHERE person_username ='".$username."'";
  $pwresult = mysqli_query($connect, $pwsql);
  if (mysqli_num_rows($pwresult) == 0) { // returned nothing
    echo "username or password incorrect";
  } else {
    $row = $pwresult->fetch_assoc();
    $hash = $row['person_hashedpassword'];
    if (password_verify($password,$hash)) { // verify password
      session_start();
      $_SESSION['username'] = $username;
      header('location: admin.php');
    } else {
      echo "username or password incorrect";
    }
  }

  // if ($username == 'test' && $password == 'test') {
  //   session_start();
  //   $_SESSION['username'] = $username;
  //   header('location: admin.php');
  // } else {
  //   echo "username or password incorrect";
  // }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>LOGIN</title>
  <link rel="stylesheet" href="../custom-sass/main.min.css">
</head>

<body onload="translateiso2ToNames()">

  <div class="container mt-5 shadow px-0">
    <h1 class="bg-dark text-white text-center py-3">Login Form</h1>
    <div class="d-flex justify-content-center">
      <div class="w-50 p-4">
        <div>
          <form action="#" method="POST">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" class="form-control" id="user" name="user" autocomplete="off"/>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" id="pass" name="pass" />
            </div>
            <input type="submit" name="submit" value="Login" class="btn btn-lg btn-success">
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>