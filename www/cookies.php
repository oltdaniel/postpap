<?php
//Setup Imports
require("r.php");
require($r."/source/php/main.php");?>
<!DOCTYPE html>
<html lang="<?php echo $lang;?>">
  <head>
    <title>Cookies | postpap.de</title>
    <?php require($r.'/source/php/head.php'); ?>
  </head>
  <body>
  <style type="text/css">
  h3 {
    color: #f39c12;
  }

  p {
    font-family: sans-serif;
  }
  </style>
  <?php require($r.'/source/php/navbar.php'); ?>
		<div class="container">
			<h1><?php echo $t['cookies_heading']; ?></h1>
      <p><?php echo $t['cookies_content_why']; ?></p>
      <div style="margin-left:20px">
      <?php echo $t['cookies_content_all']; ?>
      </div>
		</div>
  </body>
  <?php require($r.'/source/php/footer.php'); ?>
</html>