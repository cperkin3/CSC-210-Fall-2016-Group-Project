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

conn = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
cursor = conn.cursor()

# Get Cookie Username
cook_str = os.environ.get('HTTP_COOKIE')
cookie = Cookie.SimpleCookie(cook_str)
user = cookie['logged_in'].value

core_html = '''<html>
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
	query = "SELECT * FROM Forum_Threads WHERE user_created_by = %s"
	cursor.execute(query, (user, ))
	row = cursor.fetchone()
	while row is not None:
		query = "UPDATE Forum_Threads SET user_created_by = '[deleted]' WHERE id=%s"
		conn_local = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
		cursor_local = conn_local.cursor()
		cursor_local.execute(query, (row[0], ))
		conn_local.commit()
		conn_local.close()
		row = cursor.fetchone()

	query = "SELECT * FROM Forum_Posts WHERE user_post_by = %s"
	cursor.execute(query, (user, ))
	row = cursor.fetchone()
	while row is not None:
		query = "UPDATE Forum_Posts SET user_post_by = '[deleted]' WHERE id=%s"
		conn_local = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
		cursor_local = conn_local.cursor()
		cursor_local.execute(query, (row[0], ))
		conn_local.commit()
		conn_local.close()
		row = cursor.fetchone()
		
	query = "SELECT * FROM Wiki_Pages WHERE user_last_edited_by = %s"
	cursor.execute(query, (user, ))
	row = cursor.fetchone()
	while row is not None:
		query = "UPDATE Wiki_Pages SET user_last_edited_by = '[deleted]' WHERE title=%s"
		conn_local = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
		cursor_local = conn_local.cursor()
		cursor_local.execute(query, (row[0], ))
		conn_local.commit()
		conn_local.close()
		row = cursor.fetchone()

	query = "DELETE FROM Users WHERE username=%s"
	cursor.execute(query, (user, ))

	conn.commit()

	print 'Content-Type: text/html'
	print 'Set-Cookie: logged_in=null; path=/; expires=Sun, 09 Oct 2016 00:00:00 GMT'
	print
	print core_html
	print '''
		<article>
			<p>You have successfully deleted your account</p>
		</article>
	  </body>
	</html>
	'''
except: 
	conn.rollback()
		
	print 'Content-Type: text/html'
	print 
	print core_html
	print sys.exc_info()[0]
	print '''
		<article>
			<p>I'm sorry, there was an error </p>
		</article>
	  </body>
	</html>
	'''

conn.close()