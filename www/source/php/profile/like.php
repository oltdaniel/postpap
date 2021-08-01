<?php
//Setup Imports
require("../main.php");

if(!empty($_POST['item_id'])) {
	mysql_query("UPDATE posts SET likes=likes+1 WHERE id='".$_POST['item_id']."'");
	mysql_query("INSERT INTO posts_likes(user,post_id) VALUES ('".$_SESSION['u']['id']."','".$_POST['item_id']."')");
	$row = mysql_fetch_assoc(mysql_query("SELECT likes FROM posts WHERE id='".$_POST['item_id']."'"));
	echo $row['likes'];
}
?>