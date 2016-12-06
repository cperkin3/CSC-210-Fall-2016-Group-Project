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
					<a class="current" href="index.php">Home</a>
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
					<a href="user-account.php">User Account</a>
				</li>
			</ul>
		</nav>
		<article>
			<h1>THROOOOOOOOONES</h1>
			<p>This site is dedicated to the crossover between the show <i>Game of Thrones</i> and the book series <i>A Song of Ice and Fire</i>.</p>
			<p>There is a forum for asking and answering questions about character, events, and any other aspect of the crossover you want to discuss. Debate on the forum is encouraged!</p>
			<p>There is also a wiki, where pages should describe in some way a character, event, location, or other aspect with a focus towards the similarities and differences between how the show and the book handled the character, event, etc.</p>
			<p>Have any questions? Feel free to reach out to one of the site creators, found via the 'About' link.</p>
			<p>You'll have to create an account in order to post content, so that we can ensure maximum information is stored to verify the accuracy of our information.</p>
			<p>Also, if anyone learns the release date of <i>Winds of Winter</i>, please feel free to SPAM EVERY POST telling us the date. We want the release date that bad.</p>
		</article>
		<aside>
		
		</aside>
		<footer>
		
		</footer>
		
	</body>
</html>