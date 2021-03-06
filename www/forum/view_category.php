<!doctype html>
<html>
	<head>
		<title>CSC 210 Project</title>
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
					<a class="current" href="forum.php">Forum</a>
				</li>	
				<li>
					<a href="../wiki/wiki.php">Wiki</a>
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
			<?php
				$category = $_GET['category'];
				if ($category == "General") {
					echo "<h1>General Discussion</h1>";
					echo "This is a forum intended for general discussion of the GoT/ASoiaF franchise, including, but not limited to, overlaps between the two, fan theories, etc.<br>";
				} else if ($category == "Characters") {
					echo "<h1>Character Discussion</h1>";
					echo "This is a forum intended discussion of specific characters.<br>";
				} else if ($category == "Differences") {
					echo "<h1>Differences Discussion</h1>";
					echo "This is a forum intended for discussion of the differences between the GoT and ASoiaF franchises.<br>";
				} else if ($category == "Other") {
					echo "<h1>Other Discussion</h1>";
					echo "This is a forum intended for miscellaneous discussion, including, but not limited to, the GOT/ASoiaF franchise, meta-discussion, etc.<br>";
				} else {
					echo "You seem to have taken a wrong turn. Sorry about that.</article></body></html>";
					die();
				}
			?>
			Here is the most recent activity on this board:<br>
			<?php
				echo "$category<br>";
			?>
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
								
								//"SELECT * FROM Wiki_Pages WHERE last_edited_datetime=(SELECT MAX(last_edited_datetime) FROM Wiki_Pages WHERE category_name='Places') LIMIT 1"
								
								$stmt = $conn->prepare("SELECT title, thread_id, user_created_by, Forum_Threads.created_datetime, MAX(Forum_Posts.created_datetime) FROM Forum_Posts INNER JOIN Forum_Threads WHERE category_name='$category' AND thread_id=Forum_Threads.id GROUP BY thread_id ORDER BY MAX(Forum_Posts.created_datetime) DESC;");
								
								//$stmt = $conn->prepare("SELECT title, thread_id, user_created_by, Forum_Posts.created_datetime, Forum_Threads.created_datetime FROM ")
								
								$stmt->execute();
								
								// Display each result
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									echo "<tr>";
									echo "<td><a href=\"viewthread.php?id=" . $row['thread_id'] . "\"> " . $row['title'] . "</a></td>";
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
	</body>
</html>