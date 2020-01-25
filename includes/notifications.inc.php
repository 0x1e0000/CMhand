<?php
	//Return notification time
	function time_elapsed_string($datetime, $full = false) {
		$now = new DateTime; //current time
		$ago = new DateTime($datetime); //Time from database
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

	require 'dbh.inc.php';
	session_start();

	//on load the page
	if (isset($_POST['load'])){
		//Get notifications number for current user
		$query = "SELECT COUNT(*) FROM notifications WHERE id_Users != $_SESSION[id_Users] AND status_Notifications = false AND id_Posts IN (SELECT id_Posts FROM posts WHERE id_Users = $_SESSION[id_Users]);";
		$result = mysqli_query($connect, $query);
		$row = mysqli_fetch_assoc($result);
		if ($row["COUNT(*)"] > 0)
			echo $row["COUNT(*)"];
		exit();
	}

	//click on see notifications
	if (isset($_POST['clicked'])){
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
	}

	mysqli_close($connect);
