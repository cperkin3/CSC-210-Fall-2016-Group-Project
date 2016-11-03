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

cgitb.enable()

new_thread = cgi.FieldStorage()

print 'Content-Type: text/html'
print
print '''<html>
  <head>
    <title>[final site name]</title>
	<link rel="stylesheet" type="text/css" href="../css/nav-bar.css">
	<link rel="stylesheet" type="text/css" href="../css/login-bar.css">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
  </head>
  <body>
	<header> <!-- All Top-level .html files should have exactly the same header contents -->
		<div class="login-top">
		<!-- I want to make this depend on whether or not they have a 'logged in' cookie, but I don't know how -->
			<form method="POST" action="login.py">
				Login: 
				Username: <input type="text" name="username" required/> 
				Password: <input type="password" name="password" required/>TODO: Script
				<input type="submit" value="Log in!"/>
			</form>
			<form method="POST" action="logout.py">
					<input type="submit" value="Log out"/>
				</form>
			<a href="../create-thread.php">Create Thread</a>
		</div>
	</header>
    <nav><!-- All Top-level .html files should have exactly the same header contents -->
		<ul>
			<li>
				<a class="current" href="../index.php">Home</a>
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
	<BR><BR><BR><BR><BR>
'''

# Error handling for this?
conn = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
cursor = conn.cursor()

# Grab Entered Data
category = new_thread['category'].value
title = new_thread['title'].value
user = new_thread['user'].value
content = new_thread['content'].value
thread_id = 0

# Data Validation
error_string = ""
if title == "":
	error_string += "Error: Title must be filled out.\n"

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

current_time = datetime.datetime.now().date()

thread_query = 'INSERT INTO Forum_Threads (category_name, title, user_created_by, created_datetime) VALUES (%s, %s, %s, %s)'
post_query = 'INSERT INTO Forum_Posts (thread_id, content, user_post_by, created_datetime) VALUES (%s, %s, %s, %s)'

# Insert Thread
try:
	cursor.execute(thread_query, (category, title, user, current_time))
	conn.commit()
except:
	conn.rollback()
	print """An Error Occured while executing MySQL. Try Re-submitting your information.
	  </body>
	</html>"""
	sys.exit(0)

# Get inserted thread id
query = 'SELECT id FROM Forum_Threads WHERE title = ' + title + ' AND created_datetime = ' + current_time

try:
	cursor.execute(query)
except:
	print """An Error Occured while executing MySQL. Try Re-submitting your information.
	  </body>
	</html>"""
	sys.exit(0)

data = cursor.fetchall()
# need to check to make sure only one row
for row in data :
	thread_id = row[0]

# Insert Post
try:
	cursor.execute(post_query, (thread_id, content, user, current_time))
	conn.commit()
except:
	conn.rollback()
	print """An Error Occured while executing MySQL. Try Re-submitting your information.
	  </body>
	</html>"""
	sys.exit(0)

conn.close()

print "<h1>You have successfully created a new thread.</h1>"
print '''
  </body>
</html>
'''