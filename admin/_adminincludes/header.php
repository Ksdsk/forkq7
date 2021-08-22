<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap 5 -->
  <link rel="stylesheet" href="../custom-sass/main.min.css">
  <!-- custom css -->
  <link rel="stylesheet" href="admin.css">
  <title>Admin</title>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="index.html" id="logo">
      <img width="220px" id="logo_img" src="../images/Q7_white_nobg.png" alt="Company-logo">
    </a>
    <div>
      <a class="text-white fw-bolder" href="profile.php"><?= $_SESSION['username'] ?></a>
      <a class="btn btn-danger mx-4" href="_adminincludes/logout.php">Logout</a>
    </div>
  </nav>
  <!-- Sidebar -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3 col-md-2 bg-light pt-3">
        <ul class="nav nav-pills flex-column mb-auto">
          <li class="nav-item">
            <a href="#" class="nav-link side-link link-dark" aria-current="page">
              Home
            </a>
          </li>
          <li>
            <a href="language.php" class="nav-link link-dark side-link">
              Languages
            </a>
          </li>
          <li>
            <a href="trainer.php" class="nav-link link-dark side-link">
              Trainers
            </a>
          </li>
          <li>
            <a href="venue.php" class="nav-link link-dark side-link">
              Venues
            </a>
          </li>
          <li>
            <a href="student.php" class="nav-link link-dark side-link">
              Students
            </a>
          </li>
          <li>
            <a href="domain.php" class="nav-link link-dark side-link">
              Domains
            </a>
          </li>
          <li>
            <a href="partner.php" class="nav-link link-dark side-link">
              Partners
            </a>
          </li>
          <li>
            <div class="dropdown">
              <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Courses
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item side-link" href="course-categories.php">Course Categories</a></li>
                <li><a class="dropdown-item side-link" href="courses-type.php">Course-Types</a></li>
              </ul>
            </div>
          </li>
          <li>
            <div class="dropdown">
              <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Offerings
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item side-link" href="inperson-offering.php">In Person</a></li>
                <li><a class="dropdown-item side-link" href="online-offering.php">Online</a></li>
                <li><a class="dropdown-item side-link" href="virtual-offering.php">Virtual</a></li>
                <li><a class="dropdown-item side-link" href="partner-offering.php">Partner</a></li>
              </ul>
            </div>
          </li>
          <li>
            <a href="inquiries.php" class="nav-link link-dark side-link">
                Inquiries
            </a>
          </li>
        </ul>
      </div>


      