<?php
//Setup Imports
require("../main.php");

$a_tags = array('<b>','<i>','<u>','<s>');
$allowed_tags = "<a></a><br><br/><b></b><i></i><s></s><u></u>";

if(!empty($_POST['str']) && $_POST['str']!="" && $_POST['str']!=" " && $_POST['str']!="\n" && $_POST['str']!="  ") {
	$str = $_POST['str'];
	$c_str = strip_tags($str,$allowed_tags);
	$c_str = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $c_str);
	$c_str = clean_html($c_str,$a_tags);
	$c_str = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),"<br>",$c_str);
	mysql_query("INSERT INTO posts(user,content,img,t_date,t_time) VALUES ('".$_SESSION['u']['id']."','".$c_str."','','".date("m.d.y")."','".date("H:i")."')");
	header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
if(!empty($_POST['item_id'])) {
	mysql_query("DELETE FROM posts WHERE id='".$_POST['item_id']."'");
	mysql_query("DELETE FROM posts_likes WHERE post_id='".$_POST['item_id']."'");
}
?>