<?php
if (isset($_POST['update-post'])) {
   //Connect to database and start a sassion
   require 'dbh.inc.php';
   session_start();

   //Empty fields handler
   if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['tags']) || empty($_POST['id_Posts']) || (strlen($_POST['tags']) < 3) ) {
      header('Location: ../editPost.php?error=enptyFields&postid='.$_POST['id_Posts'].'&userid='.$_SESSION['id_Users']);
      exit();
   }elseif(ctype_space($_POST['title']) || ctype_space($_POST['description']) || ctype_space($_POST['tags']) || ctype_space($_POST['id_Posts'])){
      header('Location: ../editPost.php?error=Spaces&postid='.$_POST['id_Posts'].'&userid='.$_SESSION['id_Users']);
      exit();
   }else {
      //Update the post from database
      $query = "UPDATE posts SET title_Posts = ?, description_Posts = ?, tags_Posts = ? WHERE id_Users = ? AND id_Posts = ?;";
      $stmt = mysqli_stmt_init($connect);
      if(!mysqli_stmt_prepare($stmt, $query)){
         //if $query is NOT works
         header('Location: ../editPost.php?error=sqlError&postid='.$_POST['id_Posts'].'&userid='.$_SESSION['id_Users']);
         exit();
      }else {
         //if $query is works
         mysqli_stmt_bind_param($stmt, 'sssss', $_POST['title'],  $_POST['description'], $_POST['tags'] , $_SESSION['id_Users'], $_POST['id_Posts']);
         mysqli_stmt_execute($stmt);
      }
      //Close Connect to Database
      mysqli_stmt_close($stmt);
      mysqli_close($connect);
      header('Location: ../dashboard.php?update=success');
      exit();
   }
}
else {
   header('Location: ../dashboard.php');
   exit();
}
