<?php
//Imports
require("../r.php");
require($r."/source/php/main.php");

$target_file = "../users/".$_SESSION['u']['code']."/background.jpg";

if(!empty($_FILES['file'])) {
	$target_dir = "";
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
		$image = imagecreatefromjpeg($target_file);
		imagejpeg($image,$target_file,75) or die();
	  $success = true;
	} else {
	  echo "Sorry, there was an error uploading your file.";
	  $success = false;
	}

	if ($success) {
		$output = array("success" => true, "message" => "Success!");
	} else {
		$output = array("success" => false, "error" => "Failure!");
	}

	if (($iframeId = (int)$_GET["_iframeUpload"]) > 0) {
		header("Content-Type: text/html; charset=utf-8");
	}
}
if(!empty($_POST['delete'])) {
	unlink($target_file);
}
?>