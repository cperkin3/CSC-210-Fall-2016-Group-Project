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
			<form method="post" action="../cgi-bin/search-wiki.py" id="wiki-search-bar">
				<input type="text" name="search-bar" id="wiki-search-text-entry" required/>
				<input type="submit" id="wiki-search-submit" value="SEARCH"/>
			</form>
			<h1>THROOOOOOOOONES Wiki Home</h1>
			<hr> 
				<h2> Learn something random about Game of Thrones! </h2>
				<?php

					$servername = "localhost";
					$username = "root";
					$password = "mysql";
					$dbname = "Thrones_Database";

					try {

						$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

						// Set the PDO error mode to exception
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						$stmt = $conn->prepare("SELECT * FROM Wiki_Pages ORDER BY RAND() LIMIT 1");
						$stmt->execute();

						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							echo "<a href=\"../wiki/view-wiki-page.php?title=" . $row['title'] . "\">" . $row['title'] . "</a>";
						}

					} catch (PDOException $e) {
						echo "Error: " . $e->getMessage() . "<br/>";
						die();
					}

				?>
			<hr>
				<h2> Longest wiki page </h2>  
			<?php
				try {
					$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

					// Set the PDO error mode to exception
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$stmt = $conn->prepare("SELECT * FROM Wiki_Pages ORDER BY LENGTH(content) DESC LIMIT 1");
					$stmt->execute();

					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$page_title = $row["title"];
						echo "<a href=\"view-wiki-page.php?title=$page_title\">$page_title</a>";
					}
				} catch (PDOException $e) {
					echo "Error: " . $e->getMessage() . "<br/>";
					die();
				}
			?>	
			<hr> 
				<h2> Last Edited wiki by category </h2>
				
				<?php

					try {

						$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

						// Set the PDO error mode to exception
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						$stmt = $conn->prepare("SELECT * FROM Wiki_Pages WHERE last_edited_datetime=(SELECT MAX(last_edited_datetime) FROM Wiki_Pages WHERE category_name='People') LIMIT 1");
						$stmt->execute();
						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						echo "<h3>";
						echo $row['category_name'];
						echo "</h3>";
						echo "<ul>";
						echo "<li><a href=\"view-wiki-page.php?title=" . $row['title'] . "\">" . $row['title'] . "</a></li>";
						echo "</ul>";
						
						$stmt = $conn->prepare("SELECT * FROM Wiki_Pages WHERE last_edited_datetime=(SELECT MAX(last_edited_datetime) FROM Wiki_Pages WHERE category_name='Places') LIMIT 1");
						$stmt->execute();
						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						echo "<h3>";
						echo $row['category_name'];
						echo "</h3>";
						echo "<ul>";
						echo "<li><a href=\"view-wiki-page.php?title=" . $row['title'] . "\">" . $row['title'] . "</a></li>";
						echo "</ul>";
						
						$stmt = $conn->prepare("SELECT * FROM Wiki_Pages WHERE last_edited_datetime=(SELECT MAX(last_edited_datetime) FROM Wiki_Pages WHERE category_name='Events') LIMIT 1");
						$stmt->execute();
						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						echo "<h3>";
						echo $row['category_name'];
						echo "</h3>";
						echo "<ul>";
						echo "<li><a href=\"view-wiki-page.php?title=" . $row['title'] . "\">" . $row['title'] . "</a></li>";
						echo "</ul>";
						
						$stmt = $conn->prepare("SELECT * FROM Wiki_Pages WHERE last_edited_datetime=(SELECT MAX(last_edited_datetime) FROM Wiki_Pages WHERE category_name='Miscellaneous') LIMIT 1");
						$stmt->execute();
						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						echo "<h3>";
						echo $row['category_name'];
						echo "</h3>";
						echo "<ul>";
						echo "<li><a href=\"view-wiki-page.php?title=" . $row['title'] . "\">" . $row['title'] . "</a></li>";
						echo "</ul>";

					} catch (PDOException $e) {
						echo "Error: " . $e->getMessage() . "<br/>";
						die();
					}

				?>
		</article>
		<aside class="nav-aside">
			<ul>
				<li>
					<a class="current" href="">Wiki Home</a>
				</li>
				<li>
					<a href="view-wiki-category.php?category=People">People</a>
				</li>
				<li>
					<a href="view-wiki-category.php?category=Places">Places</a>
				</li>
				<li>
					<a href="view-wiki-category.php?category=Events">Events</a>
				</li>
				<li>
					<a href="view-wiki-category.php?category=Miscellaneous">Miscellaneous</a>
				</li>
				<li>
					<a href="create-wiki-page.php">Create New Wiki Page</a>
				</li>
			</ul>
		</aside>	
	</body>
</html>