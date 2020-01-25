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
   //Get post & owner data
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
         $fullname = $row['firstname_Users']. ' ' . $row['lastname_Users'];
         $title = $row['title_Posts'];

         $description = $row['description_Posts'];
         $like = $row['likes_Posts'];
         $tags = explode(';', $row['tags_Posts']);
         $path = $row['path_Posts'];
         $avatar_path = $row['avatar_Users'];
         if ($_SESSION['id_Users'] == $row['id_Users']) $username = 'profile.php';
         else $username = 'visit.php?username='.$row['username_Users'];
      }
   }
}
require 'layout/head.php';
cssLink('viewPost');
include 'layout/navbar.php';
include 'layout/overview.php';
?>
<!-- see post photo Modal -->
<div class="modal fade" id="postphoto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 70%;margin: 0 auto;">
        <div class="modal-content" style="background: none;border: none;">
            <div class="modal-body p-0" style="margin: 0 auto;">
                <img src="assets/img/uploads/posts/<?php echo $path; ?>" style="max-width:100%;min-width:auto;" alt="">
            </div>
        </div>
    </div>
</div>

<!-- See post lovers Modal -->
<div class="modal fade" id="lovers" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title subtitle">Post Lovers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                    $sql1 = "SELECT * FROM likes inner join users on likes.id_Users = users.id_Users WHERE id_Posts = $id_Post;";
                    $result1 = mysqli_query($connect, $sql1);
                    if (mysqli_num_rows($result1) > 0){
	                    while ($row = mysqli_fetch_assoc($result1)){
	                        if  ($row[username_Users] == $_SESSION['username_Users']) $username_lover = 'profile.php';
	                        else $username_lover = "visit.php?username=$row[username_Users]";
		                    echo "
                                <div class='lover'>
                                    <div class='lover-avatar'>
                                        <img src='assets/img/uploads/avatars/$row[avatar_Users]' alt='' width='100%'>
                                    </div>
                                    <a href='$username_lover' class='paragraph'>$row[username_Users]</a>
                                </div>
                            ";
	                    }
                    }else{
                        echo '<p class="paragraph text-center">There is no one like this post.</p>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<section class="container" id="viewPost">
   <div class="row">
      <div class="col-lg-7 photo-post" style='background-image: url("img/uploads/posts/<?php echo $path; ?>")' data-toggle='modal' data-target='#postphoto'></div>
      <div class="col-lg-5">
            <div class="img-container">
               <a href="<?php echo $username; ?>" style='background-image:url("img/uploads/avatars/<?php echo $avatar_path; ?>")'></a>
            </div>
            <a href="<?php echo $username; ?>">
               <h4 class="header"><?php echo ucwords($fullname); ?></h4>
            </a>
            <h4 class="subtitle text-dark title"><?php echo ucwords($title); ?></h4>
            <p class="paragraph text-center pt-3 mb-5" style="max-height: 180px;overflow: auto;min-height: auto;"><?php echo ucfirst($description); ?></p>
            <div class="bottom row">
               <div class="love col-2">
                  <?php
                     //look for this post if is already liked by user
                     $sql2 = "SELECT * FROM likes WHERE id_Users = $_SESSION[id_Users] AND id_Posts = $id_Post;";
                     $result2 = mysqli_query($connect, $sql2);
                     //if there user already liked this post
                     if (mysqli_num_rows($result2) > 0) {
                        echo "<a id='$id_Post' data-toggle='tooltip' data-placement='bottom' title='Unloved' class='unlike'><i class='fas fa-heart text-danger'></i></a>";
                     }else {
                        //if there is no liks by user to this post
                        echo "<a id='$id_Post' data-toggle='tooltip' data-placement='bottom' title='Love' class='like'><i class='fas fa-heart'></i></a>";
                     }
                   ?>
                  <small class="paragraph text-dark" style="cursor: pointer" data-toggle='modal' data-target='#lovers'><?php echo $like; ?></small>
               </div>
               <div class="tags col-10">
                  <?php for ($i=0; $i < count($tags); $i++){ if($i == 33) break; elseif ($tags[$i] == '') continue; else echo '<span class="small bg-main text-white mr-1 px-2 py-1 rounded" style="cursor:pointer;">#'.$tags[$i].'</span>';} ?>
               </div>
            </div>
      </div>
   </div>
</section>

<h3 class="container header">Related Posts</h3>
<?php
    mysqli_close($connect);
    include 'layout/posts.php';
    include 'layout/footer.php';
    require 'layout/plugins.php';
?>
