<?php
include_once "db_connection_inquiry.php";
// Check connection
if($connect === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$firstname = mysqli_real_escape_string($connect, $_POST['first-name']);
$lastname = mysqli_real_escape_string($connect, $_POST['last-name']);
$email = mysqli_real_escape_string($connect, $_POST['email']);
$phone = mysqli_real_escape_string($connect, $_POST['phone']);
$country = mysqli_real_escape_string($connect, $_POST['country']);
$state = mysqli_real_escape_string($connect, $_POST['state']);
$city = mysqli_real_escape_string($connect, $_POST['city-choice']);
$subject = mysqli_real_escape_string($connect, $_POST['subject']);
$message = mysqli_real_escape_string($connect, $_POST['message']);



// Attempt insert query execution
$sql = "INSERT INTO inquiry (inquiry_firstname, inquiry_lastname, inquiry_email, inquiry_phone, inquiry_country, inquiry_state, inquiry_city, inquiry_subject, inquiry_message, inquiry_datetime) 
        VALUES ('$firstname','$lastname','$email','$phone','$country','$state','$city','$subject','$message',UTC_TIMESTAMP())";
if(mysqli_query($connect, $sql)){
    echo "inquiry added successfully.";
    header('Location: ../contact-us.php?success');
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($connect);
    header('Location: ../contact-us.php?failure');
}


// Close connection
mysqli_close($connect);
?>