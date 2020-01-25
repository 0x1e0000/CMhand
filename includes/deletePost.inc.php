<?php
if (isset($_POST['id_Post'])) {
   include_once 'dbh.inc.php';
   session_start();

   //Delete post's image from uploads folder
   $query = "SELECT * FROM posts WHERE id_Posts = ? AND id_Users = ? ;";
   $stmt = mysqli_stmt_init($connect);
   if (mysqli_stmt_prepare($stmt, $query)) {
      mysqli_stmt_bind_param($stmt, 'ss', $_POST['id_Post'], $_SESSION['id_Users']);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) > 0) {
         while ($row = mysqli_fetch_assoc($result)) {
            unlink('../img/uploads/posts/'.$row['path_Posts']);
         }
      }
   }
   //Delete post by id on posts table
   $query = "DELETE FROM posts WHERE id_Posts = ? AND id_Users = ? ;";
   $stmt = mysqli_stmt_init($connect);
   if (mysqli_stmt_prepare($stmt, $query)) {
      mysqli_stmt_bind_param($stmt, 'ss', $_POST['id_Post'], $_SESSION['id_Users']);
      mysqli_stmt_execute($stmt);
   }
   mysqli_stmt_close($stmt);
   mysqli_close($connect);
}else {
   header('Location: ../profile.php');
   exit();
}
