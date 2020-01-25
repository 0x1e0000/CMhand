<?php
session_start();
//Middleware
if (isset($_SESSION['id_Users'])) {
   header('Location: dashboard.php');
   exit();
}
require 'layout/head.php';
?>
<nav class="navbar navbar-expand-sm fixed-top" id="navbar">
   <div class="container">
      <a class="navbar-brand" href="#">
         <img src="assets/img/logo/Logo.png" width="30" height="30" class="d-inline-block align-top mr-2" alt="">
         <span>CMhand</span>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-index" aria-controls="navbar-index" aria-expanded="false" aria-label="Toggle navigation">
         <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbar-index">
         <div class="navbar-nav paragraph m-0 text-center">
            <a class="nav-item nav-link mr-3" href="about.php">About</a>
            <a class="nav-item nav-link mr-3" href="contact.php">Contact</a>
            <a class="nav-item nav-link mr-3 signin" href="login.php">Sign In</a>
            <a class="nav-item nav-link btn btn-main px-3" href="signup.php">Sign Up<i class="fas fa-user-plus ml-2"></i></a>
         </div>
      </div>
   </div>
</nav>

<header class="container-fluid mt-5" id="header">
   <div class="row">
      <div class="col-md-6">
         <div class="slogan">
            <h1 class="header">Slogan</h1>
            <div class="line"></div>
            <p class="paragraph">
                CMHAND is the leading online platform to showcase & discover creative work. Creative people around the world join CMHAND and build profiles comprised of Projects. A Project is a digital content with a particular theme or process Designs. Every Project has a unique URL that can be shared all over the internet and leads back to CMHAND.
            </p>
         </div>
      </div>
      <div class="col-md-6">
         <img src="assets/img/illustrations/main.svg" alt="" class="illustration">
      </div>
   </div>
</header>

<section id="features" class="mt-2 mb-5">
   <div class="row">
      <div class="col-md-5">
         <img src="assets/img/illustrations/features.svg" alt="" class="illustration">
      </div>
      <div class="col-md-7">
         <div class="features">
            <h1 class="header">Features</h1>
            <p class="p-2 paragraph">
                Only Post Your Best Work    |   Present Your Work Well <br>
                Advertise Your Work     |    Update Your Profile <br>
            </p>
            <a href="signup.php" class="btn btn-main">Get Started<i class="fas fa-angle-right ml-2"></i></a>
         </div>
      </div>
   </div>
</section>

<section id="review">
   <div id="carouselReview" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner px-5">
         <div class="carousel-item active">
            <div class="text-center">
               <p class="paragraph">
                  <i class="fa fa-quote-left"></i>
                  We design and develop services for customers of all sizes, <br>
                  specializing in creating stylish, modern websites and online stores.
                  <i class="fa fa-quote-right"></i>
               </p>
               <small class="small">- Daniel Watrous -</small>
            </div>
         </div>
         <div class="carousel-item">
            <div class="text-center">
               <p class="paragraph">
                  <i class="fa fa-quote-left"></i>
                  We design and develop services for customers of all sizes, <br>
                  specializing in creating stylish, modern websites and online stores.
                  <i class="fa fa-quote-right"></i>
               </p>
               <small class="small">- Daniel Watrous -</small>
            </div>
         </div>
         <div class="carousel-item">
            <div class="text-center">
               <p class="paragraph">
                  <i class="fa fa-quote-left"></i>
                  We design and develop services for customers of all sizes, <br>
                  specializing in creating stylish, modern websites and online stores.
                  <i class="fa fa-quote-right"></i>
               </p>
               <small class="small">- Daniel Watrous -</small>
            </div>
         </div>
      </div>
      <a class="carousel-control-prev" href="#carouselReview" role="button" data-slide="prev">
         <span class="carousel-control-prev-icon" aria-hidden="true"></span>
         <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselReview" role="button" data-slide="next">
         <span class="carousel-control-next-icon" aria-hidden="true"></span>
         <span class="sr-only">Next</span>
      </a>
   </div>
</section>
<?php
include 'layout/posts.php';
include 'layout/footer.php';
require 'layout/plugins.php';
 ?>
