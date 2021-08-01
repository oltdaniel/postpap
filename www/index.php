<?php
//Setup Imports
require("r.php");
require($r."/source/php/main.php");

if(!empty($_SESSION['u'])) {
  header("Location: ".$l['profile']);
}
?>
<html lang="<?php echo $lang;?>">
  <head>
    <title><?php echo $t['title_index']; ?></title>
    <?php require($r.'/source/php/head.php'); ?>
    <style type="text/css">.message-field {	margin-top: 10px;}</style>
  </head>
  <body>
  	<?php require($r.'/source/php/navbar.php'); ?>
    <div class="container">
      <div class="jumbotron" style="background-color:#F8F8F8">
	      <center>
          <div class="panel panel-default" style="max-width:350px;opacity:0.9;margin:10px">
  	        <div class="panel-body">
    		      <form class="form-signin" method="post" action="<?php echo $l['f_login'] ?>">
    		        <h2 class="form-signin-heading"><?php echo $t['index_form_title'] ?></h2>
    		        <input name="email" type="text" class="form-control" placeholder="<?php echo $t['index_form_email'] ?>" autofocus>
    		        <input name="password" type="password" class="form-control" placeholder="<?php echo $t['index_form_pass'] ?>">
                <center><a href="<?php echo $l['forgot_pass']; ?>"><?php echo $t['index_from_forgot_pass']; ?></a></center>
    		        <center><button name="Submit" class="btn btn-lg btn-success" type="submit" style="margin-top:5px"><?php echo $t['index_form_submit'] ?></button></center>
    		        <div class="message-field">
    		            <?php if(isset($_SESSION['error'])) {echo $error = $_SESSION['error'];} ?><?php if(isset($_SESSION['success']) && !isset($_SESSION['error'])) {echo $success = $_SESSION['success'];} ?>
    		        </div>
    		      </form>
  		      </div>
  	      </div>
        </center>
	  </div>
    </div>
  </body>
  <?php require($r.'/source/php/footer.php'); ?>
</html>