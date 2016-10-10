#!C:\Python27\python.exe

import cgitb
import Cookie
import os

cgitb.enable()

print 'Content-type: text/html'
print 'Set-Cookie: logged_in=null; path=/; expires=Sun, 09 Oct 2016 00:00:00 GMT'
print
print '''<!doctype html>
<html>
	<head>
		<title>CSC 210 Project</title>
		<link rel="stylesheet" type="text/css" href="../css/nav-bar.css">
		<link rel="stylesheet" type="text/css" href="../css/styles.css">
	</head>
	<body>
		<header> <!-- All Top-level .html files should have exactly the same header contents -->
			<div class="login-top">
			<!-- I want to make this depend on whether or not they have a 'logged in' cookie, but I don't know how -->
				<form method="POST" action="../cgi-bin/login.py"">
					Login: 
					Username: <input type="text" name="username" required/> 
					Password: <input type="password" name="password" required/>
					<input type="submit" value="Log in!"/>
				</form>
				<form method="POST" action="../cgi-bin/logout.py"">
					<input type="submit" value="Log out"/>
				</form>
				<a href="html-pages/create-account.html">Create Account</a>
			</div>
		</header>
		<nav><!-- All Top-level .html files should have exactly the same header contents -->
			<ul>
				<li>
					<a href="../index.html">Home</a>
				</li>
				<li>
					<a href="../forum.html">Forum</a>
				</li>	
				<li>
					<a href="../wiki.html">Wiki</a>
				</li>
				<li>
					<a href="../about.html">About</a>
				</li>
				<li>
					<a href="../user-account.html">User Account</a>
				</li>
			</ul>
		</nav>
		<article>
			<br><br><br><br>
			<h1>You have been successfully logged out</h1>
		</article>
		<aside>
		
		</aside>
		<footer>
		
		</footer>
		
	</body>
</html>'''