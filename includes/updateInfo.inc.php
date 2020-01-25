<?php
if (isset($_POST['delete_account'])) {
   //Connect to database and start a sassion
   require 'dbh.inc.php';
   session_start();

   //Delete user row from database
   $query = "DELETE FROM users WHERE id_Users = ?;";
   $stmt = mysqli_stmt_init($connect);
   if(!mysqli_stmt_prepare($stmt, $query)){
      //if $query is NOT works
      header('Location: ../settings.php?error=sqlError');
      exit();
   }else {
      //if $query is works
      mysqli_stmt_bind_param($stmt, 's', $_SESSION['id_Users']);
      mysqli_stmt_execute($stmt);
      //Delete avatar and cover photos from uploads folder
      unlink('../img/uploads/covers/'.$_SESSION['cover_Users']);
      unlink('../img/uploads/avatars/'.$_SESSION['avatar_Users']);
   }
   //Close Connect to Database
   mysqli_stmt_close($stmt);
   mysqli_close($connect);
   //Logout the user
   session_unset();
   session_destroy();
   header('Location: ../index.php');
   exit();
}
elseif (isset($_POST['updateGeneral'])) {
   //Connect to database
   require 'dbh.inc.php';
   session_start();

   //Declar values from input fields.
   $firstname = strtolower($_POST['firstname']);
   $lastname = strtolower($_POST['lastname']);
   $username = strtolower($_POST['username']);
   $email = strtolower($_POST['email']);
   $country = $_POST['country'];
   $phone = $_POST['phone'];
   $gender = $_POST['gender'];

   //check an empty fields
   if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($country)) {
      header('Location: ../settings.php?error=emptyFields');
      exit();
   }
   //chack validation Email
   elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      header('Location: ../settings.php?error=invalidEmail');
      exit();
   }
   //check invalid firstname
   elseif(!preg_match("/^[a-zA-Z]*$/",$firstname)){
      header('Location: ../settings.php?error=invalidFirstName');
      exit();
   }
   //check invalid lastname
   elseif(!preg_match("/^[a-zA-Z ]*$/",$lastname)){
      header('Location: ../settings.php?error=invalidLastName');
      exit();
   }
   //check invalid username
   elseif(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
      header('Location: ../settings.php?error=invalidUsername');
      exit();
   }
   //check invalid phone number
   elseif(!preg_match("/^[0-9]*$/",$phone)){
      header('Location: ../settings.php?error=invalidPhone');
      exit();
   }
   elseif(!isset($_POST['gender'])){
     header('Location: ../settings.php?error=genderNotSelected');
     exit();
  }
  else{
      //setup info for inserting to database
      //check existing username and email in database
      $query = 'SELECT username_Users, email_Users FROM users WHERE (username_Users = ? OR email_Users = ?) AND id_Users != ?;';
      $stmt = mysqli_stmt_init($connect);
      //Check sql Errors
      if (!mysqli_stmt_prepare($stmt, $query)) {
           header('Location: ../settings.php?error=sqlError');
           exit();
      }else {
           //if $query is work
           mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $_SESSION['id_Users']);
           mysqli_stmt_execute($stmt);
           mysqli_stmt_store_result($stmt);
           $resultCheck = mysqli_stmt_num_rows($stmt);
           //selected rows
           if ($resultCheck > 0) {
               header('Location: ../settings.php?error=usernameOrEmailTaken');
               exit();
           }else {
              //no row selected
              $query = 'UPDATE users SET
                       firstname_Users =  ?,
                       lastname_Users  =  ?,
                       username_Users  =  ?,
                       email_Users     =  ?,
                       country_Users   =  ?,
                       phone_Users     =  ?,
                       gender_Users    =  ?
                       WHERE id_Users  =  ?;
                       ';
              $stmt = mysqli_stmt_init($connect);
              //Check sql Errors
              if (!mysqli_stmt_prepare($stmt, $query)) {
               header('Location: ../settings.php?error=sqlError');
                exit();
              }else {
                //if $query is work
                mysqli_stmt_bind_param($stmt, 'ssssssss', $firstname, $lastname, $username, $email, $country, $phone, $gender, $_SESSION['id_Users']);
                mysqli_stmt_execute($stmt);

                  $_SESSION['firstname_Users']   = $firstname;
                  $_SESSION['lastname_Users']    = $lastname;
                  $_SESSION['username_Users']    = $username;
                  $_SESSION['email_Users']       = $email;
                  $_SESSION['country_Users']     = $country;
                  $_SESSION['phone_Users']       = $phone;
                  $_SESSION['gender_Users']      = $gender;
                header('Location: ../settings.php?update=success');
                exit();
              }
           }
      }
   }
   mysqli_stmt_close($stmt);
   mysqli_close($connect);
}
elseif(isset($_POST['updatePassword'])){
   //Connect to database
   require 'dbh.inc.php';
   session_start();

   //Declar values from input fields.
   $currentPassword = $_POST['currentPassword'];
   $newPassword = $_POST['newPassword'];
   $confirmPassword = $_POST['confirmPassword'];
   $id_Users = $_SESSION['id_Users'];

   //Check empty fields
   if ( empty($currentPassword) || empty($newPassword) || empty($confirmPassword) ) {
      header('Location: ../settings.php?error=emptyFields');
      exit();
   }
   //Check password
   elseif( $currentPassword == $newPassword || $newPassword !== $confirmPassword){
      header('Location: ../settings.php?error=CheckPwd');
      exit();
   }else{
      $query = 'SELECT password_Users FROM users WHERE id_Users = ?';
      $stmt = mysqli_stmt_init($connect);
      //Check sql Errors
      if (!mysqli_stmt_prepare($stmt, $query)) {
         header('Location: ../settings.php?error=sqlError');
         exit();
      }else {
         mysqli_stmt_bind_param($stmt, 's', $id_Users);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         if ($row = mysqli_fetch_assoc($result)){
            $pswCheck = password_verify($currentPassword, $row['password_Users']);
            if ($pswCheck) {
               $query = 'UPDATE users SET password_Users = ? WHERE id_Users = ?';
               $stmt = mysqli_stmt_init($connect);
               //Check sql Errors
               if (!mysqli_stmt_prepare($stmt, $query)) {
                  header('Location: ../settings.php?error=sqlError');
                  exit();
               }else {
                  $pswhashed = password_hash($newPassword, PASSWORD_DEFAULT);
                  mysqli_stmt_bind_param($stmt, 'ss', $pswhashed , $id_Users);
                  mysqli_stmt_execute($stmt);
                  header('Location: ../settings.php?update=success');
                  exit();
               }
            }elseif(!$pswCheck) {
               header('Location: ../settings.php?error=wrrongCurrentPassword');
               exit();
            }
            else{
               header('Location: ../settings.php?error=wrrongCurrentPassword');
               exit();
            }
         }else {
            header('Location: ../settings.php?error=wrrongCurrentPassword');
            exit();
         }
      }
   }
}
elseif(isset($_POST['updateURLs'])){
   //Connect to database
   require 'dbh.inc.php';
   session_start();

   //Declar values from input fields.
   $facebookURL = $_POST['facebookURL'];
   $instagramURL = $_POST['instagramURL'];
   $websiteURL = $_POST['websiteURL'];

   $query = 'UPDATE users SET
           facebookURL_Users     =  ?,
           instagramURL_Users    =  ?,
           websiteURL_Users      =  ? WHERE id_Users = ?;
           ';
   $stmt = mysqli_stmt_init($connect);
   //Check sql Errors
   if (!mysqli_stmt_prepare($stmt, $query)) {
   header('Location: ../settings.php?error=sqlError');
   exit();
   }else {
   //if $query is work
   mysqli_stmt_bind_param($stmt, 'ssss', $facebookURL, $instagramURL, $websiteURL, $_SESSION['id_Users']);
   mysqli_stmt_execute($stmt);

      $_SESSION['facebookURL_Users']   = $facebookURL;
      $_SESSION['instagramURL_Users']    = $instagramURL;
      $_SESSION['websiteURL_Users']    = $websiteURL;
   header('Location: ../settings.php?update=success');
   exit();
   }
   mysqli_stmt_close($stmt);
   mysqli_close($connect);
}
elseif(isset($_POST['updateOthers'])){
   //Connect to database
   require 'dbh.inc.php';
   session_start();

   //Declar values from input fields.
   $skills = $_POST['skills'];
   $description = $_POST['description'];

   $query = 'UPDATE users SET
           skills_Users     =  ?,
           description_Users    =  ?
           WHERE id_Users = ?';
   $stmt = mysqli_stmt_init($connect);
   //Check sql Errors
   if (!mysqli_stmt_prepare($stmt, $query)) {
   header('Location: ../settings.php?error=sqlError');
   exit();
   }else {
   //if $query is work
   mysqli_stmt_bind_param($stmt, 'sss', $skills, $description, $_SESSION['id_Users']);
   mysqli_stmt_execute($stmt);
   //Update sessions too
   $_SESSION['skills_Users']   = $skills;
   $_SESSION['description_Users']    = $description;
   header('Location: ../settings.php?update=success');
   exit();
   }
   mysqli_stmt_close($stmt);
   mysqli_close($connect);
}
else {
   header('Location: ../settings.php');
   exit();
}
