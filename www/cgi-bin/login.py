#!C:\Python27\python.exe

import cgi
import cgitb
import mysql.connector
import Cookie
import os

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

	query = 'SELECT COUNT(*) FROM User WHERE username=%s AND password=%s'

	cursor.execute(query, (username, password))

	row = cursor.fetchone()
	
	if row == 1 :
		header = 'Set-Cookie: logged_in=' + username + '; path=/'
		content += '<h1>Congratulations, ' + username + ', you have successfully logged in</h1>'
	else :
		content += '''<h1>Incorrect username or password</h1>
					<form method="POST" action="../cgi-bin/login.py"">
							Username: <input type="text" name="username" required/> <br>
							Password: <input type="password" name="password" required/> <br>
							<input type="submit" value="Log in!"/>
					</form>'''
elif 'logged_in' in cook_str :
	cookie = Cookie.SimpleCookie(cook_str)
	content += '<h1>You are already logged in, ' + cookie['logged_in'].value + '''!</h1>
					<form method="POST" action="../cgi-bin/logout.py"">
						<input type="submit" value="Log out"/>
					</form>'''
else :
	content = '''<h1>Somehow, you have a malformed cookie :</h1>
				<ul>'''
	for key in cookie :
		content += '<li>' + key + ':' + cookie[key].value + '</li>'
	content += '</ul>'

print header
print
print '''Content-type: text/html
Set-Cookie: logged_in={}; path=/

		<!doctype html>
		<html>
			<head>
				<title>CSC 210 Project</title>
				<link rel="stylesheet" type="text/css" href="../css/nav-bar.css">
				<link rel="stylesheet" type="text/css" href="../css/styles.css">
			</head>
			<body>
				<header> <!-- All Top-level .html files should have exactly the same header contents -->
					<div class="login-top">
						<form method="POST" action="../cgi-bin/login.py"">
							Login: 
							Username: <input type="text" name="username" required/> 
							Password: <input type="password" name="password" required/>
							<input type="submit" value="Log in!"/>
						</form>
						<form method="POST" action="../cgi-bin/logout.py"">
							<input type="submit" value="Log out"/>
						</form>
						<a href="../html-pages/create-account.html">Create Account</a>
					</div>
				</header>
				<nav><!-- All Top-level .html files should have exactly the same header contents -->
					<ul>
						<li>
							<a class="current" href="../index.html">Home</a>
						</li>
						<li>
							<a href="../forum.html">Forum</a>
						</li>	
						<li>
							<a href="../wiki.html">Wiki</a>
						</li>
						<li>
							<a href="../about.html">About</a>
						</li>
						<li>
							<a href="../user-account.html">User Account</a>
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