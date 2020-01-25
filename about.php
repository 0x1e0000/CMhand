<?php
   require 'layout/head.php';
   cssLink('about');
?>
<nav class="navbar navbar-expand-sm pt-4">
   <div class="container pt-4">
      <a class="navbar-brand" href="index.php">
         <img src="assets/img/logo/logowhite.png" width="30" height="30" class="d-inline-block align-top mr-2" alt="">
      </a>
      <div class="text-right dropdown">
         <button class="btn bg-transparent" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bars text-white"></i>
         </button>
         <div class="dropdown-menu dropdown-menu-right paragraph" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="index.php">Home</a>
            <a class="dropdown-item" href="contact.php">Contact</a>
         </div>
      </div>
   </div>
</nav>

<section id="about">
   <h1 class="text-center header text-white">About Us</h1>
   <div class="line"></div>
   <div class="bg-main">
      <div class="photo"></div>
      <h4 class="header text-white text-center">MOHAMED AIT SI MHAND</h4>
      <p class="paragraph text-white text-center m-0">
          I’m a web developer. I spend my whole day, practically every day, experimenting with HTML, CSS, JavaScript, JQuery, Bootstrap, PHP and MySQL;<br>
          I’m curious, and I enjoy work that challenges me to learn something new and stretch in a different direction. I do my best to stay on top of changes in the state of the art so that I can meet challenges with tools well suited to the job at hand.
      </p>
      <div class="social-media text-center">
         <a href="https://www.facebook.com/0x10000" target="_blank">
            <i class="fab fa-facebook-f text-white mx-2"></i>
         </a>
         <a href="https://www.instagram.com/bboyaitsi" target="_blank">
            <i class="fab fa-instagram text-white mx-2"></i>
         </a>
         <a href="https://www.linkedin.com/in/mohamed-ait-si-m-hand-a4b687161/" target="_blank">
            <i class="fab fa-linkedin-in text-white mx-2"></i>
         </a>
      </div>
   </div>
</section>

<?php
require 'layout/plugins.php';
?>
