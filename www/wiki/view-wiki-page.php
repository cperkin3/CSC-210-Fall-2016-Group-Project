<?php
	
	// Connect to thrones database
	$servername = "localhost";
	$username = "root";
	$password = "mysql";
	$dbname = "Thrones_Database";
	
	$title = $_GET['title'];
	
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// Set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $conn->prepare("SELECT * FROM Wiki_Pages WHERE title = '$title'");
		$stmt->execute();
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$page_title = $row["title"];
		$page_category = $row["category_name"];
		$page_content = $row["content"];
		
		$last_editor = $row["user_last_edited_by"];
		$edited_datetime = $row["last_edited_datetime"];
		
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage() . "<br/>";
		die();
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>CSC 210 Project</title>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="../css/nav-bar.css">
		<link rel="stylesheet" type="text/css" href="../css/login-bar.css">
		<link rel="stylesheet" type="text/css" href="../css/styles.css">
		<link rel="stylesheet" type="text/css" href="../css/viewthread.css">
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
			
			<h2><?php echo $page_title ?></h2>
			<hr>
			<?php echo $page_content ?>
			<hr>
			This page is in category <a href="view-wiki-category.php?category=<?php echo $page_category ?>"><?php echo $page_category ?></a>
			<br>
			Page last edited by <?php echo $last_editor ?> at <?php echo $edited_datetime ?>
			<form method="POST" action="edit-wiki-page.php">
				<input type="hidden" name="title" value="<?php echo $page_title ?>">
				<input type="submit" value="Edit this page!"/>
			</form>
			
		</article>
	</body>

</html>