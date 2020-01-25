<?php
session_start();
//Midleware
if (!isset($_SESSION['id_Users'])) {
	header('Location: index.php');
	exit();
}
require 'layout/head.php';
include 'layout/navbar.php';
?>
	<section class="container" id="notifications">
		<?php 
		include_once 'includes/dbh.inc.php';
		//set notifications status to true
		mysqli_query($connect,"UPDATE notifications SET status_Notifications = true WHERE id_Posts IN (SELECT id_Posts FROM posts WHERE posts.id_Users = $_SESSION[id_Users])");
		
		//Get notifications to the user
		$query = "SELECT * FROM notifications INNER JOIN users ON notifications.id_Users = users.id_Users WHERE users.id_Users != $_SESSION[id_Users] AND id_Posts IN (SELECT id_Posts FROM posts WHERE id_Users = $_SESSION[id_Users]) ORDER BY time_Notifications DESC LIMIT 10;";
		$result = mysqli_query($connect, $query);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$avatar_users = $row['avatar_Users'];
				$username_users = $row['username_Users'];
				$type_notification = $row['type_Notifications'];
				$time_notification = $row['time_Notifications'];
				$id_Posts = $row['id_Posts'];
				echo "
				<div class='notification d-flex justify-content-between align-items-center'>
					<div class='notification-profile shadow-sm'>
						<a href='visit.php?username=$username_users'>
							<img src='assets/img/uploads/avatars/$avatar_users'>
						</a>
					</div>
					<div class='notification-body'>
						<a href='viewPost.php?postid=$id_Posts&userid=$_SESSION[id_Users]'>
							<p class='small'><b class='mr-2'>".ucfirst($username_users)."</b>";
								if ($type_notification == 'like') echo "Likes your design.";
								echo "
							</p>
						</a>
					</div>
					<small class='notification-timer small'>".time_elapsed_string($time_notification)."</small>
				</div>";
			}
		}else echo "<p class='paragraph text-center'>No notifications</p>";
		?>
	</section>
<?php
require 'layout/plugins.php';
?>