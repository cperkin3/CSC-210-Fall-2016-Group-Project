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

edit_page = cgi.FieldStorage()

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
				<a href="../forum/forum.php">Forum</a>
			</li>	
			<li>
				<a class="current" href="../wiki/wiki.php">Wiki</a>
			</li>
			<li>
				<a href="../about.php">About</a>
			</li>
			<li>
				<a href="../user-account.php">User Account</a>
			</li>
		</ul>
	</nav>
	<aside class="nav-aside">
			<ul>
				<li>
					<a href="../wiki/wiki.php">Wiki Home</a>
				</li>
				<li>
					<a href="../wiki/view-wiki-category.php?category=People">People</a>
				</li>
				<li>
					<a href="../wiki/view-wiki-category.php?category=Places">Places</a>
				</li>
				<li>
					<a href="../wiki/view-wiki-category.php?category=Events">Events</a>
				</li>
				<li>
					<a href="../wiki/view-wiki-category.php?category=Miscellaneous">Miscellaneous</a>
				</li>
				<li>
					<a href="../wiki/create-wiki-page.php">Create New Wiki Page</a>
				</li>
			</ul>
		</aside>	
	<BR><BR><BR><BR><BR>
'''

# If user not logged in, print error and quit program
if not cook_str:
	print "Sorry, you must be logged in to edit a page.\n"

elif 'logged_in' in cook_str:
	cookie = Cookie.SimpleCookie(cook_str)

	# Error handling for this?
	conn = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
	cursor = conn.cursor()

	# Grab Entered Data
	title = edit_page['title'].value
	content = ""
	for key in sorted(edit_page.keys()):
		print key
		if re.match("subt_\d+", key) != None:
			print "found something"
			x = re.search("\d+",key)
			content += "<div class=\"subsection\">"
			content += "<h3>"
			content += edit_page[key].value
			content += "</h3><div>"
			content += edit_page["subc_"+x.group()].value
			content += "</div></div>"
		else:
			pass

	user = cookie['logged_in'].value

	# Data Validation
	error_string = ""

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

	print content
	print ""
	print user
	print ""
	print current_time
	print ""

	query = "UPDATE Wiki_Pages SET content = %s, user_last_edited_by = %s, last_edited_datetime = %s WHERE title = " + "'" + title + "';";

	print query
	print ""

	try:
		# Update page
		cursor.execute(query, (content, user, current_time))

		conn.commit()
	except:
		conn.rollback()
		print """An Error Occured while executing MySQL.
		  </body>
		</html>"""
		sys.exit(0)

	conn.close()

	print "<h1>You have successfully edited a wiki page.</h1>"
	print "View it <a href=\"../wiki/view-wiki-page.php?title=" + title + "\">here</a>"

# If user not logged in, print error and quit program
else:
	print "Sorry, you must be logged in to edit a page.\n"
	
print '''
  </body>
</html>
'''