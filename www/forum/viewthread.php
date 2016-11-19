<?php

session_start();

#include_once "../scripts/connect_to_mysql.php"; // Connect to the database

// Connect to the class file for converting date_time to "Ago" format

include_once ("agoTimeFormat.php");

$myAgoObject = new convertToAgo; // Establish the object

//connect to thrones database
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "Thrones_Database";

$thread_id = preg_replace('#[^0-9]#i', '', $_GET['id']); 

try {
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	// Set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $conn->prepare("SELECT * FROM `Forum_Posts` WHERE thread_id=$thread_id ORDER BY created_datetime ASC");
	$stmt->execute();

	// Get original post with all replies in the thread
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$post_author = $row["user_post_by"];
		$date_time = $row["created_datetime"];
		$date_time = strftime("%b %d, %Y", strtotime($date_time));
		$thread_title = $row["title"];
		$post_content = $row["content"];

		echo "<a1> Post by: $post_author </a1>";
	}

} catch (PDOException $e) {
	echo "Error: " . $e->getMessage() . "<br/>";
	die();
}
?>

<?php 

// Now query any responses out of the database and place in a dynamic list
$all_responses = "";
$sql = mysql_query("SELECT * FROM Forum_Posts WHERE otid='$thread_id' AND type='b'");
$numRows = mysql_num_rows($sql);

if ($numRows < 1) {
	$all_responses = '<div id="none_yet_div">Nobody has responded to this yet, be the first to reply!.</div>';
} else {
    while($row = mysql_fetch_array($sql)){
	$reply_author = $row["user_post_by"];
	//$reply_author_id = $row["post_author_id"];
	$date_n_time = $row["created_datetime"];
	$convertedTime = ($myAgoObject -> convert_datetime($date_n_time));
    $whenReply = ($myAgoObject -> makeAgo($convertedTime));
	$reply_body = $row["content"];
	$all_responses .= '<div class="response_top_div">Re: ' . $thread_title . ' &nbsp; &nbsp; &bull; &nbsp; &nbsp; ' . $whenReply . ' 
	<a href="../profile.php?id=' . $reply_author_id . '">' . $reply_author . '</a> said:</div>
	<div class="response_div">' . $reply_body . '</div>';
   }
}

?>

<?php 

// Be sure the user session vars are all set in order to show them the "replyButton"
$replyButton = 'You must <a href="../login.py">Log In</a> to respond';

if (isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['email']) && isset($_SESSION['password'])) {
	$replyButton = '<input name="myBtn1" type="submit" value="Post a Response" style="font-size:16px; padding:12px;" onmousedown="javascript:toggleForm(\'reponse_form\');" />';
}

// Check the database to be sure that their ID, password, and email session variables all match in the database
$u_id = mysql_real_escape_string($_SESSION['id']);
$u_name = mysql_real_escape_string($_SESSION['username']);
$u_email = mysql_real_escape_string($_SESSION['email']);
$u_pass = mysql_real_escape_string($_SESSION['password']);
$sql = mysql_query("SELECT * FROM Users WHERE id='$u_id' AND username='$u_name' AND email='$u_email' AND password='$u_pass'");
$numRows = mysql_num_rows($sql);

if ($numRows < 1) {
	   $replyButton = 'You Must <a href="../login.py">Log In</a> to Respond';
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery-1.4.2.js" type="text/javascript"></script>
<title><?php echo $thread_title; ?></title>
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
	  var post_body = $("#content");
	 // var fs_id = $("#forum_section_id");
	  var fs_title = $("#category_name");
	  var u_id = $("#member_id");
	  var u_pass = $("#password");
	  var url = "parsepost.php";
      if (post_body.val() == "") {
           $("#formError").html('<font size="+2">Please type something</font>').show().fadeOut(3000);
      } else if (post_body.val().length < 2 ) { 
	         $("#formError").html('<font size="+2">Your post must be at least 2 characters long').show().fadeOut(3000);
      } else {
		$("#myBtn1").hide();
		$("#formProcessGif").show();
        $.post(url,{ post_type: "b", tid: thread_id.val(), post_body: post_body.val(), fsID: fs_id.val(), fsTitle: fs_title.val(), uid: u_id.val(), upass: u_pass.val() } , function(data) {
			   $("#none_yet_div").hide();
			   var MattDiv = document.getElementById('responses');
			   var ajaxdiv1 = document.createElement('div');
			   ajaxdiv1.setAttribute("class", "response_top_div");
			   ajaxdiv1.htmlContent = 'Re: <?php echo $thread_title ?>';
			   ajaxdiv1.innerHTML = 'Re: <?php echo $thread_title ?>';
			   MattDiv.appendChild(ajaxdiv1);
			   var ajaxdiv = document.createElement('div');
			   ajaxdiv.setAttribute("class", "response_div");
			   ajaxdiv.htmlContent = data;
			   ajaxdiv.innerHTML = data;
			   MattDiv.appendChild(ajaxdiv);
			   $('#reponse_form').slideUp("fast");
			   document.responseForm.post_body.value='';
			   $("#formProcessGif").hide();
			   $("#myBtn1").show();
         }); 
	  }
}

</script>

<style type="text/css">
.topic_div {
	background-color: white;
	border: solid black 1px;
	font: 14px black;
	padding:5px;
	margin-bottom: 7px;
}

.response_top_div {
	background-color: black;
	font-size:12px;
	color: white;
	padding:4px;
	border: solid black 1px;
}

.response_div {
	background-color: #FFF;
	font-size:12px;
	padding:7px;
	border: solid black 1px;
	margin-bottom:7px;
}

#none_yet_div {
	background-color: #white;
	font-size:14px;
	padding:16px;
	border: #black 1px solid;
	margin-bottom:6px;
	color: black;
}
</style>

</head>

<body>

<?php include_once(""); ?>

<table style="background-color: #F0F0F0; border:#069 1px solid; border-top:none;" width="900" border="0" align="center" cellpadding="12" cellspacing="0">

  <tr>

    <td width="731" valign="top" style="line-height:1.5em;">

    <div id=""><a href="">Web Intersect Home</a> &larr; <a href="">Forum Home</a> &larr; <a href="section.php?id=<?php echo $section_id; ?>"><?php echo $section_title; ?></a></div>

    <br />    

    <span class="topicTitles"><?php echo $thread_title; ?></span><br /><br />

    Topic Started By: <a href="../profile.php?id=<?php echo $post_author_id; ?>"><?php echo $post_author; ?></a>

    &nbsp; &nbsp; &nbsp; Created: <span class="topicCreationDate"><?php echo $date_time; ?></span>

    

    <div class="topic_div"><?php echo $post_body; ?></div>

<div id="responses"><?php echo $all_responses; ?></div>



<!-- START DIV that contains the form -->

<div id="reponse_form" style="display:none; background-color: #BAE1FE; border:#06C 1px solid; padding:16px;">

<form action="javascript:parseResponse();" name="responseForm" id="responseForm" method="post">

    Please type in your response here <?php echo $u_name; ?>:<br /><textarea name="post_body" id="post_body" cols="64" rows="12" style="width:98%;"></textarea>

    <div id="formError" style="display:none; padding:16px; color:#F00;"></div>

    <br /><br /><input name="myBtn1" id="myBtn1" type="submit" value="Submit Your Response" style="padding:6px;" /> <span id="formProcessGif" style="display:none;"><img src="../images/loading.gif" width="28" height="10" alt="Loading" vspace="2" hspace="48" /></span>

    or <a href="#" onclick="return false" onmousedown="javascript:toggleForm('reponse_form');">Cancel</a>

    <input name="thread_id" id="thread_id" type="hidden" value="<?php echo $thread_id; ?>" />

    <input name="forum_section_id" id="forum_section_id" type="hidden" value="<?php echo $section_id; ?>" />

    <input name="forum_section_title" id="category_name" type="hidden" value="<?php echo $section_title; ?>" />

    <input name="member_id" id="member_id" type="hidden" value="<?php echo $_SESSION['id']; ?>" />

    <input name="member_password" id="password" type="hidden" value="<?php echo $_SESSION['password']; ?>" />

</form>

</div>

<!-- END DIV that contains the form -->

<?php echo $replyButton; ?>

<br />
<br />
</td>
    <td width="189" valign="top"><div style=" width:160px; height:600px; background-color: #999; color: #CCC; padding:12px;"> <br />
      <br />
      <br />
      <h3>Ad Space or Whatever</h3>
    </div></td>
  </tr>
</table>

<?php include_once(""); ?>

</body>

</html>