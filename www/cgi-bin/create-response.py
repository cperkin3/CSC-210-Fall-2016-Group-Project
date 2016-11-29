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

new_post = cgi.FieldStorage()

print 'Content-type: text/html'
print

# If user not logged in, print error and quit program
if not cook_str:
	print "Sorry, you must be logged in to respond to a post.\n"

elif 'logged_in' in cook_str:
	cookie = Cookie.SimpleCookie(cook_str)

	# Error handling for this?
	conn = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
	cursor = conn.cursor()

	# Grab Entered Data
	thread_id = new_post['thread_id'].value
	response_body = new_post['content'].value

	current_time = datetime.datetime.now()
	user = cookie['logged_in'].value

	# Data Validation
	error = False

	if response_body == "":
		error = True

	# If any data invalid, print error and quit program
	if error:
		#print error_string
		#print '''
		#  </body>
		#</html>
		#'''
		sys.exit(0)
	
	post_query = 'INSERT INTO Forum_Posts (thread_id, content, user_post_by, created_datetime) VALUES (%s, %s, %s, %s)'

	try:
		# Insert post
		cursor.execute(post_query, (thread_id, response_body, user, current_time))

		conn.commit()
	except:
		conn.rollback()
		print "An Error Occured while executing MySQL. Try Re-submitting your information. INSERT"
		sys.exit(0)

	conn.close()

	#print "<h1>You have successfully created a new post.</h1>"

# If user not logged in, print error and quit program
else:
	print "Sorry, you must be logged in to respond to a thread.\n"
	
#print '''
#  </body>
#</html>
#'''