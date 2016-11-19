<?php

session_start();



if ($post_type == "a") {
	$post_title = preg_replace('#[^A-za-z0-9 ?!.,]#i', '', $_POST['post_title']);	
	if ($post_title == "") { echo "The Topic Title is missing"; exit(); }
	if (strlen($post_title) < 10) { echo "Your Topic Title is less than 10 characters weenis"; exit(); }
	$sql = mysql_query("INSERT INTO Forum_Posts (user_post_by, post_author_id, created_datetime, type, category_name, id, title, content) 
     VALUES('$post_author','$member_id',now(),'a','$forum_section_title','$forum_section_id','$post_title','$post_body')") or die (mysql_error());
	$this_id = mysql_insert_id();
	//$sql = mysql_query("UPDATE forum_posts SET otid='$this_id' WHERE id='$this_id'"); 
	header("location: viewthread.php?id=$this_id"); 
    exit();
}
// Only if the post_type is "b" 
if ($post_type == "b") {
	$this_id = preg_replace('#[^0-9]#i', '', $_POST['id']);
	if ($this_id == "") { echo "The thread ID is missing"; exit(); }
	$sql = mysql_query("INSERT INTO forum_posts (user_post_by, id, otid, created_datetime, type, content) VALUES('$post_author','$member_id','$this_id',now(),'b','$post_body')") or die (mysql_error());
	$post_body = stripslashes($post_body);
	echo $post_body;

}
?>