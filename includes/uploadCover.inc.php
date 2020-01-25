<?php
if (isset($_POST['upload-cover'])) {
   session_start();

   $cover = $_FILES['file'];
   $coverName = $cover['name'];
   $coverTmpName = $cover['tmp_name'];
   $coverError = $cover['error'];
   $coverSize = $cover['size'];

   //Split the name and the extension (name.jpg)
   $coverExt = explode('.', $coverName);
   $coverActualExt = strtolower(end($coverExt));
   $allowed = array('jpg','jpeg','png');

   if (in_array($coverActualExt, $allowed)) {
      if ($coverError === 0) {
         if ($coverSize < 10000000) {
            $coverNewName = $_SESSION['id_Users'].'.'.$coverActualExt;
            $coverDestination = '../img/uploads/covers/'.$coverNewName;
            $oldCoverDestination = '../img/uploads/covers/'.$_SESSION['cover_Users'];
            include 'dbh.inc.php';
            $query = "UPDATE users SET cover_Users = '$coverNewName' WHERE id_Users = $_SESSION[id_Users]";
            if (mysqli_query($connect, $query)) {
               $_SESSION['cover_Users'] = $coverNewName;
            }else {
               header('Location: ../profile.php?error=sqlError');
               exit();
            }
            mysqli_close($connect);
            unlink($oldCoverDestination);
            move_uploaded_file($coverTmpName, $coverDestination);
            header('Location: ../profile.php');
            exit();
         }else {
            header('Location: ../profile.php?error=CoverBigSize');
            exit();
         }
      }else {
         header('Location: ../profile.php?error=ErrorCover');
         exit();
      }
   }else {
      header('Location: ../profile.php?error=invalidAvaterType');
      exit();
   }
}else {
   header('Location: ../profile.php');
   exit();
}
