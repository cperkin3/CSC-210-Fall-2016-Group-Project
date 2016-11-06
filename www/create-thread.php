<!doctype html>
<html>
	<head>
		<title>CSC 210 Project</title>
		<?php include("includes/imports.html");?>
	</head>
	<body>
		<?php include("includes/header.html");?>
		<nav><!-- All Top-level .html files should have exactly the same header contents -->
			<ul>
				<li>
					<a href="../index.php">Home</a>
				</li>
				<li>
					<a href="../forum.php">Forum</a>
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
					<a href="">Forum Home</a>
				</li>
				<li>
					<a href="forum/general.php">General</a>
				</li>
				<li>
					<a href="forum/characters.php">Characters</a>
				</li>
				<li>
					<a href="forum/differences.php">Differences</a>
				</li>
				<li>
					<a href="forum/other.php">Other</a>
				</li>
				<li>
					<a href="create-thread.php">Create New Thread</a>
				</li>
			</ul>
		</aside>
		<article>
			<BR><BR><BR><BR>
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
				Content: <input type="textarea" name="content" required/><br/>
				<input type="submit" value="Create!"/>
			</form>
		</article>
		<aside>
		
		</aside>
		<footer>
		
		</footer>
		
	</body>
</html>