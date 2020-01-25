<?php
if (empty($_SESSION['avatar_Users'])) {
   if ($_SESSION['gender_Users'] == 'male') $avatar = "male-avatar.jpg";
   else $avatar = "female-avatar.jpg";
   $cover = "";
}else {
   $avatar = "$_SESSION[avatar_Users]";
   $cover = "background-image:url(assets/img/uploads/covers/$_SESSION[cover_Users])";
}
?>
<nav class="navbar navbar-expand-sm fixed-top bg-white shadow-sm" id="navbar">
   <div class="container">
      <a class="navbar-brand" href="dashboard.php">
         <img src="assets/img/logo/logo.png" width="30" height="30" class="d-inline-block align-middle" alt="">
         <span class="align-middle">CMhand</span>
      </a>
      <ul class="navbar-nav justify-content-right">
         <li class="nav-item dropdown mr-2" data-toggle="tooltip" data-placement="left" title="Notifications">
             <button class="nav-link btn" type="button" id="notification-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <i class="fas fa-bell"></i>
             </button>
             <div id="notification-dropdown" class="dropdown-menu dropdown-menu-right" aria-labelledby="notification-icon">
                <a href='notifications.php' class='btn btn-main' style='width: 100%;border-radius: 0;'>See All notifications</a>
             </div>
         </li>
         <li class="nav-item mr-4">
            <a class="nav-link" href="addPost.php" data-toggle="tooltip" data-placement="bottom" title="Add new post"><i class="fas fa-plus-circle"></i></a>
         </li>
         <li class="nav-item dropdown">
            <button type="button" id="openProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src='assets/img/uploads/avatars/<?php echo $avatar; ?>' data-toggle="tooltip" data-placement="top" title="Account" data-original-title="Account">
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="openProfile">
               <a class="dropdown-item paragraph m-0" href="profile.php"><i class="fas fa-user-circle mr-3 text-muted"></i> Profile</a>
               <a class="dropdown-item paragraph m-0" href="settings.php"><i class="fas fa-cog mr-3 text-muted"></i> Settings</a>
               <div class="dropdown-divider"></div>
               <form class="dropdown-item paragraph m-0 btn" action="includes/logout.inc.php" method="post">
                  <button class="btn bg-transparent border-0 paragraph m-0 p-0" type="submit" name="logout-submit"><i class="fas fa-sign-out-alt mr-3 text-muted"></i> Logout</button>
               </form>
            </div>
         </li>
      </ul>
   </div>
</nav>
