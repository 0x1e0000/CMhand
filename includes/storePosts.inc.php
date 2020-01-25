<?php
if (isset($_POST['storPosts'])) {
   if ($_POST['storPosts'] === 'MostPopular') {
      $query = "SELECT * FROM posts WHERE id_Users = ? ORDER BY likes_Posts DESC;";
   }elseif ($_POST['storPosts'] === 'oldest') {
      $query = "SELECT * FROM posts WHERE id_Users = ? ORDER BY date_Posts ASC;";
   }elseif ($_POST['storPosts'] === 'newest') {
      $query = "SELECT * FROM posts WHERE id_Users = ? ORDER BY date_Posts DESC;";
   }else {
      $query = "SELECT * FROM posts WHERE id_Users = ? ORDER BY date_Posts DESC;";
   }
}
else {
   header('Location: ../dashboard.php');
   exit();
}
include 'dbh.inc.php';
session_start();
$stmt = mysqli_stmt_init($connect);
if (mysqli_stmt_prepare($stmt, $query)) {
   mysqli_stmt_bind_param($stmt, 's', $_POST['id_Users']);
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
                     <h5 class='subtitle m-0 text-truncate'><a href='viewPost.php?postid=$row[id_Posts]&userid=$row[id_Users]#viewPost'>".ucwords($row[title_Posts])."</a></h5>
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
                     echo "<small class='small text-dark'>$row[likes_Posts]</small>
                     ";
                     if ($_POST['id_Users'] == $_SESSION['id_Users']) {
                        echo "
                        <button type='button' class='btn btn-sm bg-white small text-danger float-right border-0 deletePost' id='$row[id_Posts]'>Delete</button>
                        <a href='' class='btn btn-sm bg-white small text-main float-right mr-1 border-0' id='$row[id_Posts]'>Edit</a>
                        ";
                     }
                     echo "
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
