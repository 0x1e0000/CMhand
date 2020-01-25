<?php
//if user likes a post
if (isset($_POST['liked'])) {
   like:
   require 'dbh.inc.php';
   session_start();
   $result = mysqli_query($connect, "SELECT * from likes WHERE id_Users = $_SESSION[id_Users] AND id_Posts = $_POST[id_Post]");
   if (mysqli_num_rows($result) == 0) {
      //get number of likes in that post
      $result = mysqli_query($connect, "SELECT * FROM posts WHERE id_Posts = $_POST[id_Post];");
      $row = mysqli_fetch_assoc($result);
      $nbr_likes = $row['likes_Posts']+1;

      //Increment likes_Posts on Posts Table
      mysqli_query($connect, "UPDATE posts SET likes_Posts = $nbr_likes WHERE id_Posts = $_POST[id_Post];");
      mysqli_query($connect, "INSERT INTO likes(id_Users, id_Posts, time_Likes) VALUES ($_SESSION[id_Users], $_POST[id_Post], NOW());");
      mysqli_query($connect, "INSERT INTO notifications (id_users, id_Posts, type_Notifications, time_Notifications, status_Notifications) VALUES($_SESSION[id_Users], $_POST[id_Post], 'like', NOW(), false);");
      mysqli_close($connect);
      echo $nbr_likes;
   }else {
      goto unlike;
   }
}

//if user Unlikes a post
elseif (isset($_POST['unliked'])) {
   unlike:
   require 'dbh.inc.php';
   session_start();
   $result = mysqli_query($connect, "SELECT * from likes WHERE id_Users = $_SESSION[id_Users] AND id_Posts = $_POST[id_Post]");
   if (mysqli_num_rows($result) == 1) {
      //get number of likes in that post
      $result = mysqli_query($connect, "SELECT * FROM posts WHERE id_Posts = $_POST[id_Post];");
      $row = mysqli_fetch_assoc($result);
      $nbr_likes = $row['likes_Posts']-1;

      mysqli_query($connect, "DELETE FROM likes WHERE id_Users = $_SESSION[id_Users] AND id_Posts = $_POST[id_Post];");
      mysqli_query($connect, "UPDATE posts SET likes_Posts = $nbr_likes WHERE id_Posts = $_POST[id_Post];");
      mysqli_query($connect, "DELETE FROM notifications WHERE id_Users = $_SESSION[id_Users] AND id_Posts = $_POST[id_Post]");
      mysqli_close($connect);
      echo $nbr_likes;
   }else {
      goto like;
   }
}

else {
   header('Location: ../dashboard.php');
   exit();
}
