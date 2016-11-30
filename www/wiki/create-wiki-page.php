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
					<a href="../forum/forum.php">Forum</a>
				</li>	
				<li>
					<a class="current" href="wiki.php">Wiki</a>
				</li>
				<li>
					<a href="../about.php">About</a>
				</li>
				<li>
					<a href="../user-account.php">User Account</a>
				</li>
			</ul>
		</nav>
		
		<article class="forum">
			<h1>Create New Page</h1>
			<br>
			Think a page is missing? Make it yourself! Please enter the following information and click 'Create!'.
			<br>
			<form method="post" action="../cgi-bin/create-wiki-page.py">
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

							$stmt = $conn->prepare('SELECT name FROM Wiki_Categories;');
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
				Page Content: <textarea cols="40" rows="5" name="content" required></textarea><br/>
				<input type="submit" value="Create!"/>
			</form>
		</article>
	</body>
</html>