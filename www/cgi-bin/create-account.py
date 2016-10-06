#!/usr/bin/python

import cgitb
import cgi
import re
import sys

cgitb.enable()

new_account = cgi.FieldStorage()

# Header, Blank Line, Head Print here in case of error later
print 'Content-Type: text/html'
print
print '''<html>
  <head>
    <title>[final site name]</title>
	<link rel="stylesheet" type="text/css" href="../css/nav-bar.css">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
  </head>
  <body>
'''

# Grab Entered Data
username = new_account['username'].value
password = new_account['password'].value
email = new_account['email'].value
birthday = new_account['birthday'].value

# Data Validation
error_stirng = ""
if username = "":
	error_string += "Error: Username must be filled out.\n"
# elif
	# Check if username is already used - if so, tell username

if password = "":
	error_string += "Error: Password must be filled out.\n"

email_pattern = re.compile(r"[^@]+@[^@]+\.[^@]+")
if email = "":
	error_string += "Error: Email must be filled out.\n"
elif not email_pattern.match(email):
	error_string += "Error: Invalid email. Email must contain @ and .\n"

# validate date - make sure not empty and no one under 13 can create an account

# If any data invalid, print error and quit program
if error_string != "":
	print error_string
	print '''
	  </body>
	</html>
	'''
	sys.exit(0)

# Need to find mySQL equivalent and replace the following commands
#conn = sqlite3.connect('pizza_orders.db')
#c = conn.cursor()
#
#c.execute('insert into pizza_orders values (?,?,?,?,?,?)', (name, size, crust, str(toppings), phone, ccn))
#
#conn.commit()
#conn.close()



#TODO: Print out html body
print birthday

print '''
  </body>
</html>

'''