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