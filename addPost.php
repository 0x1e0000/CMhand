<?php
session_start();
if (!isset($_SESSION['id_Users'])) {
   header('Location: index.php');
   exit();
}
require 'layout/head.php';
cssLink('addPost');
cssLink('profile');
include 'layout/navbar.php';
?>
<section class="container pb-5" id="addPost">
   <div class="row form-group col m-0 paragraph">
      <div class="col p-0 text-center">
         <!-- Error Messages here -->
         <?php
            if (isset($_GET['error'])) {
               if ($_GET['error'] == 'enptyFields') {
                  echo "<p class='alert alert-danger'>There is empty fields.</p>";
               }elseif ($_GET['error'] == 'sqlError') {
                  echo "<p class='alert alert-info'>There is something wrrong, refrech the page and try again.</p>";
               }elseif ($_GET['error'] == 'TitleIsTooLong') {
                  echo "<p class='alert alert-info'>Title is too long, (you have just 255 charachters to use)</p>";
               }elseif ($_GET['error'] == 'DescriptionIsTooLong') {
                  echo "<p class='alert alert-info'>Description is too long, (you have just 5000 charachters to use)</p>";
               }elseif ($_GET['error'] == 'TagsAreTooLong') {
                  echo "<p class='alert alert-info'>Tags are too long, (you have just 255 charachters to use)</p>";
               }elseif ($_GET['error'] == 'PostBigSize') {
                  echo "<p class='alert alert-danger'>Size of the file is big than 10Mb.</p>";
               }elseif ($_GET['error'] == 'ErrorPost') {
                  echo "<p class='alert alert-info'>There is some error on your file.</p>";
               }elseif ($_GET['error'] == 'uploadPhoto') {
                  echo "<p class='alert alert-danger'>You have to upload a Photo with some extentions like (png - jpg - jpeg).</p>";
               }
            }elseif(isset($_GET['success'])){
               if ($_GET['success'] == 'Uploading') {
                  echo "<p class='alert alert-success'>Posting successfully.</p>";
               }
            }
         ?>
      </div>
   </div>
      <form class="row" action="includes/uploadPost.inc.php" method="post" enctype="multipart/form-data">
         <div class="col-md-6 uploadPost">
            <input name="file" type="file" accept="image/*" id="uploadPost" class="d-none">
            <label for="uploadPost" class="text-main" style="padding:160px;">
               <i class="fas fa-cloud-upload-alt fa-3x"></i>
               <h5 class="my-3 subtitle" id="fileLabelText">Drag & Drop or Click to Upload Photo</h5>
            </label>
         </div>
         <div class="col-md-6 justify-content-center subtitle text-dark">
            <div class="row form-group col m-0 mb-3">
               <label class="font-weight-bold">Title</label>
               <input name="title" type="text" class="form-control" placeholder="Please enter title of your work ..." value="<?php echo $_GET['title']; ?>">
            </div>
            <div class="row form-group col m-0 mb-3">
               <label class="font-weight-bold">Discription</label>
               <textarea name="description" rows="8" cols="83" class="form-control" placeholder="Write your message here ..."><?php echo $_GET['description']; ?></textarea>
            </div>
            <div class="row form-group col m-0 mb-3">
               <label class="font-weight-bold">Tags</label>
               <input id="tags" data-role='tags-input' name="tags" type="text" class="form-control" placeholder="Enter the tags related with your project ..." value="<?php echo $_GET['tags']; ?>">
            </div>
            <div class="row form-group col m-0 mb-3">
               <button name="upload-post" class="btn btn-main m-0 mt-2 col" type="submit">POST <i class="fas fa-share ml-1"></i></button>
            </div>
         </div>
      </form>
</section>
<?php
include 'layout/footer.php';
require 'layout/plugins.php';
?>
