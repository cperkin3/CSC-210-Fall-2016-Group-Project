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

print 'Content-Type: text/html'
print
print '''<html>
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
'''

conn = mysql.connector.connect(user='root', password='mysql', database='Thrones_Database')
cursor = conn.cursor()

if not 'search-bar' in new_account:
	print '''<p>Error: No search text given.</p>
		</body>
	</html>
	'''
	sys.exit(0)

print '''<aside class="nav-aside">
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
		<article class="forum">
			<h2>Search Results for:'''

given_search = new_account["search-bar"].value
search_criteria = "%" + given_search + "%"

print given_search + "</h2>"

query1 = "SELECT * FROM Wiki_Pages WHERE title LIKE %s AND category_name='People'"
query2 = "SELECT * FROM Wiki_Pages WHERE title LIKE %s AND category_name='Places'"
query3 = "SELECT * FROM Wiki_Pages WHERE title LIKE %s AND category_name='Events'"
query4 = "SELECT * FROM Wiki_Pages WHERE title LIKE %s AND category_name='Miscellaneous'"

cursor.execute(query1, (search_criteria, ))
print "<h3>pages in People</h3>"
row = cursor.fetchone()
while row is not None:
	print "<p><a href='../wiki/view-wiki-page.php?title=" + row[0]+ "'>" + row[0] + "</a></p>"
	row = cursor.fetchone()
	
cursor.execute(query2, (search_criteria, ))
print "<h3>pages in Places</h3>"
row = cursor.fetchone()
while row is not None:
	print "<p><a href='../wiki/view-wiki-page.php?title=" + row[0]+ "'>" + row[0] + "</a></p>"
	row = cursor.fetchone()
	
cursor.execute(query3, (search_criteria, ))
print "<h3>pages in Events</h3>"
row = cursor.fetchone()
while row is not None:
	print "<p><a href='../wiki/view-wiki-page.php?title=" + row[0]+ "'>" + row[0] + "</a></p>"
	row = cursor.fetchone()

cursor.execute(query4, (search_criteria, ))
print "<h3>pages in Miscellaneous</h3>"
row = cursor.fetchone()
while row is not None:
	print "<p><a href='../wiki/view-wiki-page.php?title=" + row[0]+ "'>" + row[0] + "</a></p>"
	row = cursor.fetchone()
	
print '''</article>
	  </body>
	</html>'''