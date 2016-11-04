<!doctype html>
<html>
	<head>
		<title>CSC 210 Project</title>
		<link rel="stylesheet" type="text/css" href="../css/nav-bar.css">
		<link rel="stylesheet" type="text/css" href="../css/login-bar.css">	
		<link rel="stylesheet" type="text/css" href="../css/styles.css">
	</head>
	<body>
		<header> <!-- All Top-level .html files should have exactly the same header contents -->
			<div class="login-top">
			<!-- I want to make this depend on whether or not they have a 'logged in' cookie, but I don't know how -->
				<form method="POST" action="../cgi-bin/login.py">
					Username: <input type="text" name="username" required/> 
					Password: <input type="password" name="password" required/>
					<input type="submit" value="Log in!"/>
				</form>
				<form method="POST" action="../cgi-bin/logout.py">
					<input type="submit" value="Log out"/>
				</form>
				<a href="html-pages/create-thread.php">Create Thread</a>
			</div>
		</header>
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
			<h1>Create New Thread</h1>
			<br>
			To create a new thread, please enter the following information and click 'Create!'.
			<br>
			<form method="post" action="../cgi-bin/create-account.py">
				Category: <select name="category" required>
					<option value="Characters"/>
				</select>
				Title: <input type="text" name="title" required/><br/>
				Content: <input type="text" name="content" required/><br/>
				<input type="submit" value="Create!"/>
			</form>
		</article>
		<aside>
		
		</aside>
		<footer>
		
		</footer>
		
	</body>
</html>