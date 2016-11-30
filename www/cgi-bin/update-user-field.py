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

# Grab Entered Data
if 'email' in new_account:
	email = new_account['email'].value
	query = "UPDATE Users SET email=%s WHERE username=%s"
	cursor.execute(query, (email, user))
	conn.commit()
elif 'favorite_character' in new_account:
	favorite_character = new_account['favorite_character'].value
	query = "UPDATE Users SET favorite_character=%s WHERE username=%s"
	cursor.execute(query, (favorite_character, user))
	conn.commit()
elif 'profile_pic' in new_account:
	profile_pic = new_account['profile_pic'].value
	query = "UPDATE Users SET profile_pic=%s WHERE username=%s"
	cursor.execute(query, (profile_pic, user))
	conn.commit()
elif 'bio' in new_account:
	bio = new_account['bio'].value
	query = "UPDATE Users SET bio=%s WHERE username=%s"
	cursor.execute(query, (bio, user))
	conn.commit()

redirectURL = "../user-account.php"

print 'Content-Type: text/html'
print 'Location: ' + redirectURL
print