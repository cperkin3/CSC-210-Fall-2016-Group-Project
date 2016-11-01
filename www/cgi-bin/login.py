#!C:\Python27\python.exe
#!/usr/bin/env python

import cgi
import cgitb
import mysql.connector
import Cookie
import os
import hashlib
import datetime

cgitb.enable()

cook_str = os.environ.get('HTTP_COOKIE')
print 'Content-type: text/html'
header = ''
content = ''
if not cook_str :
	form = cgi.FieldStorage()

	username = form["username"].value
	password = form["password"].value

	conn = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
	cursor = conn.cursor()
	
	query = 'SELECT COUNT(*) FROM Users WHERE username=%s;'

	cursor.execute(query, (username,))
	
	row = cursor.fetchone()
	
	if row[0] == 1 :
		
		query = 'SELECT join_date FROM Users WHERE username=%s'
		cursor.execute(query, (username,))
		
		row = cursor.fetchone()
		for key in row :
			salt = str(key)
		
		hasher = hashlib.md5()
		hasher.update(password)
		hasher.update(salt)
		encrypted_password = hasher.hexdigest()
		
		query = 'SELECT password FROM Users WHERE username=%s'
		cursor.execute(query, (username,))
		row = cursor.fetchone()
		
		for key in row :
			attempt_password = str(key)
		
		if attempt_password == encrypted_password :
			exp_date = (datetime.datetime.now().date() + datetime.timedelta(30))
			header = 'Set-Cookie: logged_in=' + username + '; path=/; expires='
			week_int = exp_date.isoweekday()
			if week_int == 1 :
				header += 'Mon'
			elif week_int == 2 :
				header += 'Tue'
			elif week_int == 3 :
				header += 'Wed'
			elif week_int == 4 :
				header += 'Thu'
			elif week_int == 5 :
				header += 'Fri'
			elif week_int == 6 :
				header += 'Sat'
			elif week_int == 7 :
				header += 'Sun'
			header += ', ' + str(exp_date.day) + ' '
			month_int = exp_date.month
			if month_int == 1 :
				header += 'Jan'
			elif month_int == 2 :
				header += 'Feb'
			elif month_int == 3 :
				header += 'Mar'
			elif month_int == 4 :
				header += 'Apr'
			elif month_int == 5 :
				header += 'May'
			elif month_int == 6 :
				header += 'Jun'
			elif month_int == 7 :
				header += 'Jul'
			elif month_int == 8 :
				header += 'Aug'
			elif month_int == 9 :
				header += 'Sep'
			elif month_int == 10 :
				header += 'Oct'
			elif month_int == 11 :
				header += 'Nov'
			elif month_int == 12 :
				header += 'Dec'
			header += ' ' + str(exp_date.year) + ' 00:00:00 GMT'
			content += '<h1>Congratulations, ' + username + ', you have successfully logged in</h1>'
		else :
			content += '''<h1>Incorrect password</h1>
					<form method="POST" action="../cgi-bin/login.py"">
							Username: <input type="text" name="username" required/> <br>
							Password: <input type="password" name="password" required/> <br>
							<input type="submit" value="Log in!"/>
					</form>'''
	else :
		content += '''<h1>Incorrect username</h1>
					<form method="POST" action="../cgi-bin/login.py"">
							Username: <input type="text" name="username" required/> <br>
							Password: <input type="password" name="password" required/> <br>
							<input type="submit" value="Log in!"/>
					</form>'''
#	cursor.close()
	conn.close()

elif 'logged_in' in cook_str :
	cookie = Cookie.SimpleCookie(cook_str)
	content += '<h1>You are already logged in, ' + cookie['logged_in'].value + '''!</h1>
					<form method="POST" action="../cgi-bin/logout.py"">
						<input type="submit" value="Log out"/>
					</form>'''
else :
	form = cgi.FieldStorage()

	username = form["username"].value
	password = form["password"].value

	conn = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
	cursor = conn.cursor()
	
	query = 'SELECT COUNT(*) FROM Users WHERE username=%s;'

	cursor.execute(query, (username,))
	
	row = cursor.fetchone()
	
	if row[0] == 1 :
		
		query = 'SELECT join_date FROM Users WHERE username=%s'
		cursor.execute(query, (username,))
		
		row = cursor.fetchone()
		for key in row :
			salt = str(key)
		
		hasher = hashlib.md5()
		hasher.update(password)
		hasher.update(salt)
		encrypted_password = hasher.hexdigest()
		
		query = 'SELECT password FROM Users WHERE username=%s'
		cursor.execute(query, (username,))
		row = cursor.fetchone()
		
		for key in row :
			attempt_password = str(key)
		
		if attempt_password == encrypted_password :
			header = 'Set-Cookie: logged_in=' + username + '; path=/'
			content += '<h1>Congratulations, ' + username + ', you have successfully logged in</h1>'
		else :
			content += '''<h1>Incorrect password</h1>
					<form method="POST" action="../cgi-bin/login.py"">
							Username: <input type="text" name="username" required/> <br>
							Password: <input type="password" name="password" required/> <br>
							<input type="submit" value="Log in!"/>
					</form>'''
	else :
		content += '''<h1>Incorrect username</h1>
					<form method="POST" action="../cgi-bin/login.py"">
							Username: <input type="text" name="username" required/> <br>
							Password: <input type="password" name="password" required/> <br>
							<input type="submit" value="Log in!"/>
					</form>'''
#	cursor.close()
	conn.close()

print header
print
print '''<!doctype html>
		<html>
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
				<header> <!-- All Top-level .html files should have exactly the same header contents -->
					<div class="login-top">
						<div id="logged-in">
							<span id="welcome-name"></span>
							<form method="POST" action="cgi-bin/logout.py">
								<input type="submit" value="Log out"/>
							</form>
						</div>
						<div id="logged-out">
							<form method="POST" action="cgi-bin/login.py">
								Username: <input type="text" name="username" required/> 
								Password: <input type="password" name="password" required/>
								<input type="submit" value="Log in!"/>
							</form>
							<a href="create-account.html">Create Account</a>
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
				<article>
					<br><br><br><br>'''
print content
print '''</article>
				<aside>
				
				</aside>
				<footer>
				
				</footer>
				
			</body>
		</html>'''