<?php
//Setup Imports
require("../r.php");
require($r."/source/php/main.php");
if(!empty($_GET['c'])) {
	$rows = mysql_num_rows(mysql_query("SELECT activation_str FROM users WHERE activation_str='".$_GET['c']."'"));
	if($rows == 1) {
		mysql_query("UPDATE users SET activated=1 WHERE activation_str='".$_GET['c']."'") or die("MYSQL ERROR");
		$_SESSION['success'] = "<div class='alert alert-success' role='alert'><center><b>".$t['register_activation_success']."</b></center></div>";
    unset($_SESSION['error']);
		header("Location: ".$l['index']);
	} else {
		die("Can't find user");
	}
}
?>