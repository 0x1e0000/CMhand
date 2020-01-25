<?php
   require 'layout/head.php';
   cssLink('contact');
?>

<section class="row" id="contact">
      <div class="col-md-5">
         <a href="index.php">
            <img src="assets/img/logo/logo.png" width="30" height="30" style="margin-top: 32px;margin-left: 64px;">
         </a>
         <img src="assets/img/illustrations/contact.svg" alt="" class="illustration">
      </div>
      <div class="col-md-7" id="contact-form">
         <div class="row">
            <h2 class="col-8 header">Contact Us</h2>
            <div class="col-4 text-right dropdown">
               <button class="btn bg-transparent" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-bars"></i>
               </button>
               <div class="dropdown-menu dropdown-menu-right paragraph" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="index.php">Home</a>
                  <a class="dropdown-item" href="about.php">About</a>
               </div>
            </div>
         </div>
         <div class="line"></div>
         <div class="row justify-content-center subtitle text-dark">
            <form class="w-100 mt-5 px-3">
               <div class="row form-group col ml-0">
                  <label class="font-weight-bold">Full Name</label>
                  <input type="text" class="form-control" placeholder="Please enter your full name ...">
               </div>
               <div class="row form-group col ml-0">
                  <label class="font-weight-bold">Email</label>
                  <input type="text" class="form-control" placeholder="Please Enter your email ...">
               </div>
               <div class="row form-group col ml-0">
                  <label class="font-weight-bold">Subject</label>
                  <input type="text" class="form-control" placeholder="Enter the subject ...">
               </div>
               <div class="row form-group col ml-0">
                  <label class="font-weight-bold">Message</label>
                  <textarea  rows="8" cols="80" class="form-control" placeholder="Write your message here ..."></textarea>
               </div>
               <div class="row form-group col ml-0">
                  <button class="btn btn-main m-0 col" type="submit">Send Message! <i class="fas fa-paper-plane ml-2"></i></button>
               </div>
               <div class="row form-group col ml-0">
                  <div class="col p-0 text-center">
                     <!-- Error Messages here -->
                     <!--p class="alert alert-danger">Lorem ipsum dolor sit amet, consectetur adipisicing.</p-->
                  </div>
               </div>
            </form>
         </div>
      </div>
   </section>

<?php
require 'layout/plugins.php';
?>
