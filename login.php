<?php
   session_start();
   if (isset($_SESSION['id_Users'])) {
      header('Location: dashboard.php');
      exit();
   }
   require 'layout/head.php';
   cssLink('login');
?>
   <section class="row">
      <div class="col-md-5" id="login">
         <div class="head">
            <div class="row">
               <h2 class="col header">Hello!</h2>
               <div class="col text-right dropdown">
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
            <form class="w-75 mt-5 subtitle text-dark" id="login_form" action="includes/login.inc.php" method="post">
               <h3 class="subtitle text-dark"><span class="font-weight-bold">Login</span> your account</h3>
               <div class="form-group">
                  <label class="font-weight-bold">Email / Username</label>
                  <div class="input-group mb-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-sign-in-alt"></i></div>
                     </div>
                     <input type="text" class="form-control" placeholder="Enter email or username ..." name="email" value="<?php echo $_GET['email']; ?>">
                  </div>
               </div>
               <div class="form-group">
                  <label class="font-weight-bold">Password</label>
                  <div class="input-group">
                     <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-key"></i></div>
                     </div>
                     <input type="password" class="form-control" placeholder="Enter password ..." name="password">
                  </div>
                  <a href="forgetPassword.php" class="float-right text-muted"><span class="small">Forget Password?</span></a>
               </div>
               <button type="submit" name="login-submit" class="btn btn-main mt-2">Login <i class="fas fa-arrow-right"></i></button>
               <div class="row">
                  <div class="col mt-3 text-center">
                     <!-- Error Messages -->
                     <?php
                        if (isset($_GET['error'])) {
                           if ($_GET['error'] == 'emptyFields') {
                              echo "<p class='alert alert-danger'>There is empty fields.</p>";
                           }elseif($_GET['error'] == 'wrrongPwd'){
                              echo "<p class='alert alert-danger'>wrong password.</p>";
                           }elseif($_GET['error'] == 'noUser'){
                              echo "<p class='alert alert-danger'>there is no account with this email or username.</p>";
                           }elseif($_GET['error'] == 'sqlError'){
                              echo "<p class='alert alert-info'>Ops! Something went wrong!</p>";
                           }
                        }
                     ?>
                  </div>
               </div>
               <a href="signup.php" class="d-block text-center"><span class="small">Creat Account</span></a>
            </form>
         </div>
      </div>
      <div class="col-md-7" id="login-illu">
         <a class="" href="index.php">
            <img src="assets/img/logo/logo.png" width="30" height="30" alt="">
         </a>
         <img class="illustration" src="assets/img/illustrations/login.svg" alt="Login">
      </div>
   </section>


   <?php
   require 'layout/plugins.php';
   ?>
