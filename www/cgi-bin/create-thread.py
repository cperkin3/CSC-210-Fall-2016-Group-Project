#!C:\Python27\python.exe
#!/usr/bin/env python

import cgitb
import cgi
import re
import sys
import mysql.connector
import datetime 
import time
import hashlib
import Cookie
import os

cgitb.enable()

cook_str = os.environ.get('HTTP_COOKIE')

new_thread = cgi.FieldStorage()

print 'Content-Type: text/html'
print
print '''<html>
  <head>
    <title>CSC 210 Project</title>
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
    <nav><!-- All Top-level .html files should have exactly the same header contents -->
		<ul>
			<li>
				<a href="../index.php">Home</a>
			</li>
			<li>
				<a class="current" href="../forum/forum.php">Forum</a>
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
	<BR><BR><BR><BR><BR>
'''

# If user not logged in, print error and quit program
if not cook_str:
	print "Sorry, you must be logged in to create a new thread.\n"

elif 'logged_in' in cook_str:
	cookie = Cookie.SimpleCookie(cook_str)

	# Error handling for this?
	conn = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
	cursor = conn.cursor()

	# Grab Entered Data
	category = new_thread['category'].value
	title = new_thread['title'].value
	content = new_thread['content'].value

	user = cookie['logged_in'].value
	thread_id = 0

	# Data Validation
	error_string = ""
	if title == "":
		error_string += "Error: Title must be filled out.\n"

	if len(title) > 100:
		error_string += "Error: Title must be 100 characters or less.\n"

	if content == "":
		error_string += "Error: Content must be filled out.\n"

	# If any data invalid, print error and quit program
	if error_string != "":
		print error_string
		print '''
		  </body>
		</html>
		'''
		sys.exit(0)

	current_time = datetime.datetime.now()

	thread_query = 'INSERT INTO Forum_Threads (category_name, title, user_created_by, created_datetime) VALUES (%s, %s, %s, %s)'
	post_query = 'INSERT INTO Forum_Posts (thread_id, content, user_post_by, created_datetime) VALUES (%s, %s, %s, %s)'

	try:
		# Insert thread
		cursor.execute(thread_query, (category, title, user, current_time))
		
		# Get inserted thread id
		cursor.execute('SELECT LAST_INSERT_ID()')
		row = cursor.fetchone()
		thread_id = row[0]

		# Insert post
		cursor.execute(post_query, (thread_id, content, user, current_time))

		conn.commit()
	except:
		conn.rollback()
		print """An Error Occured while executing MySQL. Try Re-submitting your information. INSERT
		  </body>
		</html>"""
		sys.exit(0)

	conn.close()

	print "<h1>You have successfully created a new thread.</h1>"

# If user not logged in, print error and quit program
else:
	print "Sorry, you must be logged in to create a new thread.\n"
	
print '''
  </body>
</html>
'''