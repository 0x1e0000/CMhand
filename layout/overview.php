<?php
include 'includes/dbh.inc.php';
$members = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM users"));
$likes = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM likes"));

$result = mysqli_query($connect, "SELECT DISTINCT username_Users FROM users INNER JOIN posts ON users.id_Users = posts.id_Users WHERE posts.likes_Posts IN (SELECT MAX(likes_Posts) from posts);");
$row = mysqli_fetch_row($result);
if (isset($row[0])) $user = $row[0];
else $user = 'none';
?>
<section class="container text-center pb-5" id="overview">
   <h3 class="text-left pb-2 header">Overview</h3>
   <div class="row">
      <div class="col-md-4 col-sm-6">
         <div class="bg-white text-dark border rounded shadow-sm py-5 mb-4">
            <i class="fas fa-users fa-3x text-primary mb-3"></i>
            <h3 class="m-0"><?php echo $members; ?></h3>
            <small class="small">Total Members</small>
         </div>
      </div>
      <div class="col-md-4 col-sm-6">
         <div class="bg-white text-dark border rounded shadow-sm py-5 mb-4">
            <i class="fas fa-heart fa-3x text-danger mb-3"></i>
            <h3 class="m-0"><?php echo $likes; ?></h3>
            <small class="small">Total Likes</small>
         </div>
      </div>
      <div class="col-md-4 col-sm-6">
         <div class="bg-white text-dark border rounded shadow-sm py-5 mb-4">
            <i class="fas fa-user fa-3x text-warning mb-3"></i>
            <h3 class="my-0 mx-3 text-truncate"><?php echo ucfirst($user); ?></h3>
            <small class="small">Best Member</small>
         </div>
      </div>
   </div>
</section>
