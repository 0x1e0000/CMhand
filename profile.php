<?php
session_start();
if (!isset($_SESSION['id_Users'])) {header('Location: index.php');exit();}
require 'layout/head.php';
cssLink('profile');
include 'layout/navbar.php';
?>

<script type="text/javascript">
   //click Submit Avatar
   function upload_avatar(){$('#upload-avatar').click();}
   //click Submit Cover
   function upload_cover(){$('#upload-cover').click();}
</script>

<header id="profile">
   <div class="cover" style="<?php echo $cover;?>">
      <form class="img-cover" action="includes/uploadCover.inc.php" method="POST" enctype="multipart/form-data">
         <input type="file" name="file" id="img-cover" accept="image/*" class="d-none" onchange="upload_cover()">
         <label for="img-cover"><i class="fas fa-camera"></i></label>
         <button type="submit" name="upload-cover" id="upload-cover" class="d-none"></button>
      </form>
   </div>
   <div class="profile" style="background-image:url(assets/img/uploads/avatars/<?php echo $avatar;?>)">
      <form class="img-prof" action="includes/uploadAvatar.inc.php" method="POST" enctype="multipart/form-data">
         <input type="file" name="file" id="img-prof" accept="image/*" class="d-none" onchange="upload_avatar()">
         <label for="img-prof"><i class="fas fa-camera"></i></label>
         <button type="submit" name="upload-avatar" id="upload-avatar" class="d-none"></button>
      </form>
   </div>
   <h4 class="subtitle"><?php echo ucwords($_SESSION['firstname_Users']).' '.ucwords($_SESSION['lastname_Users']); ?>
      <span>(<?php echo $_SESSION['username_Users']; ?>)</span>
      <a href="settings.php">
         <i class="fas fa-cog"></i>
      </a>
   </h4>
   <small class="small"><?php echo ucwords($_SESSION['skills_Users']); ?></small>
   <p class="paragraph"><?php echo $_SESSION['description_Users']; ?></p>
   <div class="social-media">
      <?php
         $facebook = $_SESSION['facebookURL_Users'];
         $instagram = $_SESSION['instagramURL_Users'];
         $website = $_SESSION['websiteURL_Users'];
         if (!empty($facebook)) echo "<a href='$facebook' target='_blank'><i class='fab fa-facebook-f px-2'></i></a>";
         if (!empty($instagram)) echo "<a href='$instagram' target='_blank'><i class='fab fa-instagram px-2'></i></a>";
         if (!empty($website)) echo "<a href='$website' target='_blank'><i class='fas fa-globe px-2'></i></a>";
      ?>
   </div>
</header>

<section class="container mt-5">
   <div class="row" id="new-post">
      <div class="col-lg-7 col-md-8 col-sm-12">
         <div>
            <a href="addPost.php">
               <i class="fas fa-cloud-upload-alt fa-3x"></i>
               <h5 class="my-3 subtitle text-main">Click to Upload Photo</h5>
            </a>
         </div>
      </div>
   </div>
</section>

<section class="container pt-5" id="posts">
   <div class="my-4 clearfix">
      <h3 class="header d-inline-block m-0 align-middle">My Works</h3>
      <div class="d-inline-block float-right subtitle">
         <button class="btn bg-white" type="button" id="openFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-sliders-h mr-2"></i>STORE BY
         </button>
         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="openFilter">
            <a class="dropdown-item storPosts" id="MostPopular" title="<?php echo $_SESSION['id_Users']; ?>">Most popular</a>
            <a class="dropdown-item storPosts" id="oldest" title="<?php echo $_SESSION['id_Users']; ?>">Date added (oldest)</a>
            <a class="dropdown-item storPosts" id="newest" title="<?php echo $_SESSION['id_Users']; ?>">Date added (newest)</a>
         </div>
      </div>
   </div>
   <div class="row" id="postStore">
      <?php
         //Get posts by user id
         include 'includes/dbh.inc.php';
         $query = "SELECT * FROM posts WHERE id_Users = ?;";
         $stmt = mysqli_stmt_init($connect);
         if (!mysqli_stmt_prepare($stmt, $query)) {
            header('Location: profile.php?error=sqlError');
            exit();
         }else {
            mysqli_stmt_bind_param($stmt, 's', $_SESSION['id_Users']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
               while ($row = mysqli_fetch_assoc($result)) {
                  echo "
                  <article class='col-lg-3 col-md-4 col-sm-6 my-3'>
                     <div class='shadow-sm rounded'>
                        <div class='card border-0'>
                           <div class='post-img' style='background-image: url(assets/img/uploads/posts/$row[path_Posts]);'></div>
                           <div class='card-body p-2'>
                              <h5 class='subtitle m-0 text-truncate'><a href='viewPost.php?postid=$row[id_Posts]&userid=$row[id_Users]#viewPost'>".ucwords($row['title_Posts'])."</a></h5>
                              <p class='text-truncate paragraph my-1'><small>".ucwords($row['description_Posts'])."</small></p>
                              ";
                              //look for this post if is already liked by user
                              $sql = "SELECT * FROM likes WHERE id_Users = $_SESSION[id_Users] AND id_Posts = $row[id_Posts];";
                              $results = mysqli_query($connect, $sql);
                              //if there user already liked this post
                              if (mysqli_num_rows($results) > 0)
                                 echo "<a id='$row[id_Posts]' data-toggle='tooltip' data-placement='bottom' title='Unlove' class='unlike'><i class='fas fa-heart text-danger'></i></a>";
                              else
                                 //if there is no liks by user to this post
                                 echo "<a id='$row[id_Posts]' data-toggle='tooltip' data-placement='bottom' title='Love' class='like'><i class='fas fa-heart'></i></a>";
                              echo "
                              <small class='small text-dark'>$row[likes_Posts]</small>

                              <button type='button' class='btn btn-sm bg-white small text-danger float-right border-0 p-0 deletePost' id='$row[id_Posts]'><i class='far fa-trash-alt'></i></button>
                              
                              <a href='editPost.php?postid=$row[id_Posts]&userid=$_SESSION[id_Users]' class='btn btn-sm small bg-white text-main float-right mr-2 p-0 border-0' id='$row[id_Posts]'><i class='far fa-edit'></i></a>
                           </div>
                        </div>
                     </div>
                     <p class='text-center small'>$row[date_Posts]</p>
                  </article>
                  ";
               }
            }
         }
         mysqli_stmt_close($stmt);
         mysqli_close($connect);
      ?>
   </div>
</section>
<?php
   include 'layout/footer.php';
   require_once 'layout/plugins.php';
?>
