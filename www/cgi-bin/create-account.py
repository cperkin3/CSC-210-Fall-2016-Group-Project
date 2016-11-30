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

# Error handling for this?
conn = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
cursor = conn.cursor()

# Grab Entered Data
username = new_account['username'].value
password = new_account['password'].value
email = new_account['email'].value
birthday = new_account['birthday'].value

# Data Validation
error_string = ""
if username == "":
	error_string += "Error: Username must be filled out.\n"
else:
	query = "SELECT COUNT(*) FROM Users WHERE username=%s"
	cursor.execute(query, (username,))
	row = cursor.fetchone()
	if row[0] == 1:
		print "I'm sorry, another user already has chosen username " + username + ". Please register again with a different username."
		print """
		  </body>
		</html>"""
		sys.exit(0)
	elif row[0] > 1:
		print """I'm sorry, an internal error occured.
		  </body>
		</html>"""
		sys.exit(0)

if password == "":
	error_string += "Error: Password must be filled out.\n"

email_pattern = re.compile(r"[^@]+@[^@]+\.[^@]+")
if email == "":
	error_string += "Error: Email must be filled out.\n"
elif not email_pattern.match(email):
	error_string += "Error: Invalid email. Email must contain @ and .\n"
else:
	query = "SELECT COUNT(*) FROM Users WHERE email=%s"
	cursor.execute(query, (email,))
	row = cursor.fetchone()
	if row[0] == 1:
		print "I'm sorry, an account already exists with the email " + email + ". Please register again with a different email."
		print """
		  </body>
		</html>"""
		sys.exit(0)
	elif row[0] > 1:
		print """I'm sorry, an internal error occured.
		  </body>
		</html>"""
		sys.exit(0)
		
# validate date - make sure not empty and no one under 13 can create an account

# If any data invalid, print error and quit program
if error_string != "":
	print error_string
	print '''
	  </body>
	</html>
	'''
	sys.exit(0)

current_time = datetime.datetime.now().date()
salt = str(current_time)

hasher = hashlib.md5()
hasher.update(password)
hasher.update(salt)
encrypted_password = hasher.hexdigest()

query = 'INSERT INTO Users (username, password, email, birthdate, join_date) VALUES (%s, %s, %s, %s, %s)'

try:
	cursor.execute(query, (username, encrypted_password, email, birthday, current_time))
	conn.commit()
except:
	conn.rollback()
	print """An Error Occured while executing MySQL. Try Re-submitting your information.
	  </body>
	</html>"""
	sys.exit(0)

conn.close()

print "<h1>Congratulations! You have successfully created your account with username " + username + "</h1>"
print '''
  </body>
</html>
'''