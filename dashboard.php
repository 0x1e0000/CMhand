<?php
session_start();
if (!isset($_SESSION['id_Users'])) {
   header('Location: index.php');
   exit();
}
require 'layout/head.php';
include 'layout/navbar.php';
include 'layout/overview.php';
?>
<div class="container">
   <h3 class="header">Posts</h3>
   <div class="buttons subtitle">
      <a href='dashboard.php' class="btn btn-outline-primary mr-1 mb-1">All Categories</a>
      <a href='?filter=Most_Liked' class="btn btn-outline-danger mr-1 mb-1">Moste <span><i class="far fa-heart"></i> Liked</span></a>
      <a href='?filter=Newest' class="btn btn-outline-dark mr-1 mb-1">Newest</a>
      <a href='?filter=illustrations' class="btn btn-outline-warning mr-1 mb-1">Illustration</a>
      <a href='?filter=Logos' class="btn btn-outline-secondary mr-1 mb-1">Logo</a>
      <a href='?filter=Graphic_Design' class="btn btn-outline-info mr-1 mb-1">Graphic Design</a>
      <a href='?filter=Posters' class="btn btn-outline-primary mr-1 mb-1">Poster</a>
      <a href='?filter=Flyers' class="btn btn-outline-dark mr-1 mb-1">Flyer</a>
      <input type="text" class="mr-1 mb-1 float-right search" placeholder="Search here...">
   </div>
</div>
<?php
include 'layout/posts.php';
include 'layout/footer.php';
require 'layout/plugins.php';
?>
