<?php
session_start();
if(!isset($_SESSION['username'])) {
  header('location: login.php');
}
include('_adminincludes/header.php');
include('_adminincludes/db_connection.php');
$sql = "SELECT * FROM trainer";
$sqlforLang = "SELECT * FROM language;";
$resultforLang = mysqli_query($connect, $sqlforLang);
$sqlforDom = "SELECT * FROM domain;";
$resultforDom = mysqli_query($connect, $sqlforDom);
$result = mysqli_query($connect, $sql);
if (isset($_GET['id'])) {
  if (mysqli_query($connect, 'DELETE FROM trainer WHERE trainer_id =' . $_GET['id'])) {
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
    if($key != 'lang' && $key != 'dom') {
      $copy[$key] = mysqli_real_escape_string ($connect, $value);
    }    
  }
  $insertInTKL = 'INSERT INTO trainer_knows_language VALUES ';
  $insertInTTD = 'INSERT INTO trainer_teaches_domain VALUES ';
  $valuesToAdd = array(); 
  // query for trainer
  if (mysqli_query($connect, 'INSERT INTO trainer(`trainer_name`, `trainer_q7email`, `trainer_extemail`, `trainer_phone`, `trainer_country`, `trainer_state`, `trainer_city`, `trainer_streetaddress`, `trainer_aptsuite`, `trainer_accreditation`, `trainer_datejoined`, `trainer_level`) VALUES ("' . $copy['trainerName'] . '","' . $copy['trainerQ7em'] . '","' . $copy['trainerem'] . '","' . $copy['trainerPhone'] . '","' . $copy['country'] . '","'. $copy['trainerSta'] . '","'. $copy['trainerCity'] . '","' . $copy['trainerSA'] . '","' . $copy['trainerApt'] . '","' . $copy['trainerAccr'] . '","' . $copy['trainerDateJoin'] . '","' . $copy['trainerLev'] . '")')) {
    //id from last insertion in trainer table
    $id = mysqli_query($connect, "SELECT MAX(trainer_id) FROM trainer");
    $id = mysqli_fetch_array($id)[0];
    foreach($_POST["lang"] as $lang) {
      $valuesToAdd[] = "('".$id."','".$lang."')";
    }
    // preparing sql for trainer_knows_language
    $insertInTKL .= implode(", ", $valuesToAdd);
    $valuesToAdd = array();
    foreach($_POST["dom"] as $dom) {
      $valuesToAdd[] = "('".$id."','".$dom."')";
    }
    // preparing sql for trainer_teaches_domain    
    $insertInTTD .= implode(", ", $valuesToAdd);
    if(mysqli_query($connect, $insertInTKL)) {
      if(mysqli_query($connect, $insertInTTD)) {
        mysqli_close($connect);
        header('Location: ' . $_SERVER['PHP_SELF']);
      }      
    }
  } else {
    echo 'Failed to add' . mysqli_error($connect);
  }
}
?>

<div class="col-sm-9 mt-5">
  <p class="bg-dark text-white p-2">List of Trainers</p>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">Name</th>
        <th scope="col">Q7 Email</th>
        <th scope="col">Email</th>
        <th scope="col">Phone</th>
        <th scope="col">Country</th>
        <th scope="col">State</th>
        <th scope="col">Location</th>
        <th scope="col">Language</th>
        <th scope="col">Domain</th>
        <th scope="col">Accreditation</th>
        <th scope="col">Join Date</th>
        <th scope="col">Level</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $index = 1;
      while ($row = mysqli_fetch_array($result)) {
        
        $sqlForTKL = 'SELECT * FROM trainer_knows_language WHERE trainer_id = '.$row["trainer_id"];
        $lan = [];
        //concatenating languages a trainer knows and concatenating
        $resultForTKL = mysqli_query($connect, $sqlForTKL);
        while($row1 = mysqli_fetch_assoc($resultForTKL)) {
          $lan[] = $row1['language_id'];
        }
        //concatenating domains a trainer teaches
        $sqlForTTD = 'SELECT * FROM trainer_teaches_domain WHERE trainer_id = '.$row["trainer_id"];
        $dom = [];
        $resultForTTD = mysqli_query($connect, $sqlForTTD);
        while($row2 = mysqli_fetch_assoc($resultForTTD)) {
          $dom[] = $row2['domain_id'];
        }
        
        echo '<tr>
              <th scope="row">' . $index . '</th>
              <td>' . $row['trainer_name'] . '</td>            
              <td>' . $row['trainer_q7email'] . '</td>
              <td>' . $row['trainer_extemail'] . '</td>
              <td>' . $row['trainer_phone'] . '</td>
              <td>' . $row['trainer_country'] . '</td>
              <td>' . $row['trainer_state'] . '</td>
              <td>' . $row['trainer_aptsuite'].', '.$row['trainer_streetaddress'].', '.$row['trainer_city'] .  '</td>
              <td>' . implode(", ", $lan) . '</td>
              <td>' . implode(", ", $dom) . '</td>
              <td>' . $row['trainer_accreditation'] . '</td>
              <td>' . $row['trainer_datejoined'] . '</td>
              <td>' . $row['trainer_level'] . '</td>
              <td><a href="' . $_SERVER['PHP_SELF'] . '?id=' . $row['trainer_id'] . '">Delete</a></td>
              </tr>';
              $index++;
      }
      ?>
    </tbody>
  </table>
</div>
</div>
<div>
  <button type="button" class="btn btn-danger icons fs-4 py-1" data-bs-toggle="modal" data-bs-target="#addTrainer">+</button>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addTrainer" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Trainer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- form -->
        <form action="" method="POST">
          <div class="mb-3">
            <label class="form-label">Trainer Name</label>
            <input type="text" class="form-control" id="trainerName" name="trainerName" placeholder="Trainer Name" />
          </div>
          <div class="mb-3">
            <label class="form-label">Qualiti7 Email</label>
            <input type="email" class="form-control" id="trainerQ7em" name="trainerQ7em" placeholder="Trainer Q7 Email" />
          </div>
          <div class="mb-3">
            <label class="form-label">Qualiti7 Email</label>
            <input type="email" class="form-control" id="trainerem" name="trainerem" placeholder="Trainer Email" />
          </div>
          <div class="mb-3">
            <label class="form-label">Trainer Phone</label>
            <input type="text" class="form-control" id="trainerPhone" name="trainerPhone" placeholder="Trainer Phone" />
          </div>
          <div class="mb-3">
            <label class="form-label">Trainer Street Address</label>
            <input type="text" class="form-control" id="trainerSA" name="trainerSA" placeholder="Street Address" />
          </div>
          <div class="mb-3">
            <label class="form-label">Apartment/Suite Number</label>
            <input type="text" class="form-control" id="trainerApt" name="trainerApt" placeholder="Apartment/Suite Number" />
          </div>
          <div class="mb-3">
            <label class="form-label">Trainer Country</label>
            <select id="country" class="form-select" name="country">
              <option value="" selected disabled></option>
              <option value="Canada">Canada</option>
              <option value="United States">United States</option>
              <option value="France">France</option>
              <option value="India">India</option>
              <option value="Italy">Italy</option>
              <option value="Netherlands">Netherlands</option>
              <option value="Belgium">Belgium</option>
              <option value="Finland">Finland</option>
              <option value="United Kingdom">United Kingdom</option>
              <option value="Cameroon">Cameroon</option>
              <option value="China">China</option>
              <option value="Indonesia">Indonesia</option>
              <option value="Japan">Japan</option>
              <option value="Afghanistan">Afghanistan</option>
              <option value="Albania">Albania</option>
              <option value="Algeria">Algeria</option>
              <option value="Andorra">Andorra</option>
              <option value="Antigua and Barbuda">Antigua and Barbuda</option>
              <option value="Argentina">Argentina</option>
              <option value="Armenia">Armenia</option>
              <option value="Australia">Australia</option>
              <option value="Austria">Austria</option>
              <option value="Azerbaijan">Azerbaijan</option>
              <option value="Bahamas">Bahamas</option>
              <option value="Bahrain">Bahrain</option>
              <option value="Bangladesh">Bangladesh</option>
              <option value="Barbados">Barbados</option>
              <option value="Belarus">Belarus</option>
              <option value="Belize">Belize</option>
              <option value="Benin">Benin</option>
              <option value="Bhutan">Bhutan</option>
              <option value="Bolivia">Bolivia</option>
              <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
              <option value="Botswana">Botswana</option>
              <option value="Brazil">Brazil</option>
              <option value="Brunei">Brunei</option>
              <option value="Bulgaria">Bulgaria</option>
              <option value="Burkina Faso">Burkina Faso</option>
              <option value="Burundi">Burundi</option>
              <option value="Cambodia">Cambodia</option>
              <option value="Cape Verde">Cape Verde</option>
              <option value="Central African Republic">Central African Republic</option>
              <option value="Chad">Chad</option>
              <option value="Chile">Chile</option>
              <option value="Colombia">Colombia</option>
              <option value="Comoros">Comoros</option>
              <option value="Congo">Congo</option>
              <option value="Costa Rica">Costa Rica</option>
              <option value="Cote d'Ivoire">Cote d'Ivoire</option>
              <option value="Croatia">Croatia</option>
              <option value="Cuba">Cuba</option>
              <option value="Cyprus">Cyprus</option>
              <option value="Czech Republic">Czech Republic</option>
              <option value="Denmark">Denmark</option>
              <option value="Djibouti">Djibouti</option>
              <option value="Dominica">Dominica</option>
              <option value="Dominican Republic">Dominican Republic</option>
              <option value="East Timor">East Timor</option>
              <option value="Ecuador">Ecuador</option>
              <option value="Egypt">Egypt</option>
              <option value="El Salvador">El Salvador</option>
              <option value="Equatorial Guinea">Equatorial Guinea</option>
              <option value="Eritrea">Eritrea</option>
              <option value="Estonia">Estonia</option>
              <option value="Ethiopia">Ethiopia</option>
              <option value="Fiji">Fiji</option>
              <option value="Gabon">Gabon</option>
              <option value="Gambia">Gambia</option>
              <option value="Georgia">Georgia</option>
              <option value="Germany">Germany</option>
              <option value="Ghana">Ghana</option>
              <option value="Greece">Greece</option>
              <option value="Grenada">Grenada</option>
              <option value="Guatemala">Guatemala</option>
              <option value="Guinea">Guinea</option>
              <option value="Guinea-Bissau">Guinea-Bissau</option>
              <option value="Guyana">Guyana</option>
              <option value="Haiti">Haiti</option>
              <option value="Honduras">Honduras</option>
              <option value="Hong Kong">Hong Kong</option>
              <option value="Hungary">Hungary</option>
              <option value="Iceland">Iceland</option>
              <option value="Iran">Iran</option>
              <option value="Iraq">Iraq</option>
              <option value="Ireland">Ireland</option>
              <option value="Israel">Israel</option>
              <option value="Jamaica">Jamaica</option>
              <option value="Jordan">Jordan</option>
              <option value="Kazakhstan">Kazakhstan</option>
              <option value="Kenya">Kenya</option>
              <option value="Kiribati">Kiribati</option>
              <option value="North Korea">North Korea</option>
              <option value="South Korea">South Korea</option>
              <option value="Kuwait">Kuwait</option>
              <option value="Kyrgyzstan">Kyrgyzstan</option>
              <option value="Laos">Laos</option>
              <option value="Latvia">Latvia</option>
              <option value="Lebanon">Lebanon</option>
              <option value="Lesotho">Lesotho</option>
              <option value="Liberia">Liberia</option>
              <option value="Libya">Libya</option>
              <option value="Liechtenstein">Liechtenstein</option>
              <option value="Lithuania">Lithuania</option>
              <option value="Luxembourg">Luxembourg</option>
              <option value="Macedonia">Macedonia</option>
              <option value="Madagascar">Madagascar</option>
              <option value="Malawi">Malawi</option>
              <option value="Malaysia">Malaysia</option>
              <option value="Maldives">Maldives</option>
              <option value="Mali">Mali</option>
              <option value="Malta">Malta</option>
              <option value="Marshall Islands">Marshall Islands</option>
              <option value="Mauritania">Mauritania</option>
              <option value="Mauritius">Mauritius</option>
              <option value="Mexico">Mexico</option>
              <option value="Micronesia">Micronesia</option>
              <option value="Moldova">Moldova</option>
              <option value="Monaco">Monaco</option>
              <option value="Mongolia">Mongolia</option>
              <option value="Montenegro">Montenegro</option>
              <option value="Morocco">Morocco</option>
              <option value="Mozambique">Mozambique</option>
              <option value="Myanmar">Myanmar</option>
              <option value="Namibia">Namibia</option>
              <option value="Nauru">Nauru</option>
              <option value="Nepal">Nepal</option>
              <option value="New Zealand">New Zealand</option>
              <option value="Nicaragua">Nicaragua</option>
              <option value="Niger">Niger</option>
              <option value="Nigeria">Nigeria</option>
              <option value="Norway">Norway</option>
              <option value="Oman">Oman</option>
              <option value="Pakistan">Pakistan</option>
              <option value="Palau">Palau</option>
              <option value="Panama">Panama</option>
              <option value="Papua New Guinea">Papua New Guinea</option>
              <option value="Paraguay">Paraguay</option>
              <option value="Peru">Peru</option>
              <option value="Philippines">Philippines</option>
              <option value="Poland">Poland</option>
              <option value="Portugal">Portugal</option>
              <option value="Puerto Rico">Puerto Rico</option>
              <option value="Qatar">Qatar</option>
              <option value="Romania">Romania</option>
              <option value="Russia">Russia</option>
              <option value="Rwanda">Rwanda</option>
              <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
              <option value="Saint Lucia">Saint Lucia</option>
              <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
              <option value="Samoa">Samoa</option>
              <option value="San Marino">San Marino</option>
              <option value="Sao Tome and Principe">Sao Tome and Principe</option>
              <option value="Saudi Arabia">Saudi Arabia</option>
              <option value="Senegal">Senegal</option>
              <option value="Serbia and Montenegro">Serbia and Montenegro</option>
              <option value="Seychelles">Seychelles</option>
              <option value="Sierra Leone">Sierra Leone</option>
              <option value="Singapore">Singapore</option>
              <option value="Slovakia">Slovakia</option>
              <option value="Slovenia">Slovenia</option>
              <option value="Solomon Islands">Solomon Islands</option>
              <option value="Somalia">Somalia</option>
              <option value="South Africa">South Africa</option>
              <option value="Spain">Spain</option>
              <option value="Sri Lanka">Sri Lanka</option>
              <option value="Sudan">Sudan</option>
              <option value="Suriname">Suriname</option>
              <option value="Swaziland">Swaziland</option>
              <option value="Sweden">Sweden</option>
              <option value="Switzerland">Switzerland</option>
              <option value="Syria">Syria</option>
              <option value="Taiwan">Taiwan</option>
              <option value="Tajikistan">Tajikistan</option>
              <option value="Tanzania">Tanzania</option>
              <option value="Thailand">Thailand</option>
              <option value="Togo">Togo</option>
              <option value="Tonga">Tonga</option>
              <option value="Trinidad and Tobago">Trinidad and Tobago</option>
              <option value="Tunisia">Tunisia</option>
              <option value="Turkey">Turkey</option>
              <option value="Turkmenistan">Turkmenistan</option>
              <option value="Tuvalu">Tuvalu</option>
              <option value="Uganda">Uganda</option>
              <option value="Ukraine">Ukraine</option>
              <option value="United Arab Emirates">United Arab Emirates</option>
              <option value="Uruguay">Uruguay</option>
              <option value="Uzbekistan">Uzbekistan</option>
              <option value="Vanuatu">Vanuatu</option>
              <option value="Vatican City">Vatican City</option>
              <option value="Venezuela">Venezuela</option>
              <option value="Vietnam">Vietnam</option>
              <option value="Yemen">Yemen</option>
              <option value="Zambia">Zambia</option>
              <option value="Zimbabwe">Zimbabwe</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Trainer State</label>
            <input type="text" class="form-control" id="trainerSta" name="trainerSta" placeholder="Trainer State" />
          </div>
          <div class="mb-3">
            <label class="form-label">Trainer City</label>
            <input type="text" class="form-control" id="trainerCity" name="trainerCity" placeholder="City" />
          </div>
          <div class="mb-3">
            <label class="form-label">Trainer Language</label>
            <?php
            while ($row1 = mysqli_fetch_assoc($resultforLang)) {
              echo '<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="' . $row1["language_id"] . '" name="lang[]" id="' . $row1["language_id"] . '">
                        <label class="form-check-label" for="' . $row1["language_id"] . '">'
                . $row1["language_name"] .
                '</label>
                      </div>';
            }
            ?>
          </div>
          <div class="mb-3">
            <label class="form-label">Trainer Domain</label>
            <?php
            while ($row2 = mysqli_fetch_assoc($resultforDom)) {
              echo '<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="' . $row2["domain_id"] . '" name="dom[]" id="' . $row2["domain_id"] . '">
                        <label class="form-check-label" for="' . $row2["domain_name"] . '">'
                . $row2["domain_name"] .
                '</label>
                      </div>';
            }
            ?>
          </div>
          <div class="mb-3">
            <label class="form-label">Trainer Accreditation</label>
            <input type="text" class="form-control" id="trainerAccr" name="trainerAccr" placeholder="Trainer Accrediation" />
          </div>
          <div class="mb-3">
            <label class="form-label">Trainer Join Date</label>
            <input type="date" class="form-control" id="trainerDateJoin" name="trainerDateJoin" />
          </div>
          <div class="mb-3">
            <label class="form-label">Trainer Level</label>
            <input type="text" class="form-control" id="trainerLev" name="trainerLev" placeholder="Trainer Level" />
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