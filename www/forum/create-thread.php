<!doctype html>
<html>
	<head>
		<title>CSC 210 Project</title>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="../css/nav-bar.css">
		<link rel="stylesheet" type="text/css" href="../css/login-bar.css">
		<link rel="stylesheet" type="text/css" href="../css/styles.css">
		<!-- JavaScript --> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="../js/header.js"></script>
	</head>
	<body>
		<header> 
			<div class="login-top">
				<div id="logged-in">
					<span id="welcome-name"></span>
					<form method="POST" action="../cgi-bin/logout.py">
						<input type="submit" value="Log out"/>
					</form>
				</div>
				<div id="logged-out">
					<form method="POST" action="../cgi-bin/login.py">
						Username: <input type="text" name="username" required/> 
						Password: <input type="password" name="password" required/>
						<input type="submit" value="Log in!"/>
					</form>
					<a href="../create-account.php">Create Account</a>
				</div>
				<script type="text/javascript">
					showHeader();
				</script>
			</div>
		</header>
		<nav><!-- All Top-level .html files should have exactly the same header contents -->
			<ul>
				<li>
					<a href="../index.php">Home</a>
				</li>
				<li>
					<a class="current" href="forum.php">Forum</a>
				</li>	
				<li>
					<a href="../wiki.php">Wiki</a>
				</li>
				<li>
					<a href="../about.php">About</a>
				</li>
				<li>
					<a href="../user-account.php">User Account</a>
				</li>
			</ul>
		</nav>
		<aside class="nav-aside">
			<ul>
				<li>
					<a href="forum.php">Forum Home</a>
				</li>
				<li>
					<a href="view_category.php?category=General">General</a>
				</li>
				<li>
					<a href="view_category.php?category=Characters">Characters</a>
				</li>
				<li>
					<a href="view_category.php?category=Differences">Differences</a>
				</li>
				<li>
					<a href="view_category.php?category=Other">Other</a>
				</li>
				<li>
					<a href="create-thread.php">Create New Thread</a>
				</li>
			</ul>
		</aside>
		<article class="forum">
			<h1>Create New Thread</h1>
			<br>
			To create a new thread, please enter the following information and click 'Create!'.
			<br>
			<form method="post" action="../cgi-bin/create-thread.py">
				Category: <select name="category" required>
					<?php
						$servername = "localhost";
						$username = "root";
						$password = "mysql";
						$dbname = "Thrones_Database";

						try {
							$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

							// Set the PDO error mode to exception
							$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

							$stmt = $conn->prepare('SELECT name FROM Forum_Categories;');
							$stmt->execute();

							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value=\"" . $row['name'] . "\"> " . $row['name'] . "</option>";
							}

						} catch (PDOException $e) {
							echo "Error: " . $e->getMessage() . "<br/>";
							die();
						}
					?>
				</select>
				Title: <input type="text" name="title" required/><br/>
				Post Content: <textarea cols="40" rows="5" name="content" required></textarea><br/>
				<input type="submit" value="Create!"/>
			</form>
		</article>
	</body>
</html>