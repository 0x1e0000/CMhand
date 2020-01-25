<?php
if (isset($_POST['upload-post'])) {
   session_start();

   $post = $_FILES['file'];
   $postName = $post['name'];
   $postSize = $post['size'];
   $postError = $post['error'];
   $postTmpName = $post['tmp_name'];

   $title = strtolower($_POST['title']);
   $description = strtolower($_POST['description']);

   //Verify Tags
   $tagsArray = explode(';', strtolower($_POST['tags']));
   for ($i=0; $i < count($tagsArray); $i++) {
      if (!empty($tagsArray[$i])) {
         if ($i == 0)
            $tags = preg_replace('/\s+/', '', $tagsArray[$i]);
         else
            $tags .= ';'.preg_replace('/\s+/', '', $tagsArray[$i]);
      }
   }

   //Split the name and the extension (name.jpg)
   $postExt = explode('.', $postName);
   $postActualExt = strtolower(end($postExt));
   $allowed = array('jpg', 'jpeg', 'png');

   //Check empty fields
   if (empty($title) || ctype_space($title) || empty($description) || ctype_space($description) || empty($tags) || ctype_space($tags)) {
      header('Location: ../addPost.php?error=enptyFields&title='.$title.'&description='.$description.'&tags='.$tags);
      exit();
   }elseif (strlen($title) > 255) {
      header('Location: ../addPost.php?error=TitleIsTooLong&title='.$title.'&description='.$description.'&tags='.$tags);
      exit();
   }elseif (strlen($description) > 5000) {
      header('Location: ../addPost.php?error=DescriptionIsTooLong&title='.$title.'&description='.$description.'&tags='.$tags);
      exit();
   }elseif (strlen($tags) >  255) {
      header('Location: ../addPost.php?error=TagsAreTooLong&title='.$title.'&description='.$description.'&tags='.$tags);
      exit();
   }
   //Check type of photo
   if (in_array($postActualExt, $allowed)) {
      //check if there is any errors
      if ($postError === 4) {
         //Chack the size of photo < 10mb = 1000000bit
         if ($postSize < 10000000) {
            $postNewName = uniqid('', true).'.'.$postActualExt;
            $postDestination = '../img/uploads/posts/'.$postNewName;
            //insert post to database
            require 'dbh.inc.php';
            $query = "INSERT INTO posts (id_Users, title_Posts, date_Posts, description_Posts, tags_Posts, path_Posts) VALUES (?, ?, NOW(), ?, ?, ?);";
            $stmt = mysqli_stmt_init($connect);
            //Check sql Errors
            if (mysqli_stmt_prepare($stmt, $query)) {
               //if $query is work
               mysqli_stmt_bind_param($stmt, 'sssss', $_SESSION['id_Users'], $title, $description, $tags, $postNewName);
               mysqli_stmt_execute($stmt);
               move_uploaded_file($postTmpName, $postDestination);
               mysqli_close($connect);
               header('Location: ../profile.php?success=Uploading');
               exit();
            }else {
               header('Location: ../profile.php?error=sqlError&title='.$title.'&tags='.$tags.'&description='.$description);
               exit();
            }
         }else {
            header('Location: ../addPost.php?error=PostBigSize&title='.$title.'&tags='.$tags.'&description='.$description);
            exit();
         }
      }else {
         header('Location: ../addPost.php?error=ErrorPost&title='.$title.'&tags='.$tags.'&description='.$description);
         exit();
      }
   }else {
      header('Location: ../addPost.php?error=uploadPhoto&title='.$title.'&tags='.$tags.'&description='.$description);
      exit();
   }
}else{
   header('Location: ../dashboard.php');
   exit();
}
