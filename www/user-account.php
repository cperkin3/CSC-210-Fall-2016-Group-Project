<!doctype html>
<html>
	<head>
		<title>CSC 210 Project</title>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="css/nav-bar.css">
		<link rel="stylesheet" type="text/css" href="css/login-bar.css">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<!-- JavaScript --> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="js/header.js"></script>
	</head>
	<body>
		<header> 
			<div class="login-top">
				<div id="logged-in">
					<span id="welcome-name"></span>
					<form method="POST" action="cgi-bin/logout.py">
						<input type="submit" value="Log out"/>
					</form>
				</div>
				<div id="logged-out">
					<form method="POST" action="cgi-bin/login.py">
						Username: <input type="text" name="username" required/> 
						Password: <input type="password" name="password" required/>
						<input type="submit" value="Log in!"/>
					</form>
					<a href="create-account.php">Create Account</a>
				</div>
				<script type="text/javascript">
					showHeader();
				</script>
			</div>
		</header>
		<nav>
			<ul>
				<li>
					<a href="index.php">Home</a>
				</li>
				<li>
					<a href="forum/forum.php">Forum</a>
				</li>	
				<li>
					<a href="wiki/wiki.php">Wiki</a>
				</li>
				<li>
					<a href="about.php">About</a>
				</li>
				<li>
					<a class="current" href="user-account.php">User Account</a>
				</li>
			</ul>
		</nav>
		<article>
			<h1>User Home Page</h1>
			
			<?php
			session_start();

			if(!isset($_COOKIE['logged_in'])) {
				echo "Please log in to view your profile";
			}
			else { // Person is Logged In
				$user_name = $_COOKIE["logged_in"];
			
				//connect to thrones database
				$servername = "localhost";
				$username = "root";
				$password = "mysql";
				$dbname = "Thrones_Database";
				
				try {
					$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
					// Set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$stmt = $conn->prepare("SELECT * FROM Users WHERE username = '$user_name'");
					$stmt->execute();
					
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Necessarily exactly 1 result
						$bio = $row["bio"];
						$birthdate = $row["birthdate"];
						$email = $row["email"];
						$favorite_character = $row["favorite_character"];
						$join_date = $row["join_date"];
						$profile_last_updated = $row["profile_last_updated"];
						$profile_pic = $row["profile_pic"];
						
						echo "User: $user_name";
						echo "<BR/>";
						echo "Birthdate: $birthdate";
						echo "<BR/>";
						echo "Join Date: $join_date";
						echo "<BR/>";
						echo "Proflie Last Updated: $profile_last_updated";
						echo "<BR/><BR/>";
						echo "Email: $email";
						echo "<BR />";
						echo '<form method="post" action="cgi-bin/update-user-field.py">
								Update Value: <input type="text" name="email" required/>
								<input type="submit" value="Change"/>
							</form>
							<BR/>';
						echo "Favorite Character: $favorite_character";
						echo "<BR />";
						echo '<form method="post" action="cgi-bin/update-user-field.py">
								Update Value: <input type="text" name="favorite_character" required/>
								<input type="submit" value="Change"/>
							</form>
							<BR/>';
						echo "Proflie Picture: $profile_pic";
						echo "<BR />";
						echo '<form method="post" action="cgi-bin/update-user-field.py">
								Update Value: <input type="text" name="profile_pic" required/>
								<input type="submit" value="Change"/>
							</form>
							<BR/>';
						echo "Bio: $bio";
						echo "<BR />";
						echo '<form method="post" action="cgi-bin/update-user-field.py">
								Update Value: <input type="text" name="bio" required/>
								<input type="submit" value="Change"/>
							</form>
							<BR/>';
					}
				}
				catch (PDOException $e) {
					echo "Error: " . $e->getMessage() . "<br/>";
					die();
				}
			}
			?>	
		</article>		
	</body>
</html>