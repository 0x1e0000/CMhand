<?php
if (isset($_POST['upload-avatar'])) {
   session_start();

   $avatar = $_FILES['file'];
   $avatarName = $avatar['name'];
   $avatarTmpName = $avatar['tmp_name'];
   $avatarError = $avatar['error'];
   $avatarSize = $avatar['size'];

   //Split the name and the extension (name.jpg)
   $avatarExt = explode('.', $avatarName);
   $avatarActualExt = strtolower(end($avatarExt));
   $allowed = array('jpg','jpeg','png');

   if (in_array($avatarActualExt, $allowed)) {
      if ($avatarError === 0) {
         if ($avatarSize < 6000000) {
            $avatarNewName = $_SESSION['id_Users'].'.'.$avatarActualExt;
            $avatarDestination = '../img/uploads/avatars/'.$avatarNewName;
            $oldAvatarDestination = '../img/uploads/avatars/'.$_SESSION['avatar_Users'];
            //update avatar on database
            include 'dbh.inc.php';
            $query = "UPDATE users SET avatar_Users = '$avatarNewName' WHERE id_Users = $_SESSION[id_Users]";
            if (mysqli_query($connect, $query)) {
               $_SESSION['avatar_Users'] = $avatarNewName;
            }else {
               header('Location: ../profile.php?error=sqlError');
               exit();
            }
            mysqli_close($connect);
            unlink($oldAvatarDestination);
            move_uploaded_file($avatarTmpName, $avatarDestination);
            header('Location: ../profile.php');
            exit();
         }else {
            header('Location: ../profile.php?error=AvatarBigSize');
            exit();
         }
      }else {
         header('Location: ../profile.php?error=ErrorAvatar');
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
