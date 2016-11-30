#!C:\Python27\python.exe
#!/usr/bin/env python

import cgitb
import cgi
import Cookie
import os
import mysql.connector
import sys

cgitb.enable()

new_account = cgi.FieldStorage()

print 'Content-Type: text/html'
print
print '''<html>
  <head>
    <title>[final site name]</title>
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
					<form method="POST" action="logout.py">
						<input type="submit" value="Log out"/>
					</form>
				</div>
				<div id="logged-out">
					<form method="POST" action="login.py">
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
    <nav>
		<ul>
			<li>
				<a href="../index.php">Home</a>
			</li>
			<li>
				<a href="../forum/forum.php">Forum</a>
			</li>	
			<li>
				<a href="../wiki/wiki.php">Wiki</a>
			</li>
			<li>
				<a href="../about.php">About</a>
			</li>
			<li>
				<a href="../user-account.php">User Account</a>
			</li>
		</ul>
	</nav>
	<BR><BR><BR><BR><BR>
'''

conn = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
cursor = conn.cursor()

if not 'search-bar' in new_account:
	print '''<p>Error: No search text given.</p>
		</body>
	</html>
	'''
	sys.exit(0)

search_criteria = new_account['search-bar']

query = "SELECT * FROM Wiki_Pages WHERE 'category_name' LIKE ''"


