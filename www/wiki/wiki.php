<!doctype html>
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
		<header> 
			<div class="login-top">
				<div id="logged-in">
					<span id="welcome-name"></span>
					<form method="POST" action="../cgi-bin/logout.py">
						<input type="submit" value="Log out"/>
					</form>
				</div>
				<div id="logged-out">
					<form method="POST" action="../cgi-bin/login.py">
						Username: <input type="text" name="username" required/> 
						Password: <input type="password" name="password" required/>
						<input type="submit" value="Log in!"/>
					</form>
					<a href="create-account.php">Create Account</a>
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
					<a class="current" href="wiki.php">Wiki</a>
				</li>
				<li>
					<a href="../about.php">About</a>
				</li>
				<li>
					<a href="../user-account.php">User Account</a>
				</li>
			</ul>
		</nav>
		<article class="forum">
			<form method="post" action="../cgi-bin/search-wiki.py" id="wiki-search-bar">
				<input type="text" name="search-bar" id="wiki-search-text-entry" required/>
				<input type="submit" id="wiki-search-submit" value="SEARCH"/>
			</form>
			<h1>THROOOOOOOOONES Wiki Home</h1>
			<h1>Game of Thrones / A Song of Ice and Fire Wiki</h1>
			<hr> 
				<h2> Learn something random about Game of Thrones! <h2>
				<?php

				mysql_select_db(name of database);

				$wikis = "SELECT title AND content FROM Wiki_Pages ORDER BY RAND() LIMIT 1";

				$result = mysql_query($wikis);

				WHILE ($row = mysql_fetch_array($result)):
     			echo $row['title'] . " " . $row['content'];
				ENDWHILE; 
				//echo "$result";
				?>
			<hr>
				<h2> Longest wiki page <h2>  
			<?php
				$rowSQL = mysql_query( "SELECT MAX( ID ) AS max FROM Wiki_Pages;" );
				$row = mysql_fetch_array( $rowSQL );
		    	$largestNumber = $row['max'];
			?>	
			<hr> 
				<h2> Last Edited wiki by category <h2>
				
				<?php
					
					$result = mysql_query('SELECT title, content 
                         FROM Wiki_Pages 
                     ORDER BY title DESC 
                        LIMIT 1') or die('Invalid query: ' . mysql_error());

					//print values to screen
					while ($row = mysql_fetch_assoc($result)) {
						<ul>
							  <li>echo $row['title'];</li>
							  <li>echo $row['content'];</li>

						</ul>
					}
 					// Free the resources associated with the result set
					// This is done automatically at the end of the script
					mysql_free_result($result);

					?>
		</article>
		<aside class="nav-aside">
			<ul>
				<li>
					<a class="current" href="">Wiki Home</a>
				</li>
				<li>
					<a href="view-wiki-category.php?category=People">People</a>
				</li>
				<li>
					<a href="view-wiki-category.php?category=Places">Places</a>
				</li>
				<li>
					<a href="view-wiki-category.php?category=Events">Events</a>
				</li>
				<li>
					<a href="view-wiki-category.php?category=Miscellaneous">Miscellaneous</a>
				</li>
				<li>
					<a href="create-wiki-page.php">Create New Wiki Page</a>
				</li>
			</ul>
		</aside>	
	</body>
</html>