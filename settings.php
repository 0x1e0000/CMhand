<?php
session_start();
if (!isset($_SESSION['id_Users'])) {
   header('Location: index.php');
   exit();
}
require 'layout/head.php';
cssLink('settings');
require 'layout/navbar.php';
?>
<script type="text/javascript">
   //click Submit Avatar
   function upload_avatar(){
      $('#upload-avatar').click();
   }
   function upload_cover(){
      $('#upload-cover').click();
   }
</script>
<header id="profile">
   <div class="cover" style="<?php echo $cover;?>">
      <form class="img-cover" action="includes/uploadCover.inc.php" method="POST" enctype="multipart/form-data">
         <input type="file" name="file" id="img-cover" accept="image/*" class="d-none" onchange="upload_cover()">
         <label for="img-cover"><i class="fas fa-camera"></i></label>
         <button type="submit" name="upload-cover" id="upload-cover" class="d-none"></button>
      </form>
   </div>
   <div class="profile" style="<?php echo $avatar;?>">
      <form class="img-prof" action="includes/uploadAvatar.inc.php" method="POST" enctype="multipart/form-data">
         <input type="file" name="file" id="img-prof" accept="image/*" class="d-none" onchange="upload_avatar()">
         <label for="img-prof"><i class="fas fa-camera"></i></label>
         <button type="submit" name="upload-avatar" id="upload-avatar" class="d-none"></button>
      </form>
   </div>
   <h4 class="subtitle"><?php echo ucwords($_SESSION['firstname_Users']).' '.ucwords($_SESSION['lastname_Users']); ?>
      <span>(<?php echo $_SESSION['username_Users']; ?>)</span>
   </h4>
   <small class="small"><?php echo ucwords($_SESSION['skills_Users']); ?></small>
   <p class="paragraph">
      <?php echo $_SESSION['description_Users']; ?>
   </p>
   <div class="social-media">
      <?php
      $facebook = $_SESSION['facebookURL_Users'];
      $instagram = $_SESSION['instagramURL_Users'];
      $website = $_SESSION['websiteURL_Users'];

      if (!empty($facebook)) {
         echo "<a href='$facebook' target='_blank'><i class='fab fa-facebook-f px-2'></i></a>";
      }
      if (!empty($instagram)) {
         echo "<a href='$instagram' target='_blank'><i class='fab fa-instagram px-2'></i></a>";
      }
      if (!empty($website)) {
         echo "<a href='$website' target='_blank'><i class='fas fa-globe px-2'></i></a>";
      }
      ?>
   </div>
</header>
<div class="container small">
   <div class="text-center">
      <!-- Error Messages here -->
      <?php
         if (isset($_GET['error'])) {
            if ($_GET['error'] == 'emptyFields') {
               echo "<p class='alert alert-danger'>There is empty fields.</p>";
            }elseif($_GET['error'] == 'invalidEmail'){
               echo "<p class='alert alert-danger'>Invalid Email.</p>";
            }elseif($_GET['error'] == 'invalidFirstName'){
               echo "<p class='alert alert-danger'>Invalid first name characters.</p>";
            }elseif($_GET['error'] == 'invalidLastName'){
               echo "<p class='alert alert-danger'>Invalid last name characters.</p>";
            }elseif($_GET['error'] == 'invalidUsername'){
               echo "<p class='alert alert-danger'>Invalid username characters.</p>";
            }elseif($_GET['error'] == 'invalidPhone'){
               echo "<p class='alert alert-danger'>Don't use characters on phone field.</p>";
            }elseif($_GET['error'] == 'genderNotSelected'){
               echo "<p class='alert alert-danger'>Select your gender.</p>";
            }elseif($_GET['error'] == 'usernameOrEmailTaken'){
               echo "<p class='alert alert-danger'>this username or email already exist.</p>";
            }elseif($_GET['error'] == 'CheckPwd'){
               echo "<p class='alert alert-danger'>Password are not the same or you write the current password.</p>";
            }elseif($_GET['error'] == 'wrrongCurrentPassword'){
               echo "<p class='alert alert-danger'>Wrong Password.</p>";
            }elseif($_GET['error'] == 'sqlError'){
               echo "<p class='alert alert-info'>Ops! Something went wrong!</p>";
            }
         }elseif(isset($_GET['update'])){
            if ($_GET['update'] == 'success') {
               echo "<p class='alert alert-success'>information updates successfully.</p>";
            }
         }
      ?>
   </div>
</div>
<section class="container" id="settings">
   <ul class="nav nav-tabs paragraph" id="pills-tab" role="tablist">
      <li class="nav-item">
         <a class="nav-link active" id="piils-account-tab" data-toggle="pill" href="#piils-account" role="tab" aria-controls="piils-account" aria-selected="true">Account</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" id="pills-general-tab" data-toggle="pill" href="#pills-general" role="tab" aria-controls="pills-general" aria-selected="false">General</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" id="pills-password-tab" data-toggle="pill" href="#pills-password" role="tab" aria-controls="pills-password" aria-selected="false">Change Password</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" id="pills-urls-tab" data-toggle="pill" href="#pills-urls" role="tab" aria-controls="pills-urls" aria-selected="false">URLs</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" id="pills-others-tab" data-toggle="pill" href="#pills-others" role="tab" aria-controls="pills-others" aria-selected="false">Others</a>
      </li>
   </ul>
   <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade text-center show active" id="piils-account" role="tabpanel" aria-labelledby="piils-account-tab">
         <span class="paragraph">Identification : <span class="subtitle"><?php echo $_SESSION['id_Users']; ?></span></span>
         <br>
         <span class="paragraph">Member since : <span class="subtitle"><?php echo $_SESSION['joinDate_Users']; ?></span></span>
         <form action="includes/updateInfo.inc.php" method="POST">
            <input name="delete_account" class="paragraph text-danger btn btn-transparent" type="submit" value="Delete my account" onclick="return confirm('Are you sure you wanna delet your account?')">
         </form>
      </div>
      <div class="tab-pane fade" id="pills-general" role="tabpanel" aria-labelledby="pills-general-tab">
         <form class="subtitle text-dark" action="includes/updateInfo.inc.php" method="post">
            <div class="row">
               <div class="form-group col">
                  <label class="font-weight-bold">First Name</label>
                  <input name="firstname" type="text" class="form-control" placeholder="Enter your first name ..." value="<?php echo $_SESSION['firstname_Users']; ?>">
               </div>
               <div class="form-group col">
                  <label class="font-weight-bold">Last Name</label>
                  <input name="lastname" type="text" class="form-control" placeholder="Enter your last name ..." value="<?php echo $_SESSION['lastname_Users']; ?>">
               </div>
            </div>
            <div class="row">
               <div class="form-group col">
                  <label class="font-weight-bold">Username</label>
                  <input name="username" type="text" class="form-control" placeholder="Enter your username ..." value="<?php echo $_SESSION['username_Users']; ?>">
               </div>
               <div class="form-group col">
                  <label class="font-weight-bold">Email</label>
                  <input name="email" type="text" class="form-control" placeholder="Enter your email ..." value="<?php echo $_SESSION['email_Users']; ?>">
               </div>
            </div>
            <div class="row">
               <div class="form-group col">
                   <label class="font-weight-bold">Country</label>
                   <select name="country" class="form-control">
                     <?php echo '<option selected value="'.$_SESSION['country_Users'].'">'.$_SESSION['country_Users'].'</option>' ?>
                       <option value="United States">United States</option>
                       <option value="United Kingdom">United Kingdom</option>
                       <option value="Afghanistan">Afghanistan</option>
                       <option value="Albania">Albania</option>
                       <option value="Algeria">Algeria</option>
                       <option value="American Samoa">American Samoa</option>
                       <option value="Andorra">Andorra</option>
                       <option value="Angola">Angola</option>
                       <option value="Anguilla">Anguilla</option>
                       <option value="Antarctica">Antarctica</option>
                       <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                       <option value="Argentina">Argentina</option>
                       <option value="Armenia">Armenia</option>
                       <option value="Aruba">Aruba</option>
                       <option value="Australia">Australia</option>
                       <option value="Austria">Austria</option>
                       <option value="Azerbaijan">Azerbaijan</option>
                       <option value="Bahamas">Bahamas</option>
                       <option value="Bahrain">Bahrain</option>
                       <option value="Bangladesh">Bangladesh</option>
                       <option value="Barbados">Barbados</option>
                       <option value="Belarus">Belarus</option>
                       <option value="Belgium">Belgium</option>
                       <option value="Belize">Belize</option>
                       <option value="Benin">Benin</option>
                       <option value="Bermuda">Bermuda</option>
                       <option value="Bhutan">Bhutan</option>
                       <option value="Bolivia">Bolivia</option>
                       <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                       <option value="Botswana">Botswana</option>
                       <option value="Bouvet Island">Bouvet Island</option>
                       <option value="Brazil">Brazil</option>
                       <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                       <option value="Brunei Darussalam">Brunei Darussalam</option>
                       <option value="Bulgaria">Bulgaria</option>
                       <option value="Burkina Faso">Burkina Faso</option>
                       <option value="Burundi">Burundi</option>
                       <option value="Cambodia">Cambodia</option>
                       <option value="Cameroon">Cameroon</option>
                       <option value="Canada">Canada</option>
                       <option value="Cape Verde">Cape Verde</option>
                       <option value="Cayman Islands">Cayman Islands</option>
                       <option value="Central African Republic">Central African Republic</option>
                       <option value="Chad">Chad</option>
                       <option value="Chile">Chile</option>
                       <option value="China">China</option>
                       <option value="Christmas Island">Christmas Island</option>
                       <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                       <option value="Colombia">Colombia</option>
                       <option value="Comoros">Comoros</option>
                       <option value="Congo">Congo</option>
                       <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                       <option value="Cook Islands">Cook Islands</option>
                       <option value="Costa Rica">Costa Rica</option>
                       <option value="Cote D'ivoire">Cote D'ivoire</option>
                       <option value="Croatia">Croatia</option>
                       <option value="Cuba">Cuba</option>
                       <option value="Cyprus">Cyprus</option>
                       <option value="Czech Republic">Czech Republic</option>
                       <option value="Denmark">Denmark</option>
                       <option value="Djibouti">Djibouti</option>
                       <option value="Dominica">Dominica</option>
                       <option value="Dominican Republic">Dominican Republic</option>
                       <option value="Ecuador">Ecuador</option>
                       <option value="Egypt">Egypt</option>
                       <option value="El Salvador">El Salvador</option>
                       <option value="Equatorial Guinea">Equatorial Guinea</option>
                       <option value="Eritrea">Eritrea</option>
                       <option value="Estonia">Estonia</option>
                       <option value="Ethiopia">Ethiopia</option>
                       <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                       <option value="Faroe Islands">Faroe Islands</option>
                       <option value="Fiji">Fiji</option>
                       <option value="Finland">Finland</option>
                       <option value="France">France</option>
                       <option value="French Guiana">French Guiana</option>
                       <option value="French Polynesia">French Polynesia</option>
                       <option value="French Southern Territories">French Southern Territories</option>
                       <option value="Gabon">Gabon</option>
                       <option value="Gambia">Gambia</option>
                       <option value="Georgia">Georgia</option>
                       <option value="Germany">Germany</option>
                       <option value="Ghana">Ghana</option>
                       <option value="Gibraltar">Gibraltar</option>
                       <option value="Greece">Greece</option>
                       <option value="Greenland">Greenland</option>
                       <option value="Grenada">Grenada</option>
                       <option value="Guadeloupe">Guadeloupe</option>
                       <option value="Guam">Guam</option>
                       <option value="Guatemala">Guatemala</option>
                       <option value="Guinea">Guinea</option>
                       <option value="Guinea-bissau">Guinea-bissau</option>
                       <option value="Guyana">Guyana</option>
                       <option value="Haiti">Haiti</option>
                       <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                       <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                       <option value="Honduras">Honduras</option>
                       <option value="Hong Kong">Hong Kong</option>
                       <option value="Hungary">Hungary</option>
                       <option value="Iceland">Iceland</option>
                       <option value="India">India</option>
                       <option value="Indonesia">Indonesia</option>
                       <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                       <option value="Iraq">Iraq</option>
                       <option value="Ireland">Ireland</option>
                       <option value="Israel">Israel</option>
                       <option value="Italy">Italy</option>
                       <option value="Jamaica">Jamaica</option>
                       <option value="Japan">Japan</option>
                       <option value="Jordan">Jordan</option>
                       <option value="Kazakhstan">Kazakhstan</option>
                       <option value="Kenya">Kenya</option>
                       <option value="Kiribati">Kiribati</option>
                       <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                       <option value="Korea, Republic of">Korea, Republic of</option>
                       <option value="Kuwait">Kuwait</option>
                       <option value="Kyrgyzstan">Kyrgyzstan</option>
                       <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                       <option value="Latvia">Latvia</option>
                       <option value="Lebanon">Lebanon</option>
                       <option value="Lesotho">Lesotho</option>
                       <option value="Liberia">Liberia</option>
                       <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                       <option value="Liechtenstein">Liechtenstein</option>
                       <option value="Lithuania">Lithuania</option>
                       <option value="Luxembourg">Luxembourg</option>
                       <option value="Macao">Macao</option>
                       <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                       <option value="Madagascar">Madagascar</option>
                       <option value="Malawi">Malawi</option>
                       <option value="Malaysia">Malaysia</option>
                       <option value="Maldives">Maldives</option>
                       <option value="Mali">Mali</option>
                       <option value="Malta">Malta</option>
                       <option value="Marshall Islands">Marshall Islands</option>
                       <option value="Martinique">Martinique</option>
                       <option value="Mauritania">Mauritania</option>
                       <option value="Mauritius">Mauritius</option>
                       <option value="Mayotte">Mayotte</option>
                       <option value="Mexico">Mexico</option>
                       <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                       <option value="Moldova, Republic of">Moldova, Republic of</option>
                       <option value="Monaco">Monaco</option>
                       <option value="Mongolia">Mongolia</option>
                       <option value="Montserrat">Montserrat</option>
                       <option value="Morocco">Morocco</option>
                       <option value="Mozambique">Mozambique</option>
                       <option value="Myanmar">Myanmar</option>
                       <option value="Namibia">Namibia</option>
                       <option value="Nauru">Nauru</option>
                       <option value="Nepal">Nepal</option>
                       <option value="Netherlands">Netherlands</option>
                       <option value="Netherlands Antilles">Netherlands Antilles</option>
                       <option value="New Caledonia">New Caledonia</option>
                       <option value="New Zealand">New Zealand</option>
                       <option value="Nicaragua">Nicaragua</option>
                       <option value="Niger">Niger</option>
                       <option value="Nigeria">Nigeria</option>
                       <option value="Niue">Niue</option>
                       <option value="Norfolk Island">Norfolk Island</option>
                       <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                       <option value="Norway">Norway</option>
                       <option value="Oman">Oman</option>
                       <option value="Pakistan">Pakistan</option>
                       <option value="Palau">Palau</option>
                       <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                       <option value="Panama">Panama</option>
                       <option value="Papua New Guinea">Papua New Guinea</option>
                       <option value="Paraguay">Paraguay</option>
                       <option value="Peru">Peru</option>
                       <option value="Philippines">Philippines</option>
                       <option value="Pitcairn">Pitcairn</option>
                       <option value="Poland">Poland</option>
                       <option value="Portugal">Portugal</option>
                       <option value="Puerto Rico">Puerto Rico</option>
                       <option value="Qatar">Qatar</option>
                       <option value="Reunion">Reunion</option>
                       <option value="Romania">Romania</option>
                       <option value="Russian Federation">Russian Federation</option>
                       <option value="Rwanda">Rwanda</option>
                       <option value="Saint Helena">Saint Helena</option>
                       <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                       <option value="Saint Lucia">Saint Lucia</option>
                       <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                       <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
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
                       <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                       <option value="Spain">Spain</option>
                       <option value="Sri Lanka">Sri Lanka</option>
                       <option value="Sudan">Sudan</option>
                       <option value="Suriname">Suriname</option>
                       <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                       <option value="Swaziland">Swaziland</option>
                       <option value="Sweden">Sweden</option>
                       <option value="Switzerland">Switzerland</option>
                       <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                       <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                       <option value="Tajikistan">Tajikistan</option>
                       <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                       <option value="Thailand">Thailand</option>
                       <option value="Timor-leste">Timor-leste</option>
                       <option value="Togo">Togo</option>
                       <option value="Tokelau">Tokelau</option>
                       <option value="Tonga">Tonga</option>
                       <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                       <option value="Tunisia">Tunisia</option>
                       <option value="Turkey">Turkey</option>
                       <option value="Turkmenistan">Turkmenistan</option>
                       <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                       <option value="Tuvalu">Tuvalu</option>
                       <option value="Uganda">Uganda</option>
                       <option value="Ukraine">Ukraine</option>
                       <option value="United Arab Emirates">United Arab Emirates</option>
                       <option value="United Kingdom">United Kingdom</option>
                       <option value="United States">United States</option>
                       <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                       <option value="Uruguay">Uruguay</option>
                       <option value="Uzbekistan">Uzbekistan</option>
                       <option value="Vanuatu">Vanuatu</option>
                       <option value="Venezuela">Venezuela</option>
                       <option value="Viet Nam">Viet Nam</option>
                       <option value="Virgin Islands, British">Virgin Islands, British</option>
                       <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                       <option value="Wallis and Futuna">Wallis and Futuna</option>
                       <option value="Western Sahara">Western Sahara</option>
                       <option value="Yemen">Yemen</option>
                       <option value="Zambia">Zambia</option>
                       <option value="Zimbabwe">Zimbabwe</option>
                   </select>
               </div>
               <div class="form-group col">
                  <label class="font-weight-bold">Phone Number</label>
                  <input name="phone" type="text" class="form-control" placeholder="Enter your  phone number ..." value="<?php echo $_SESSION['phone_Users']; ?>">
               </div>
            </div>
            <div class="row">
               <label class="font-weight-bold col-12">Gender</label>
               <div class="col-12">
                  <div class="form-check d-inline-block mr-3">
                     <input name="gender" id="male" class="form-check-input" type="radio" value="male" <?php if ($_SESSION['gender_Users']=="male") echo "checked";?>>
                     <label for="male" class="form-check-label">
                        Male
                     </label>
                  </div>
                  <div class="form-check d-inline-block mr-3">
                     <input name="gender" id="female" class="form-check-input" type="radio" value="female" <?php if ($_SESSION['gender_Users']=="female") echo "checked";?>>
                     <label for="female" class="form-check-label">
                        Female
                     </label>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col text-right">
                  <a href="settings.php" class="btn cancel">Cancel</a>
                  <button name="updateGeneral" type="submit" class="btn btn-main px-5">Save</button>
               </div>
            </div>
         </form>
      </div>
      <div class="tab-pane fade" id="pills-password" role="tabpanel" aria-labelledby="pills-password-tab">
         <form class="subtitle text-dark" action="includes/updateInfo.inc.php" method="post">
            <div class="row">
               <div class="form-group col">
                  <label class="font-weight-bold">Current Password</label>
                  <input name="currentPassword" type="password" class="form-control" placeholder="Current password...">
               </div>
               <div class="form-group col">
                  <label class="font-weight-bold">New Password</label>
                  <input name="newPassword" type="password" class="form-control" placeholder="New password...">
               </div>
               <div class="form-group col">
                  <label class="font-weight-bold">Confirm Password</label>
                  <input name="confirmPassword" type="password" class="form-control" placeholder="Repeat new password...">
               </div>
            </div>
            <div class="row">
               <div class="col text-right">
                  <a href="settings.php" class="btn cancel">Cancel</a>
                  <button type="submit" name="updatePassword" class="btn btn-main px-5">Save</button>
               </div>
            </div>
            <div class="row">
               <div class="col mt-3 text-center">
                  <!-- Error Messages here -->
                  <!--<p class="alert alert-danger">Lorem ipsum dolor sit amet, consectetur adipisicing.</p-->
               </div>
            </div>
         </form>
      </div>
      <div class="tab-pane fade" id="pills-urls" role="tabpanel" aria-labelledby="pills-urls-tab">
         <form class="subtitle text-dark" action="includes/updateInfo.inc.php" method="post">
            <div class="row">
               <div class="form-group col">
                  <label class="font-weight-bold">Facebook</label>
                  <div class="input-group mb-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fab fa-facebook-f"></i></div>
                     </div>
                     <input name="facebookURL" type="text" class="form-control" placeholder="http:// ..." value="<?php echo $_SESSION['facebookURL_Users']; ?>">
                  </div>
               </div>
               <div class="form-group col">
                  <label class="font-weight-bold">Instagram</label>
                  <div class="input-group mb-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fab fa-instagram"></i></div>
                     </div>
                     <input name="instagramURL" type="text" class="form-control" placeholder="http:// ..." value="<?php echo $_SESSION['instagramURL_Users']; ?>">
                  </div>
               </div>
               <div class="form-group col">
                  <label class="font-weight-bold">WebSite</label>
                  <div class="input-group mb-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-globe"></i></div>
                     </div>
                     <input name="websiteURL" type="text" class="form-control" placeholder="http:// ..." value="<?php echo $_SESSION['websiteURL_Users']; ?>">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col text-right">
                  <a href="settings.php" class="btn cancel">Cancel</a>
                  <button type="submit" name="updateURLs" class="btn btn-main px-5">Save</button>
               </div>
            </div>
            <div class="row">
               <div class="col mt-3 text-center">
                  <!-- Error Messages here -->
                  <!--<p class="alert alert-danger">Lorem ipsum dolor sit amet, consectetur adipisicing.</p-->
               </div>
            </div>
         </form>
      </div>
      <div class="tab-pane fade" id="pills-others" role="tabpanel" aria-labelledby="pills-others-tab">
         <form class="subtitle text-dark" action="includes/updateInfo.inc.php" method="post">
            <div class="row">
               <div class="form-group col">
                  <label class="font-weight-bold">Skills</label>
                  <input name="skills" type="text" class="form-control" placeholder="Example : Web Designer, Dancer, ..." value="<?php echo $_SESSION['skills_Users']; ?>">
               </div>
            </div>
            <div class="row">
               <div class="form-group col">
                  <label class="font-weight-bold">Description</label>
                  <textarea name="description" rows="8" cols="80" class="form-control" placeholder="Write your discription here ... (1000 Word)"><?php echo $_SESSION['description_Users']; ?></textarea>
               </div>
            </div>
            <div class="row">
               <div class="col text-right">
                  <a href="settings.php" class="btn cancel">Cancel</a>
                  <button type="submit" name="updateOthers" class="btn btn-main px-5">Save</button>
               </div>
            </div>
            <div class="row">
               <div class="col mt-3 text-center">
                  <!-- Error Messages here -->
                  <!--<p class="alert alert-danger">Lorem ipsum dolor sit amet, consectetur adipisicing.</p-->
               </div>
            </div>
         </form>
      </div>
   </div>
</section>

<?php
include 'layout/footer.php';
require 'layout/plugins.php';
?>
