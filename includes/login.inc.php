<?php
if (isset($_POST['login-submit'])) {
   include_once 'dbh.inc.php';

   $email = strtolower($_POST['email']);
   $password = $_POST['password'];

   if (empty($email) || empty($password) || ctype_space($email)) {
      header('Location: ../login.php?error=emptyFields&email='.$email);
      exit();
   }
   else {
      $query = 'SELECT * FROM users WHERE email_Users = ? OR username_Users = ?;';
      $stmt = mysqli_stmt_init($connect);
      if (!mysqli_stmt_prepare($stmt, $query)) {
         header('Location: ../login.php?error=sqlError&email='.$email);
         exit();
      }else {
         mysqli_stmt_bind_param($stmt, 'ss', $email, $email);
         mysqli_stmt_execute($stmt);
         $result = mysqli_stmt_get_result($stmt);
         if ($row = mysqli_fetch_assoc($result)) {
            $pswCheck = password_verify($password, $row['password_Users']);
            if ($pswCheck == false) {
               header('Location: ../login.php?error=wrrongPwd&email='.$email);
               exit();
            }elseif($pswCheck == true) {
               session_start();
               $_SESSION['id_Users'] = $row['id_Users'];
               $_SESSION['firstname_Users'] = $row['firstname_Users'];
               $_SESSION['lastname_Users'] = $row['lastname_Users'];
               $_SESSION['username_Users'] = $row['username_Users'];
               $_SESSION['email_Users'] = $row['email_Users'];
               $_SESSION['country_Users'] = $row['country_Users'];
               $_SESSION['phone_Users'] = $row['phone_Users'];
               $_SESSION['gender_Users'] = $row['gender_Users'];
               $_SESSION['joinDate_Users'] = $row['joinDate_Users'];
               $_SESSION['facebookURL_Users'] = $row['facebookURL_Users'];
               $_SESSION['instagramURL_Users'] = $row['instagramURL_Users'];
               $_SESSION['websiteURL_Users'] = $row['websiteURL_Users'];
               $_SESSION['skills_Users'] = $row['skills_Users'];
               $_SESSION['description_Users'] = $row['description_Users'];
               $_SESSION['avatar_Users'] = $row['avatar_Users'];
               $_SESSION['cover_Users'] = $row['cover_Users'];
               header('Location: ../index.php?login=success');
               exit();
            }else {
               header('Location: ../login.php?error=wrrongPwd&email='.$email);
               exit();
            }
         }else {
            header('Location: ../login.php?error=noUser');
            exit();
         }
      }
   }
}else {
   header('Location: ../login.php');
   exit();
}
