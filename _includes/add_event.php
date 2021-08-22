<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "events");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Escape user inputs for security
$a = mysqli_real_escape_string($link, $_REQUEST['ename']);
$b = mysqli_real_escape_string($link, $_REQUEST['date']);
$c = mysqli_real_escape_string($link, $_REQUEST['language']);
$d = mysqli_real_escape_string($link, $_REQUEST['location']);
$e = mysqli_real_escape_string($link, $_REQUEST['zone']);
 
// Attempt insert query execution
$sql = "INSERT INTO event2 (event_name, date, location, language, time_zone) VALUES ('$a', '$b', '$c', '$d', '$e')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
    header('Location: submit.php'); // submit.php is your main page where you list your all records
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>