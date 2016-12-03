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
					<a href="wiki.php">Wiki Home</a>
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
							echo "<div id='Subsections'>";

							// Parse through html content and display each subsection
							$content = $row['content'];
							$html = str_get_html($content);
							$x = 0;

							// Get each subsection
							foreach ($html->find('div[class=subsection]')  as $subsections) {
								// Subsection title
								foreach($subsections->find('h3') as $h3) {
									//echo "<div name='subt_" . $x . "'>";
									//echo $h3->innertext;
									//echo "</div>";

									echo "<div>Subsection Title: </div>"
									echo "<input type='text' name='subt_" . $x . "'>";
								}

								// Subsection content
								foreach($subsections->find('div') as $subsection_content) {
									echo "<textarea cols='40' rows='5' name='subc_" . $x . "'>";
									echo $subsection_content->innertext;
									echo "</textarea>";
								}

								$x++;
							}

							echo "</div>";
						}

						echo "<br><br>";

						echo "<input type='hidden' name='title' value='$title'>";

					} catch (PDOException $e) {
						echo "Error: " . $e->getMessage() . "<br/>";
						die();
					}
				?>
				<button onclick="addSubsection()" type="button">Add Subsection</button><br>
				<input type="submit" value="Submit"/>
			</form>
		</article>
		<script type="text/javascript" language="javascript">
			var x = <?php echo $x; ?>;
			function addSubsection() {
				var home = document.getElementById('Subsections');
				var subtitle_label = document.createElement('div');
				subtitle_label.innerHTML = "Subsection Title: ";
				home.append(subtitle_label);
				var subtitle_input = document.createElement('input');
				subtitle_input.setAttribute("type","text");
				subtitle_input.setAttribute("name","subt_" + x.toString());
				home.appendChild(subtitle_input);
				home.appendChild(document.createElement('br'));
				var subcontent_label = document.createElement('div');
				subcontent_label.innerHTML = "Subsection Content: ";
				home.append(subcontent_label);
				var subcontent_input = document.createElement('textarea');
				subcontent_input.setAttribute("cols","40");
				subcontent_input.setAttribute("rows","5");
				subcontent_input.setAttribute("name", "subc_" + x.toString());
				x++;
				home.appendChild(subcontent_input);
				home.appendChild(document.createElement('br'));
			}
		</script>
	</body>
</html>