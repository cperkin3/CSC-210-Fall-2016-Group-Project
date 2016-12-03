#!C:\Python27\python.exe
#!/usr/bin/env python

import cgitb
import cgi
import Cookie
import os
import mysql.connector

cgitb.enable()

new_account = cgi.FieldStorage()

conn = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
cursor = conn.cursor()

# Get Cookie Username
cook_str = os.environ.get('HTTP_COOKIE')
cookie = Cookie.SimpleCookie(cook_str)
user = cookie['logged_in'].value

print 'Content-Type: text/html'
print
print '''<html>
  <head>
    <title>CSC 210 Group Project</title>
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
'''

try:

	 
	query = "SELECT * FROM Forum_Posts WHERE user_post_by = %s"
	cursor.execute(query, (user, ))
	row = cursor.fetchone()
	while row is not None:
		query = "UPDATE Forum_Posts SET user_post_by = '[deleted]' WHERE id = %s"
		cursor.execute(query, (row[0], ))
		row = cursor.fetchone()
		
	query = "SELECT * FROM Forum_Threads WHERE user_created_by = %s"
	cursor.execute(query, (user, ))
	row = cursor.fetchone()
	
	
		
	
	
	
	query = "UPDATE Forum_Threads SET "
	
	
	query = "UPDATE Wiki_Pages SET "
	
	
	
	conn.commit()
except: 
	conn.rollback()
	print '''
		<article>
			<p>I'm sorry, there was an error </p>
		</article>
	  </body>
	</html>
	'''

conn.close()





