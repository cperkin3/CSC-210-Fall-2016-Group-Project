<!doctype html>
<html>
	<head>
		<title>Differences Discussion</title>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="../css/nav-bar.css">
		<link rel="stylesheet" type="text/css" href="../css/login-bar.css">
		<link rel="stylesheet" type="text/css" href="../css/styles.css">
		<link rel="stylesheet" type="text/css" href="../css/forum-table.css">
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
		<nav>
			<ul>
				<li>
					<a href="../index.php">Home</a>
				</li>
				<li>
					<a class="current" href="../forum.php">Forum</a>
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
					<a href="../forum.php">Forum Home</a>
				</li>
				<li>
					<a href="general.php">General</a>
				</li>
				<li>
					<a href="characters.php">Characters</a>
				</li>
				<li>
					<a href="differences.php">Differences</a>
				</li>
				<li>
					<a href="other.php">Other</a>
				</li>
				<li>
					<a href="../create-thread.php">Create New Thread</a>
				</li>
			</ul>
		</aside>
		<article>
			<br><br><br><br>
			<h1>General Discussion</h1>
			This is a forum intended for discussion of the differences between the GoT and ASoiaF franchises.<br>
			Here is the most recent activity on this board:<br>
			<!-- TODO : Ask Chris for CSS help on this table. I can't seem to get it to do anything -->
			<table>
				<thead>
					<th>Thread Title</th>
					<th>Author</th>
					<th>Created</th>
					<th>Last Reply</th>
				</thead>
				<tbody>
					<?php 
						$servername = "localhost";
						$username = "root";
						$password = "mysql";
						$dbname = "Thrones_Database";

							try {
								// Connect to Database
								$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

								// Set the PDO error mode to exception
								$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

								// Query the database
								$stmt = $conn->prepare('SELECT title, thread_id, user_created_by, Forum_Threads.created_datetime, MAX(Forum_Posts.created_datetime) FROM Forum_Posts INNER JOIN Forum_Threads WHERE category_name="Differences" AND thread_id=Forum_Threads.id GROUP BY thread_id ORDER BY Forum_Posts.created_datetime DESC;');
								$stmt->execute();
								
								// Display each result
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									// TODO : Find out where links need to go
									echo "<tr>";
									echo "<td><a href=\"" . $row['title'] . "\"> " . $row['title'] . "</a></td>";
									echo "<td>" . $row['user_created_by'] . "</td>";
									echo "<td>" . $row['created_datetime'] . "</td>";
									echo "<td>" . $row['MAX(Forum_Posts.created_datetime)'] . "</td>";
									echo "</tr>\n";
								}
								
							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage() . "<br/>";
								die();
							}
					?>
				</tbody>
			</table>
		</article>
		<aside>
		
		</aside>
		<footer>
		
		</footer>
		
	</body>
</html>