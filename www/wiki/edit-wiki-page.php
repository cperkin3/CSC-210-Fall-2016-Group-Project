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
		<aside class="nav-aside">
			<ul>
				<li>
					<a class="current" href="">Wiki Home</a>
				</li>
				<li>
					<a href="view-wiki-category.php?category=People">People</a>
				</li>
				<li>
					<a href="view_category.php?category=Places">Places</a>
				</li>
				<li>
					<a href="view_category.php?category=Events">Events</a>
				</li>
				<li>
					<a href="view_category.php?category=Miscellaneous">Miscellaneous</a>
				</li>
				<li>
					<a href="create-wiki-page.php">Create New Wiki Page</a>
				</li>
			</ul>
		</aside>
		<article class="forum">
			<h1>Edit Wiki Page</h1>
			<br>
			Make your edits, and then hit 'Submit'.
			<br>
			<br>
			<form method="post" action="../cgi-bin/edit-wiki-page.py">
				<?php
					include_once '../includes/simple_html_dom.php';

					$servername = "localhost";
					$username = "root";
					$password = "mysql";
					$dbname = "Thrones_Database";

					try {
						$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

						// Set the PDO error mode to exception
						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

						$title = $_POST['title'];

						$stmt = $conn->prepare("SELECT * FROM Wiki_Pages WHERE title = '$title';");
						$stmt->execute();

						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							echo "Category: " . $row['category_name'];
							echo "<br>";
							echo "Title: $title";
							echo "<br>";

							// Parse through html content and display each subsection
							$content = $row['content'];
							$html = str_get_html($content);

							// Get each subsection
							foreach ($html->find('div[class=subsection]')  as $subsections) {
								// Subsection title
								foreach($subsections->find('h3') as $h3) {
									echo $h3->outertext;
								}

								foreach($subsections->find('div') as $subsection_content) {
									echo "<input type='text' name='subsection_content' value='$subsection_content->innertext'>";
								}
							}
						}

						echo "<br><br>";

					} catch (PDOException $e) {
						echo "Error: " . $e->getMessage() . "<br/>";
						die();
					}
				?>
				<input type="submit" value="Submit"/>
			</form>
		</article>
	</body>
</html>