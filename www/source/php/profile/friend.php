<?php
//Setup Imports
require("../main.php");
//Friend Functions
function isFriend($with_id) {
  $query = $pdo->prepare("SELECT * FROM friends WHERE user1='".$_SESSION['u']['id']."' AND user2='".$with_id."' AND status=2 OR user1='".$with_id."' AND user2='".$_SESSION['u']['id']."' AND status=2");
  $query->execute();
  if(!$query->rowCount() == 0) {
    return true;
  } else {
    return false;
  }
}
function blockUser($with_id) {
  mysql_query("DELETE FROM friends WHERE user1='".$_SESSION['u']['id']."' AND user2='".$with_id."' OR user1='".$with_id."' AND user2='".$_SESSION['u']['id']."'");
  mysql_query("INSERT INTO friends(user1,user2,status,t_time) VALUES('".$_SESSION['u']['id']."','".$with_id."','3','".time()."')");
}
function addFriend($with_id) {
  mysql_query("INSERT INTO friends(user1,user2,status,t_time) VALUES('".$_SESSION['u']['id']."','".$with_id."','1','".time()."')");
}
function acceptFriend($with_id) {
  mysql_query("UPDATE friends SET status='2' WHERE user1='".$_SESSION['u']['id']."' AND user2='".$with_id."' OR user1='".$with_id."' AND user2='".$_SESSION['u']['id']."'");
}
function removeFriend($with_id) {
  mysql_query("DELETE FROM friends WHERE user1='".$_SESSION['u']['id']."' AND user2='".$with_id."' OR user1='".$with_id."' AND user2='".$_SESSION['u']['id']."'");
}
//If GET requested
if(!empty($_GET['add'])) {
	addFriend($_GET['add']);
} else if(!empty($_GET['remove'])) {
	removeFriend($_GET['remove']);
} else if(!empty($_GET['block'])) {
	blockUser($_GET['block']);
} else if(!empty($_GET['accept'])) {
	acceptFriend($_GET['accept']);
}
header("Location: ".$_SERVER['HTTP_REFERER']);
?>