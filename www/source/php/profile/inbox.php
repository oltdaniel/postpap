<?php
//Setup Imports
require("../main.php");

if(!empty($_POST['item_id'])) {
	mysql_query("DELETE FROM inbox WHERE id='".$_POST['item_id']."'");
}
?>