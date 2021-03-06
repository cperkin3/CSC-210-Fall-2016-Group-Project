<?php

	session_start();
	
	// Connect to thrones database
	$servername = "localhost";
	$username = "root";
	$password = "mysql";
	$dbname = "Thrones_Database";

	$thread_id = preg_replace('#[^0-9]#i', '', $_GET['id']); 

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// Set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Get thread title
		$stmt = $conn->prepare("SELECT title FROM Forum_Threads WHERE id = $thread_id");
		$stmt->execute();

		$thread_title = "";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$thread_title = $row["title"];
		}

		// Get original post with all replies in the thread
		$stmt = $conn->prepare("SELECT * FROM Forum_Posts WHERE thread_id = $thread_id ORDER BY created_datetime ASC");
		$stmt->execute();

		$responses = "";

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$post_author = $row["user_post_by"];
			$date_time = $row["created_datetime"];
			$post_content = $row["content"];
			$responses = $responses . '<div class="response_top_div">' . $date_time . ' &nbsp; &nbsp; &bull; &nbsp; &nbsp; ' . $post_author . ' said:</div>
			<div class="response_div">' . $post_content . '</div>';
		}

	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage() . "<br/>";
		die();
	}

	$replyButton = '<input name="myBtn1" type="submit" value="Post a Response" style="font-size:16px; padding:12px;" onmousedown="javascript:toggleForm(\'response_form\');" />';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>CSC 210 Project</title>
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../css/nav-bar.css">
	<link rel="stylesheet" type="text/css" href="../css/login-bar.css">
	<link rel="stylesheet" type="text/css" href="../css/styles.css">
	<link rel="stylesheet" type="text/css" href="../css/viewthread.css">
	<!-- JavaScript --> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="../js/header.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script language="javascript" type="text/javascript">

//jquery

function toggleForm(x) {
	if ($('#'+x).is(":hidden")) {
		$('#'+x).slideDown(200);1
	} else {
		$('#'+x).slideUp(200);
	}
}

//ajax

$('#responseForm').submit(function(){$('input[type=submit]', this).attr('disabled', 'disabled');});

function parseResponse ( ) {
	  var thread_id = $("#thread_id");
	  var post_body = $("#post_body");
	  var url = "../cgi-bin/create-response.py";

      if (post_body.val() == "") {
           $("#formError").html('<font size="+2">Please type something</font>').show().fadeOut(3000);
      } else {
		$("#myBtn1").hide();
		$("#formProcessGif").show();
		 
		 $.ajax({
			url: '../cgi-bin/create-response.py',

			data: {
				thread_id: thread_id.val(), 
				content: post_body.val()
			},

			type: "POST",

			dataType: "json",

			success: function( data ) {   // function to execute upon a successful request
				console.log(status);
				if (data.success == true) {
				   $("#none_yet_div").hide();
				   var MattDiv = document.getElementById('postz');
				   var ajaxdiv1 = document.createElement('div');
				   ajaxdiv1.setAttribute("class", "response_top_div");
				   ajaxdiv1.htmlContent = data.datetime + ' &nbsp; &nbsp; &bull; &nbsp; &nbsp; ' + data.author + ' said:';
				   ajaxdiv1.innerHTML = data.datetime + ' &nbsp; &nbsp; &bull; &nbsp; &nbsp; ' + data.author + ' said:';
				   MattDiv.appendChild(ajaxdiv1);
				   var ajaxdiv = document.createElement('div');
				   ajaxdiv.setAttribute("class", "response_div");
				   ajaxdiv.innerHTML = post_body.val();
				   MattDiv.appendChild(ajaxdiv);
				   $('#response_form').slideUp("fast");
				   document.responseForm.post_body.value='';
				   $("#formProcessGif").hide();
				   $("#myBtn1").show();
				}
				else {
					//TODO there was an error - display it
					alert("Problem!");
				}
			},

			error: function(request) {   // function to call when the request fails
				console.log(request.responseText);
			}
		});
	  }
}

</script>
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
				<a class="current" href="forum.php">Forum</a>
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

	<aside class="nav-aside">
			<ul>
				<li>
					<a href="forum.php">Forum Home</a>
				</li>
				<li>
					<a href="view_category.php?category=General">General</a>
				</li>
				<li>
					<a href="view_category.php?category=Characters">Characters</a>
				</li>
				<li>
					<a href="view_category.php?category=Differences">Differences</a>
				</li>
				<li>
					<a href="view_category.php?category=Other">Other</a>
				</li>
				<li>
					<a href="create-thread.php">Create New Thread</a>
				</li>
			</ul>
		</aside>
	<article class="forum">
	
<table style="background-color: #F0F0F0; border:#069 1px solid; border-top:none;" width="900" border="0" align="center" cellpadding="12" cellspacing="0">

  <tr>
    <td width="731" valign="top" style="line-height:1.5em;">
    <br />
    <span class="topicTitles"><b><?php echo $thread_title; ?></b></span><br /><br />
    Topic Started By: <a echo $post_author_id; ?><?php echo $post_author; ?></a>
    &nbsp; &nbsp; &nbsp; Created: <span class="topicCreationDate"><?php echo $date_time; ?></span>

<div id="postz"><?php echo $responses; ?></div>

<!-- START DIV that contains the form -->

<div id="response_form" style="display:none; background-color: #BAE1FE; border:#06C 1px solid; padding:16px;">

<form action="javascript:parseResponse();" name="responseForm" id="responseForm" method="post">

    Please type in your response here <?php echo $u_name; ?>:<br /><textarea name="post_body" id="post_body" cols="64" rows="12" style="width:98%;"></textarea>

    <div id="formError" style="display:none; padding:16px; color:#F00;"></div>

    <br /><br /><input name="myBtn1" id="myBtn1" type="submit" value="Submit Your Response" style="padding:6px;" /> <span id="formProcessGif" style="display:none;"><img src="../images/loading.gif" width="28" height="10" alt="Loading" vspace="2" hspace="48" /></span>

    or <a href="#" onclick="return false" onmousedown="javascript:toggleForm('response_form');">Cancel</a>

    <input name="thread_id" id="thread_id" type="hidden" value="<?php echo $_GET['id']; ?>" />

    <input name="forum_section_id" id="forum_section_id" type="hidden" value="<?php echo $section_id; ?>" />

    <input name="forum_section_title" id="category_name" type="hidden" value="<?php echo $section_title; ?>" />

    <input name="member_id" id="member_id" type="hidden" value="<?php echo $_SESSION['id']; ?>" />

    <input name="member_password" id="password" type="hidden" value="<?php echo $_SESSION['password']; ?>" />

</form>

</div>

<!-- END DIV that contains the form -->

<?php echo $replyButton; ?>

</td>
</tr>
</table>
</article>
</body>

</html>