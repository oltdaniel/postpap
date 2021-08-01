<?php
//Setup Imports
require("r.php");
require($r."/source/php/main.php");?>
<!DOCTYPE html>
<html lang="<?php echo $lang;?>">
  <head>
    <title>Kontakt | postpap.de</title>
    <?php require($r.'/source/php/head.php'); ?>
  </head>
  <body>
  <?php require($r.'/source/php/navbar.php'); ?>
    <div class="container">
      
      <h2><?php echo $t['contact_heading'];?></h2>
      <center><h1><a href="mailto:support@postpap.de">support@postpap.de</a></h1></center>
      <p><?php echo $t['contact_content'];?></p>
    </div>
  </body>
  <?php require($r.'/source/php/footer.php'); ?>
</html>