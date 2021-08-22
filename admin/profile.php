<?php
  session_start();
  include('_adminincludes/header.php');
  include('_adminincludes/db_connection_user.php');

  if(!isset($_SESSION['username'])) {
    header('location: login.php');
  } else {
    $sql = "SELECT * FROM person_detail WHERE person_username ='".$_SESSION['username']."'";
    $result = mysqli_query($connect, $sql);
    $row = $result->fetch_assoc();
  }

  if(isset($_POST['pfpsubmit'])) {
    $file = $_FILES['pfp'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));
    
    if ($fileError === 0) {
        if ($fileSize < 5000000) {
            $fileNameNew = uniqid('',true).".".$fileActualExt;
            $fileDestination = "../images/pfp/".$fileNameNew;
            move_uploaded_file($fileTmpName, $fileDestination);
            // delete previous user pfp from dir
            if ($row["person_profilepicture"] != "default.png") {
                unlink("../images/pfp/".$row["person_profilepicture"]);
            } else {
                echo "
                <script>
                    alert('Error: yippie.');
                </script>
                ";
            }
            $pfpsql = 'UPDATE person_detail SET person_profilepicture ="'.$fileNameNew.'" WHERE person_username = "'.$_SESSION['username'].'"';
            mysqli_query($connect, $pfpsql);
            mysqli_close($connect);
            header('Location: '.$_SERVER['PHP_SELF']);
        } else {
            // alert error
            echo "
            <script>
                alert('Error: Your file must be less than 5MB!');
                window.location.href='profile.php';
            </script>
            ";
        }
    } else {
        // alert error
        echo "
        <script>
            alert('Error: Could not upload your picture.');
            window.location.href='profile.php';
        </script>
        ";
    }
  }

  if(isset($_POST['epsubmit'])) {
    //escaping string for safety
    $copy = array();
    foreach($_POST as $key => $value) {
      $copy[$key] = mysqli_real_escape_string ($connect, $value);
    }
    $epsql = "UPDATE person_detail SET 
    person_firstname = '".$copy["firstName"]."'".
    ", person_lastname = '".$copy["lastName"]."'".
    ", person_streetaddress = '".$copy["streetaddress"]."'".
    ", person_country = '".$copy["country"]."'".
    ", person_state = '".$copy["state"]."'".
    ", person_city = '".$copy["city-choice"]."'".
    ", person_email = '".$copy["email"]."'".
    ", person_phone = '".$copy["phone"]."'";
    //check for optional fields
    if (!empty($copy["organization"])) {
        $epsql .= ", person_organization = '".$copy["organization"]."'";
    }
    if (!empty($copy["aptsuite"])) {
        $epsql .= ", person_aptsuite = '".$copy["aptsuite"]."'";
    }
    if (!empty($copy["q7email"])) {
        $epsql .= ", person_q7email = '".$copy["q7email"]."'";
    }
    if (!empty($copy["desc"])) {
        $epsql .= ", person_description = '".$copy["desc"]."'";
    }
    // finish sql with where query
    $epsql .= ' WHERE person_username = "'.$_SESSION['username'].'"';
    if(mysqli_query($connect, $epsql)) {
      mysqli_close($connect);
      header('Location: '.$_SERVER['PHP_SELF']);
    } else {
      echo 'Failed to edit profile '. mysqli_error($connect);
    }  
  }

  if(isset($_POST['pwsubmit'])) {
    //escaping string for safety
    $copy = array();
    foreach($_POST as $key => $value) {
      $copy[$key] = mysqli_real_escape_string ($connect, $value);
    }
    if (!password_verify($copy['currentPassword'],$row['person_hashedpassword'])) {
        // alert error
        echo "
        <script>
            alert('Error: Wrong Current Password');
            window.location.href='profile.php';
        </script>
        ";
    } else {
        $newhash = password_hash($copy['confirmPassword'],PASSWORD_DEFAULT);
        if(mysqli_query($connect, 'UPDATE person_detail SET person_hashedpassword = "'.$newhash.'" WHERE person_username = "'.$_SESSION['username'].'"')) {
          mysqli_close($connect);
          header('Location: _adminincludes/logout.php'); // log the user out after changing password
        } else {
          echo 'Failed to edit password '. mysqli_error($connect);
        }  
    }
  }
?>
<style>

    .required::after {
        content: ' *';
        color: red;
        font-size: 22px;
    }

    .not-required::after {
        content: ' ';
        font-size: 22px;
    }
    
    .loader {
        border: 8px solid #efebe0;
        border-top: 8px solid #35363a;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 2s linear infinite;
    }

    .img-wrapper{
        position: relative;
        border-radius: 5px 20px 5px;
        background: url(<?php echo '../images/pfp/'.$row["person_profilepicture"]; ?>);
        background-size: cover;
        width: 100%; 

    }
    .img-wrapper:after {
        content: "";
        display: block;
        padding-bottom: 100%;
    }
    .over-image {
        display: none;
    }

    .img-wrapper:hover {
        background:linear-gradient( #00000075,#00000075 ),  url(<?php echo '../images/pfp/'.$row["person_profilepicture"]; ?>);
        background-size: cover;
        /* min-width: 150px;
        min-height: 150px;   */
        cursor: pointer;
    }
    
    .img-wrapper:hover .over-image {
        display: block
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }
</style>
<body onload="translateiso2ToNames(); renderCountriesAndStore();getState();getCity();">
    <div class="col-sm-9">
        <div class="mt-5">
            <div id="loader" class="loader mx-auto mt-5"></div>
            <div id="showWhenReady" class="d-none">
                <div class="row">
                    <div class="col-xl-3 px-5 d-block">
                        <div class="img-wrapper d-flex justify-content-center align-items-center mx-auto" data-bs-toggle="modal" data-bs-target="#changepfp">
                            <div class="over-image">
                                <div class="d-flex justify-content-between">
                                    <span class="text-light pe-3">Change Profile Picture</span>
                                    <img src="../images/icons/edit_white_24dp.svg" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex mt-4 align-items-center">
                            <img src="../images/icons/person_black_24dp.svg" alt="">
                            <span class="ps-3 text-break">
                                <?php
                                    echo $row["person_username"];
                                ?>
                            </span>
                        </div>
                        <div class="d-flex mt-4 align-items-center">
                            <img src="../images/icons/call_black_24dp.svg" alt="">
                            <span class="ps-3 text-break">
                                <?php
                                    echo $row["person_phone"];
                                ?>
                            </span>
                        </div>
                        <div class="d-flex mt-4 align-items-center">
                            <img src="../images/icons/email_black_24dp.svg" alt="">
                            <span class="ps-3 text-break">
                                <?php
                                    echo $row["person_email"];
                                ?>
                            </span>
                        </div>
                        <div class="d-flex mt-4 align-items-center">
                            <img src="../images/icons/home_black_24dp.svg" alt="">
                            <?php
                                echo '<span id="location" class="'.$row['person_country'].'|'.$row['person_state'].'|'.$row['person_city'].' % ps-3 text-break">'.$row["person_streetaddress"].',&nbsp</span>';
                            ?>
                        </div>
                        <div class="d-flex mt-4 align-items-center">
                            <img src="../images/icons/business_black_24dp.svg" alt="">
                            <span class="ps-3 test-break">
                                <?php
                                    if (is_null($row["person_organization"])) {
                                        echo "-";
                                    } else {
                                        echo $row["person_organization"];
                                    }
                                ?>
                            </span>
                        </div>
                        <button type="button" class="my-4 w-100 mx-auto btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editprofile">Edit Profile</button>
                        <button type="button" class="mb-4 w-100 mx-auto btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#editpassword">Create a New Password</button>
                    </div>
                    <div class="col-xl-9 px-5">
                        <div class="border-bottom">
                            <h3 class="">
                                <?php
                                    echo $row["person_firstname"].'&nbsp'.$row["person_lastname"];
                                ?>
                            </h3>
                            <div class="d-flex">
                                <h6 class="pe-4 text-muted">
                                    <?php
                                        $rolesql = "SELECT role_name FROM `role` JOIN person_has_role USING (role_id) JOIN person USING (person_id) JOIN person_detail USING (person_detail_id)";
                                        $roleresult = mysqli_query($connect, $rolesql);
                                        while($rolerow = mysqli_fetch_array($roleresult)){
                                            echo $rolerow['role_name'];
                                    }
                                    ?>
                                </h6>
                            </div>

                        </div>

                        <br>
                        <p>
                            <?php
                                if (is_null($row["person_description"])) {
                                    echo "Add your own description by pressing the [Edit Profile] button!";
                                } else {
                                    echo nl2br($row["person_description"]);
                                }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div>
        <div class="modal fade" id="editprofile" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Edit Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="" method="POST">
                <div class="mb-3">
                <label for="firstName" class="form-label required">First Name</label>
                <input required type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $row['person_firstname'];?>" />
                </div>
                <div class="mb-3">
                <label for="lastName" class="form-label required">Last Name</label>
                <input required type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $row['person_lastname'];?>"/>
                </div>
                <div class="mb-3">
                <label for="desc" class="form-label">Profile Description</label>
                <textarea type="text" class="form-control" rows="10" id="desc" name="desc" value="<?php echo $row['person_description'];?>"></textarea>
                </div>
                <div class="mb-3">
                <label for="phone" class="form-label required">Phone Number</label>
                <input required type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['person_phone'];?>"/>
                </div>
                <div class="mb-3">
                <label for="email" class="form-label required">E-mail</label>
                <input required type="text" class="form-control" id="email" name="email" value="<?php echo $row['person_email'];?>"/>
                </div>
                <div class="mb-3">
                <label for="q7email" class="form-label">Q7 E-mail</label>
                <input type="text" class="form-control" id="q7email" name="q7email" value="<?php echo $row['person_q7email'];?>"/>
                </div>
                <div class="mb-3">
                <label for="organization" class="form-label">Organization</label>
                <input type="text" class="form-control" id="organization" name="organization" value="<?php echo $row['person_organization'];?>"/>
                </div>
                <div class="mb-3">
                <label for="streetaddress" class="form-label required">Street Address</label>
                <input required type="text" class="form-control" id="streetaddress" name="streetaddress" value="<?php echo $row['person_streetaddress'];?>"/>
                </div>
                <div class="mb-3">
                <label for="aptsuite" class="form-label">Apt / Suite</label>
                <input type="text" class="form-control" id="aptsuite" name="aptsuite" value="<?php echo $row['person_aptsuite'];?>"/>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label lang required" key="contact-country">Country</label>
                    <select required id="country" class="form-select" name="country" onchange="getState()">
                        <option value="" selected></option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="state" class="form-label lang required" key="contact-state">State</label>
                    <select required id="state" class="form-select" name="state" onchange="getCity()">
                        <option value="" selected></option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label lang required" key="contact-city">City</label>
                    <input required list="city" class="form-control" id="city-choice" name="city-choice"/>
                    <datalist id="city"  name="city">
                        <option value="" selected></option>
                    </datalist>
                </div>
                <div class="mb-3">
                <label class="form-label required">ZIP / Postal Code</label>
                <input required type="text" class="form-control" id="zip" name="zip" value="<?php echo $row['person_zipcode'];?>"/>
                </div>
                <input class="btn btn-success d-block ms-auto" name="epsubmit" type="Submit" value="Submit">
            </form>
            </div>
        </div>
        </div>
    </div>
    </div>


    <!-- Password Modal -->
    <div>
        <div class="modal fade" id="editpassword" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create a New Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                            <label class="form-label required">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password" />
                            </div>
                            <div class="mb-3">
                            <label class="form-label required">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" onkeyup="checkpw()"/>
                            </div>
                            <div class="mb-3">
                            <label class="form-label required">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm New Password" onkeyup="checkpw()" />
                            </div>
                            <div class="mb-3">
                                <p id="pwMatches"></p>
                            </div>
                            <input id="pwconfirmation" class="btn btn-success d-block ms-auto" name="pwsubmit" type="Submit" value="Submit" disabled>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Picture Modal -->
    <div>
        <div class="modal fade" id="changepfp" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Change your Profile Picture</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                            <label class="form-label required">Upload Profile Picture</label>
                            <input type="file" class="form-control" id="pfp" name="pfp" onchange="checkFileExtension()"/>
                            </div>
                            <div class="mb-3">
                                <p id="pfpCheck"></p>
                            </div>
                            <input id="pfpconfirmation" class="btn btn-success d-block ms-auto" name="pfpsubmit" type="Submit" value="Submit" disabled>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
    include('_adminincludes/footer.php')
    ?>
    <!-- countrycitystate api js -->
    <script src="../js/countrystatecity.js"></script>
    <script src="../js/translateiso2.js"></script>
    <!-- Check pw -->
    <script src="../js/checkpw.js"></script>
    <!-- Check pfp -->
    <script src="../js/checkfileext.js"></script>

</body>