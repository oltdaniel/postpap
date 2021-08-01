<?php
//Setup Imports
require("../r.php");
require($r."/source/php/main.php");

unset($_SESSION['u']);
header("Location: index.php");
?>