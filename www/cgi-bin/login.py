#!C:\Python27\python.exe

import cgi
import cgitb
import mysql.connector

cgitb.enable()

print 'Content-type: text/html'
print

form = cgi.FieldStorage()

username = form["username"].value
password = form["password"].value

conn = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')	#This is probably a garbage line
cursor = conn.cursor()

query = 'SELECT * FROM User WHERE username=%s AND password=%s'

cursor.execute(query, (username, password))

if True :#TODO : find how to determine if cursor contains a row	
	# TODO somehow log them in
	# use a cookie?
	# Then bring them to a dummy "You have been logged in!" page
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
					<form method="POST" action="../cgi-bin/login.py"">
						Login: 
						Username: <input type="text" name="username" required/> 
						Password: <input type="text" name="password" required/>TODO: Script
						<input type="submit" value="Log in!"/>
					</form>
					<a href="../html-pages/create-account.html">Create Account</a>
				</div>
			</header>
			<nav><!-- All Top-level .html files should have exactly the same header contents -->
				<ul>
					<li>
						<a class="current" href="../index.html">Home</a>
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
				<h1>Congratulations, {}, you have successfully logged in</h1>
			</article>
			<aside>
			
			</aside>
			<footer>
			
			</footer>
			
		</body>
	</html>'''.format(username)
else :
	# Bring them to a dummy "Username and/or password incorrect" page
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
					<form method="POST" action="../cgi-bin/login.py"">
						Login: 
						Username: <input type="text" name="username" required/> 
						Password: <input type="text" name="password" required/>TODO: Script
						<input type="submit" value="Log in!"/>
					</form>
					<a href="../html-pages/create-account.html">Create Account</a>
				</div>
			</header>
			<nav><!-- All Top-level .html files should have exactly the same header contents -->
				<ul>
					<li>
						<a class="current" href="../index.html">Home</a>
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
				<h1>Incorrect username or password</h1>
				<form method="POST" action="../cgi-bin/login.py"">
						Username: <input type="text" name="username" required/> <br>
						Password: <input type="text" name="password" required/>
				</form>
			</article>
			<aside>
			
			</aside>
			<footer>
			
			</footer>
			
		</body>
	</html>'''