<?php
	$servername = "localhost";
	$username = "root";
	$password = "mysql";
	$dbname = "Thrones_Database";

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

		// Set the PDO error mode to exception
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$thread_id = $_POST['thread_id']; 
		$response_body = $_POST['content'];
		$response_body = nl2br(htmlspecialchars($response_body));
		$response_body = mysql_real_escape_string($response_body);
		$response_author = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION['user_id']);
		$post_title = $_POST['post_title'];
		$current_time = time();

		$stmt = $conn->prepare("INSERT INTO Forum_Posts (thread_id, content, user_post_by, created_datetime) VALUES ($thread_id, $response_body, $response_author, $current_time)");
		$stmt->execute();

	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage() . "<br/>";
		die();
	}
?>

<?php
/*
session_start();

$thread_id = $_POST['thread_id']; 
$response_body = $_POST['content'];
$response_body = nl2br(htmlspecialchars($response_body));
$response_body = mysql_real_escape_string($response_body);
////$forum_section_title = preg_replace('#[^A-Za-z 0-9]#i', '', $_POST['fsTitle']); 
//$member_id = preg_replace('#[^0-9]#i', '', $_POST['uid']); 
$response_author = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION['member_id']);
$post_title = $_POST['post_title'];
$current_time = time();

$sql = mysql_query("INSERT INTO Forum_Posts (thread_id, content, user_post_by, created_datetime) VALUES ($thread_id, $response_body, $response_author, $current_time)");

if ($post_type == "a") {

	$post_title = preg_replace('#[^A-za-z0-9 ?!.,]#i', '', $_POST['post_title']);	

	if ($post_title == "") { echo "The Topic Title is missing"; exit(); }

	if (strlen($post_title) < 10) { echo "Your Topic Title is less than 10 characters"; exit(); }

	$sql = mysql_query("INSERT INTO Forum_Posts (user_post_by, created_datetime, id, title, content) 

     VALUES('$post_author','$member_id',now(),'a','$forum_section_title','$forum_section_id','$post_title','$post_body')") or die (mysql_error());

	$this_id = mysql_insert_id();

	//$sql = mysql_query("UPDATE forum_posts SET otid='$this_id' WHERE id='$this_id'"); 

	header("location: viewthread.php?id=$this_id"); 

    exit();

}

// Only if the post_type is "b" 

if ($content != nil) {

	$this_id = preg_replace('#[^0-9]#i', '', $_POST['id']);

	if ($this_id == "") { echo "The thread ID is missing"; exit(); }

	$sql = mysql_query("INSERT INTO forum_posts (user_post_by, id, otid, created_datetime, type, content) VALUES('$post_author','$member_id','$this_id',now(),'b','$post_body')") or die (mysql_error());

	$post_body = stripslashes($post_body);

	echo $post_body;



}*/
?>