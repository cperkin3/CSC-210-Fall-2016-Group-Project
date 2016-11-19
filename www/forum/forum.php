<!doctype html>
<html>
	<head>
		<title>CSC 210 Project</title>
		<?php include("includes/imports.html");?>
	</head>
	<body>
		<?php include("includes/header.html");?>
		<nav><!-- All Top-level .html files should have exactly the same header contents -->
			<ul>
				<li>
					<a href="index.php">Home</a>
				</li>
				<li>
					<a class="current" href="forum.php">Forum</a>
				</li>	
				<li>
					<a href="wiki.php">Wiki</a>
				</li>
				<li>
					<a href="about.php">About</a>
				</li>
				<li>
					<a href="user-account.php">User Account</a>
				</li>
			</ul>
		</nav>
		<aside class="nav-aside">
			<ul>
				<li>
					<a class="current" href="">Forum Home</a>
				</li>
				<li>
					<a href="forum/view_category.php?category=General">General</a>
				</li>
				<li>
					<a href="forum/view_category.php?category=Characters">Characters</a>
				</li>
				<li>
					<a href="forum/view_category.php?category=Differences">Differences</a>
				</li>
				<li>
					<a href="forum/view_category.php?category=Other">Other</a>
				</li>
				<li>
					<a href="create-thread.php">Create New Thread</a>
				</li>
			</ul>
		</aside>
		<article class="forum">
			<h1>[Site Title] Forum Home</h1>
			<p>Welcome to the forum! The goal of this forum is to allow users to post questions and theories, ideally which apply to both the books and the show or that deal with some form of interaction between the two.</p>
			<p>Users may create new threads and reply to existing threads, but may not create new topic areas. If a thread does not fit in any topic area, put it in 'other'. If you feel there is a major area missing, feel free to contact one of the site managers, found under the 'About' tab.</p>
		</article>
		
		<footer>
		
		</footer>
		
	</body>
</html>