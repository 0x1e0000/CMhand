<?php
   include 'includes/dbh.inc.php';
   session_start();
   $limit = $_POST['limit'];
   $query = "SELECT * FROM posts INNER JOIN users ON posts.id_Users = users.id_Users Limit $limit;";

	$result = mysqli_query($connect, $query);
	if (!$result) {
		header('Location: profile.php?error=sqlError');
		exit();
	}else {
		while ($row = mysqli_fetch_assoc($result)) {
			$me = false;
			if ($row['avatar_Users'] == null) {
				if ($row['gender_Users'] == 'male') $avatar_post = 'male-avatar.jpg';
				else $avatar_post = 'female-avatar.jpg';
			}else $avatar_post = $row['avatar_Users'];
			if ($row['id_Users'] == $_SESSION['id_Users']){
				$username = 'profile.php';
				$me = true;
			}
			else $username = "visit.php?username=$row[username_Users]";
			echo "
               <article class='col-lg-3 col-md-4 col-sm-6 my-3'>
                  <div class='shadow-sm rounded'>
                     <div class='card-header p-2 bg-white border-0'>
                        <a href='$username'>
                           <div class='profile-img' style='background-image: url(assets/img/uploads/avatars/$avatar_post);'></div>
                           <p class='paragraph d-inline-block m-0 text-dark align-middle text-truncate' style='max-width: 200px;'>".ucwords($row['firstname_Users'])." ".ucwords($row['lastname_Users'])."</p>
                        </a>
                     </div>
                     <div class='card border-0'>
                        <div class='post-img' style='background-image: url(assets/img/uploads/posts/$row[path_Posts]);'></div>
                        <div class='card-body p-2'>
                           <h5 class='subtitle m-0 text-truncate'>
                              <a href='viewPost.php?postid=$row[id_Posts]&userid=$row[id_Users]#viewPost'>".ucwords($row['title_Posts'])."</a>
                           </h5>
                           <p class='text-truncate paragraph my-1'><small>".ucwords($row['description_Posts'])."</small></p>
                           ";
			if (!isset($_SESSION['id_Users'])){
				echo "<a href='login.php'><i class='fas fa-heart'></i></a>";
			}else {
				$id_Post = $row['id_Posts'];
				//look for this post if is already liked by user
				$sql = "SELECT * FROM likes WHERE id_Users = $_SESSION[id_Users] AND id_Posts = $id_Post;";
				$results = mysqli_query($connect, $sql);
				//if there user already liked this post
				if (mysqli_num_rows($results) > 0)
					echo "<a id='$id_Post' class='unlike' data-toggle='tooltip' data-placement='bottom' title='Unlove'><i class='fas fa-heart text-danger'></i></a>";
				else //if there is no liks by user to this post
					echo "<a id='$id_Post' class='like' data-toggle='tooltip' data-placement='bottom' title='Love'><i class='fas fa-heart'></i></a>";
			}
			echo "
                           <small class='small text-dark'>$row[likes_Posts]</small>
                           ";
			if ($me) {
				echo "<button type='button' class='btn btn-sm bg-white small text-danger float-right border-0 p-0 deletePost' id='$row[id_Posts]'><i class='far fa-trash-alt'></i></button>
                                 <a href='editPost.php?postid=$id_Post&userid=$_SESSION[id_Users]' class='btn btn-sm small bg-white text-main float-right mr-2 p-0 border-0' id='$row[id_Posts]'><i class='far fa-edit'></i></a>";
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
?>
