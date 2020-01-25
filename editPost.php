<?php
session_start();
if (!isset($_SESSION['id_Users'])) {
   header('Location: index.php');
   exit();
}
if (!isset($_GET['postid']) || !isset($_GET['userid'])) {
   header('Location: dashboard.php');
   exit();
}else {
   //Get post Data from Database
   require 'includes/dbh.inc.php';
   $id_Post = mysqli_real_escape_string($connect, $_GET['postid']);
   $id_Users = mysqli_real_escape_string($connect, $_GET['userid']);
   $query = "SELECT * FROM posts INNER JOIN users ON posts.id_Users = users.id_Users WHERE posts.id_Posts = ? AND users.id_Users = ? ;";
   $stmt = mysqli_stmt_init($connect);
   if (!mysqli_stmt_prepare($stmt, $query)) {
      header('Location: profile.php?error=sqlError');
      exit();
   }else {
      mysqli_stmt_bind_param($stmt, 'ss', $id_Post, $id_Users);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      while ($row = mysqli_fetch_assoc($result)) {
         $title = $row['title_Posts'];
         $description = $row['description_Posts'];
         $tags = explode('#', $row['tags_Posts']);
         $path = $row['path_Posts'];
      }
   }
}
require 'layout/head.php';
include 'layout/navbar.php';
cssLink('editPost');

?>

<section class="container pb-5" id="editPost">
         <!-- Error Messages here -->
         <?php
            if (isset($_GET['error'])) {
               if ($_GET['error'] == 'enptyFields') {
                  echo "<p class='alert alert-danger text-center paragraph'>There is empty fields.</p>";
               }elseif ($_GET['error'] == 'sqlError') {
                  echo "<p class='alert alert-danger text-center paragraph'>There is something wrrong, refrech the page and try again.</p>";
               }elseif ($_GET['error'] == 'Spaces') {
                  echo "<p class='alert alert-danger text-center paragraph'>we do not accept only spaces</p>";
               }
            }
         ?>
      <div class="row">
         <div class="col-md-6 edit-Post-Photo" style="background-image:url('img/uploads/posts/<?php echo $path; ?>');"></div>
         <form class="col-md-6 justify-content-center subtitle text-dark" action="includes/updatePost.inc.php" method="post">
            <div class="row form-group col m-0 mb-3">
               <label class="font-weight-bold">Title</label>
               <input name="title" type="text" class="form-control" placeholder="Please enter title of your work ..." value="<?php echo $title; ?>">
            </div>
            <div class="row form-group col m-0 mb-3">
               <label class="font-weight-bold">Discription</label>
               <textarea name="description" rows="8" cols="83" class="form-control" placeholder="Write your message here ..."><?php echo $description; ?></textarea>
            </div>
            <div class="row form-group col m-0 mb-3">
               <label class="font-weight-bold">Tags</label>
               <input name="tags" id="tags" data-role='tags-input' type="text" class="form-control" placeholder="Enter the tags related with your project ..." value="<?php for ($i=0; $i < count($tags); $i++) echo $tags[$i]; ?>">
            </div>
            <input type="hidden" name="id_Posts" value="<?php echo $_GET['postid']; ?>">
            <div class="row form-group col m-0 mb-3">
               <button name="update-post" class="btn btn-main m-0 mt-2 col" type="submit">Edit <i class="far fa-edit ml-1"></i></button>
            </div>
         </form>
      </div>
</section>

<?php
require 'layout/plugins.php';
?>
