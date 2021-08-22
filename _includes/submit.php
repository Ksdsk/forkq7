<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap 5 -->
  <link rel="stylesheet" href="../custom-sass/main.min.css">
  <!-- global stylesheet -->
  <link rel="stylesheet" href="../css/global.css">
  <!-- custom css -->
  <link rel="stylesheet" href="../css/events-webinars.css">
  <title>Events and Webinars</title>
</head>

<body>

<header>


<!-- navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark" id="navbar">

<div class="bg-gold top-bar d-block" id="gold-bar">
  <div class="languages">
                <a href="#en" id='en' class="translate">English</a>
      <a href="#fr" id='fr' class="translate">Français</a>
  </div>
</div>

  <div class="container-fluid mt-5">
    <a class="navbar-brand" href="../index.html" id="logo"><img width="220px" id="logo_img" src="../images/Q7_white_nobg.png"
        alt="Company-logo"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mb-2 mb-lg-0 container-fluid">
        <li class="nav-item mx-xxl-3">
          <a class="nav-link lang" href="../about-us.html" key="about">ABOUT US</a>
        </li>
        <li class="nav-item mx-xxl-3">
          <a class="nav-link lang" href="../training.html" key="training">TRAINING</a>
        </li>
        <li class="nav-item mx-xxl-3">
          <a class="nav-link lang" href="../consulting.html" key="consulting">CONSULTING</a>
        </li>
        <li class="nav-item mx-xxl-3">
          <a class="nav-link lang" href="../events-webinars.html" key="events">EVENTS AND WEBINARS</a>
        </li>
        <li class="nav-item mx-xxl-3">
          <a class="nav-link lang" href="../contact-us.html" key="contact">CONTACT US</a>
        </li>
      </ul>
      <div class="nav-item col-lg-3 searchbar">
        <form class="d-flex input-group">
          <input class="form-control " type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-light" type="submit"><img id="search" src="../images/icons/magglass_gray.svg" alt="Search"
              width="25px" height="25px"></button>
        </form>
      </div>
    </div>
  </div>
</nav>
</header>


<!-- main image -->
<div class="p-5 text-dark main-image mb-5">
<div class="container-fluid pt-3 pb-5 row">
  <div class="col-md-6">
    <h1 class="display-5 fw-bold text-light">GROW YOUR CONNECTION</h1>
    <p class="text-light">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Commodi consequuntur laborum
      dicta suscipit voluptate mollitia molestias rem? Sunt consectetur similique minima hic odit assumenda eveniet?
    </p>
  </div>
  <div class="col-md-6">
    <div class="text-white col-md-6 container bg-dark me-0 py-3">
      <h5 class="fw-bold text-center border-bottom border-2 border-white pb-3">2022 ANNUAL Q7 TRAINING</h5>

      <div class="row">
        <div class="col-2 text-center py-3">
          <h2 class="fw-bold mb-0">27</h2>
          <p class="lh-1 lead mb-0">JUL</p>
        </div>
        <div class="col d-flex justify-content-center flex-column">
          <p class="mb-0 lh-1">SOME TRAINING</p>
          <p class="mb-0 lh-1">MONTREAL-3:00pm</p>
        </div>
      </div>

      <p class="mt-5">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consectetur expedita cum nihil
        dolorem laborum numquam mollitia. Unde laudantium porro vel.</p>
      <a href="" class="btn btn-gold text-white">LEARN MORE</a>
    </div>
  </div>
</div>
</div>

<div class="container">
<div class="col-lg-12">
<h2 class="mt-5">Events</h2>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "events";
// Create connection

$conn = new mysqli ($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
echo "Successful connection";

$result = mysqli_query($conn,"SELECT * FROM event2");

echo "<table class='table'>
<tr>
<th>Event</th>
<th>Date</th>
<th>Location</th>
<th>Language</th>
<th>Time Zone</th>
<th></th>
<th></th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['event_name'] . "</td>";
echo "<td>" . $row['date'] . "</td>";
echo "<td>" . $row['location'] . "</td>";
echo "<td>" . $row['language'] . "</td>";
echo "<td>" . $row['time_zone'] . "</td>";
echo "<td><a href='delete_event.php?id=".$row['id']."'>Delete</a></td>";
echo "</tr>";
}

echo "</table>";


$conn->close();

?>

</div>
</div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>
        <script src="../js/translations.js"></script>
        <!-- JQuery-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </body>
</html>