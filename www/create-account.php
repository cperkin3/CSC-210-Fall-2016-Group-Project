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
		<nav><!-- All Top-level .html files should have exactly the same header contents -->
			<ul>
				<li>
					<a href="index.php">Home</a>
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
			<BR><BR><BR><BR>
			<h1>Create Account</h1>
			Welcome to the site!
			<br>
			To create an account, please enter the following information and click 'Join!'.
			<br>
			<form method="post" action="../cgi-bin/create-account.py">
				Username: <input type="text" name="username" required/><br/>
				Password: <input type="password" name="password" required/><br/>
				Email: <input type="text" name="email" required/><br/>
				Birthday: <input type="date" name="birthday" required/><br/>
				<input type="submit" value="Join!"/>
			</form>
		</article>
		<aside>
		
		</aside>
		<footer>
		
		</footer>
		
	</body>
</html>