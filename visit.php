<?php
session_start();
if (!isset($_SESSION['id_Users'])) {header('Location: index.php');exit();}
require 'layout/head.php';
cssLink('profile');
include 'layout/navbar.php';
if (isset($_GET['username'])) {
   require 'includes/dbh.inc.php';
   $query = "SELECT * FROM users WHERE username_Users = ?";
   $stmt = mysqli_stmt_init($connect);
   if (mysqli_stmt_prepare($stmt, $query)) {
      mysqli_stmt_bind_param($stmt, 's', $_GET['username']);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) == 1) {
         if ($row = mysqli_fetch_assoc($result)) {
            $id_user = $row['id_Users'];
            $firstname = $row['firstname_Users'];
            $lastname = $row['lastname_Users'];
            $username = $row['username_Users'];
            //$email = $row['email_Users'];
            //$country = $row['country_Users'];
            //$phone = $row['phone_Users'];
            //$gender = $row['gender_Users'];
            //$joinDate = $row['joinDate_Users'];
            $facebook = $row['facebookURL_Users'];
            $instagram = $row['instagramURL_Users'];
            $website = $row['websiteURL_Users'];
            $skills = $row['skills_Users'];
            $description = $row['description_Users'];
            if (empty($row['avatar_Users'])) {
               if ($row['gender_Users'] == 'male') $avatar = "background-image:url(assets/img/uploads/avatars/male-avatar.jpg";
               else $avatar = "background-image:url(assets/img/uploads/avatars/female-avatar.jpg";
               $cover = "";
            }else {
               $avatar = "background-image:url(assets/img/uploads/avatars/$row[avatar_Users]";
               $cover = "background-image:url(assets/img/uploads/covers/$row[cover_Users])";
            }
         }
      }else {
         header('Location: dashboard.php?error=noUser');
         exit();
      }
      mysqli_stmt_close($stmt);
      mysqli_close($connect);
   }else {
      header('Location: dashboard.php?error=sqlError');
      exit();
   }
}else {
   header('Location: dashboard.php?error=usernameIsNotSetted');
   exit();
}
?>

<header id="profile">
   <div class="cover" style="<?php echo $cover;?>"></div>
   <div class="profile" style="<?php echo $avatar;?>"></div>
   <h4 class="subtitle"><?php echo ucwords($firstname).' '.ucwords($lastname); ?>
      <span>(<?php echo $username; ?>)</span>
   </h4>
   <small class="small"><?php echo ucwords($skills); ?></small>
   <p class="paragraph"><?php echo ucfirst($description); ?></p>
   <div class="social-media">
      <?php
         if (!empty($facebook))  echo "<a href='$facebook' target='_blank'><i class='fab fa-facebook-f px-2'></i></a>";
         if (!empty($instagram)) echo "<a href='$instagram' target='_blank'><i class='fab fa-instagram px-2'></i></a>";
         if (!empty($website))   echo "<a href='$website' target='_blank'><i class='fas fa-globe px-2'></i></a>";
      ?>
   </div>
</header>

<section class="container pt-5" id="posts">
   <div class="my-4 clearfix">
      <h3 class="header d-inline-block m-0 align-middle">Works</h3>
      <div class="d-inline-block float-right subtitle">
         <button class="btn" type="button" id="openFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-sliders-h mr-2"></i>STORE BY
         </button>
         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="openFilter">
            <a class="dropdown-item storPosts" id="MostPopular" title='<?php echo $id_user; ?>'>Most popular</a>
            <a class="dropdown-item storPosts" id="oldest" title='<?php echo $id_user; ?>'>Date added (oldest)</a>
            <a class="dropdown-item storPosts" id="newest" title='<?php echo $id_user; ?>'>Date added (newest)</a>
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
            echo '<p class="alert alert-danger paragraph w-100 text-center">Sql Error</p>';
         }else {
            mysqli_stmt_bind_param($stmt, 's', $id_user);
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
   require 'layout/plugins.php';
?>
