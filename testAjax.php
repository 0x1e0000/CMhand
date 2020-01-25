<?php require 'layout/head.php'; ?>

      <section class="container pb-5" id="posts">
         <div class="row">
            <?php
               include 'includes/dbh.inc.php';
               session_start();
               $query = "SELECT * FROM posts INNER JOIN users ON posts.id_Users = users.id_Users LIMIT 2;";
               $result = mysqli_query($connect, $query);
               if (!$result) {
                  header('Location: profile.php?error=sqlError');
                  exit();
               }else {
                  while ($row = mysqli_fetch_assoc($result)) {
                     if ($row['avatar_Users'] == null) {
                        if ($row['gender_Users'] == 'male') $avatar_post = 'male-avatar.jpg';
                        else $avatar_post = 'female-avatar.jpg';
                     }else {
                        $avatar_post = $row['avatar_Users'];
                     }
                     if ($row['id_Users'] == $_SESSION['id_Users'])
                        $id_user = 'profile.php';
                     else
                        $id_user = '#';
                     echo "
                     <article class='col-lg-3 col-md-4 col-sm-6 my-3'>
                        <div class='shadow-sm rounded'>
                           <div class='card-header p-2 bg-white border-0'>
                              <a href='$id_user'>
                                 <div class='profile-img' style='background-image: url(assets/img/uploads/avatars/$avatar_post);'></div>
                                 <p class='paragraph d-inline-block m-0 text-dark align-middle text-truncate' style='max-width: 200px;'>".ucwords($row['firstname_Users'])." ".ucwords($row['lastname_Users'])."</p>
                              </a>
                           </div>
                           <div class='card border-0'>
                              <div class='post-img' style='background-image: url(assets/img/uploads/posts/$row[path_Posts]);'></div>
                              <div class='card-body p-2'>
                                 <h5 class='text-center subtitle m-0 text-truncate'>
                                    <a href='viewPost.php?postid=$row[id_Posts]&userid=$row[id_Users]#viewPost'>".ucwords($row['title_Posts'])."</a>
                                 </h5>
                                 <p class='text-truncate paragraph text-center'><small>$row[description_Posts]</small></p>
                                 ";
                                 if (!isset($_SESSION['id_Users'])){
                                    echo "<a href='login.php'><i class='fas fa-heart'></i></a>";
                                 }else {
                                    $id_Post = $row['id_Posts'];
                                    //look for this post if is already liked by user
                                    $sql = "SELECT * FROM likes WHERE id_Users = $_SESSION[id_Users] AND id_Posts = $id_Post;";
                                    $results = mysqli_query($connect, $sql);
                                    //if there user already liked this post
                                    if (mysqli_num_rows($results) > 0)
                                       echo "<a id='$row[id_Posts]' data-toggle='tooltip' data-placement='bottom' title='Love' class='unlike'><i class='fas fa-heart text-danger'></i></a>";
                                    else //if there is no liks by user to this post
                                       echo "<a id='$row[id_Posts]' data-toggle='tooltip' data-placement='bottom' title='Love' class='like'><i class='fas fa-heart text-dark'></i></a>";
                                 }
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
            ?>
         </div>
      </section>
      <button id="load-more" class="btn btn-main" type="button">More Posts</button>
      <script src="js/jquery-3.3.1.min.js"></script>
      <script type="text/javascript">
            $(document).ready(function(){
               var limit = 2;
               $('#load-more').click(function(){
                  limit = limit + 2;
                  $('#posts .row').load('loadPosts.php',{limit : limit});
               });
            });
      </script>
   </body>
</html>
