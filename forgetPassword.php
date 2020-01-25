<?php
   session_start();
   if (isset($_SESSION['id_Users'])) {
      header('Location: dashboard.php');
      exit();
   }
   require 'layout/head.php';
   cssLink('forgetPassword');
?>
   <section class="row">
      <div class="col-md-5" id="forgetPassword">
         <div class="head">
            <div class="row">
               <h2 class="col-9 header">Forget Password!</h2>
               <div class="col-3 text-right dropdown">
                  <button class="btn bg-transparent" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <i class="fas fa-bars"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right paragraph" aria-labelledby="dropdownMenuButton">
                     <a class="dropdown-item" href="index.php">Home</a>
                     <a class="dropdown-item" href="about.php">About</a>
                     <a class="dropdown-item" href="contact.php">Contact</a>
                  </div>
               </div>
            </div>
            <div class="line"></div>
         </div>
         <div class="row justify-content-center">
            <form class="w-75 mt-5 subtitle text-dark" id="forgetPassword_form">
               <div class="form-group">
                  <label class="font-weight-bold">Email</label>
                  <div class="input-group mb-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-sign-in-alt"></i></div>
                     </div>
                     <input type="text" class="form-control" placeholder="Enter your email ...">
                  </div>
               </div>
               <button type="submit" class="btn btn-main mt-2">Submit <i class="fas fa-arrow-right"></i></button>
               <div class="row">
                  <div class="col mt-3 text-center">
                     <!-- Error Messages here -->
                     <!--p class="alert alert-danger">Lorem ipsum dolor sit amet, consectetur adipisicing.</p-->
                  </div>
               </div>
               <div class="row">
                  <div class="col text-center">
                     <a href="signup.php" class="small">Creat an account</a>
                     <span class="small mx-1">or</span>
                     <a href="login.php" class="small">login</a>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <div class="col-md-7" id="forgetPassword-illu">
         <a href="index.php">
            <img src="assets/img/logo/logo.png" width="30" height="30" alt="">
         </a>
         <img class="illustration" src="assets/img/illustrations/forgotPassword.svg">
      </div>
   </section>


   <?php
   require 'layout/plugins.php';
   ?>
