<?php
//Setup Imports
require("../r.php");
require($r."/source/php/main.php");

if(!empty($_SESSION['u'])) {
	header("Location: index.php");
}

$submitted_username = "";

//Check for POST
if(!empty($_POST)) {
	//Check if every field is fill
	if(empty($_POST['email']) || empty($_POST['password'])) {
		//Insert ERROR message in $_SESSION
		$_SESSION['error'] = "<div class='alert alert-danger' role='alert'><center><b>".$t['login_error_emptyinput']."</b></center></div>";
		header("Location: ../index.php");
	}
	//GET submitted Variables
	$s_mail = strtolower($_POST['email']);
	$s_pass = $_POST['password'];
	//GET results from MYSQL
	$query = $pdo->prepare("SELECT * FROM users WHERE email='$s_mail' AND activated=1 LIMIT 1");
	$query->execute();
	if(!$query->rowCount() == 0) {
		//Fetch results
		$results = $query->fetch();
		$check_password = $results['password'];
		//if password correct
		if(password_verify($s_pass, $check_password)) {
			unset($results['password']);//remove password result
			unset($results['salt']);//remove salt result
			$_SESSION['u'] = $results;
			session_start();
			mysql_query("UPDATE users SET last_ip='".getUserIP()."' WHERE id='".$_SESSION['u']['id']."'");
			header("Location: index.php");
		} else {
			//Insert ERROR message in $_SESSION
			$_SESSION['error'] = "<div class='alert alert-danger' role='alert'><center><b>".$t['login_error_wronginput']."</b></center></div>";
			header("Location: ../index.php");
			$submitted_username = $s_mail;
		}
	} elseif(empty($_SESSION['error'])) {
		//Insert ERROR message in $_SESSION
		$_SESSION['error'] = "<div class='alert alert-danger' role='alert'><center><b>".$t['login_error_noresult']."</b></center></div>";
		header("Location: ../index.php");
	}
} else {
	header("Location: ../index.php");
}
?>