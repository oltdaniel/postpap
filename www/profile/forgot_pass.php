<?php
//Setup Imports
require("../r.php");
require($r."/source/php/main.php");

if(!empty($_POST['email'])) {
	$row = mysql_num_rows(mysql_query("SELECT email FROM users WHERE email='".$_POST['email']."'"));
	if($row == 1) {
		//SEND MAIL
		$s_email = $_POST['email'];
		require($r."/source/php/mailing/mailing.php");
		$user = mysql_query("SELECT id,name FROM users WHERE email='".$s_email."'");
    $forgot_pass_str = rand_str(40-(strlen($user['id']))).$user['id'];
    mysql_query("UPDATE users SET forgot_str='".$forgot_pass_str."' WHERE email='".$s_email."'");
    $m_button = "<br><center><a href='http:".$l['forgot_pass']."?c=".$forgot_pass_str."'>http:".$l['forgot_pass']."?c=".$forgot_pass_str."</a></center>";
		send_mail($t['forgot_pass_mail_subject'],$t['forgot_pass_mail_content_heading'],$t['forgot_pass_mail_content_text'].$m_button,$t['forgot_pass_mail_send_from'],$s_email,$user['name']);
		header("Location: ".basename(__FILE__)."?msg2");
	} else {
		//ERROR
		header("Location: ".basename(__FILE__)."?msg1");
	}
}
if(!empty($_POST['pass']) && !empty($_POST['cpass'])) {
	$pass = $_POST['pass'];
	$cpass = $_POST['cpass'];
	if($pass == $cpass) {
		//Change password
		$options = [
      'cost' => 11,
      'salt' => mcrypt_create_iv(30, MCRYPT_DEV_URANDOM),
    ];
    $crypt_pass = password_hash($pass, PASSWORD_BCRYPT, $options) or die();
    mysql_query("UPDATE users SET forgot_str='null', password='".$crypt_pass."' WHERE forgot_str='".$_GET['c']."'") or die(mysql_error());
    header("Location: ".basename(__FILE__)."?msg4");
	} else {
		//ERROR
		header("Location: ".basename(__FILE__)."?msg3");
	}
}
?>
<html lang="'.$lang;?>">
  <head>
    <title><?php echo $t['title_forgot']; ?></title>
    <?php require($r.'/source/php/head.php'); ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>
  </head>
  <body>
  	<?php require($r.'/source/php/navbar.php'); ?>
    <div class="container">
	    <div class="well">
	    	<?php
	    	if(isset($_GET['msg1'])) {
	    		echo '<div class="alert alert-danger" role="alert">'.$t['forgot_pass_error_1'].'</div>';
	    	} else if(isset($_GET['msg2'])) {
	    		echo '<div class="alert alert-success" role="alert">'.$t['forgot_pass_success_1'].'</div>';
	    	} else if(isset($_GET['msg3'])) {
	    		echo '<div class="alert alert-danger" role="alert">'.$t['forgot_pass_error_2'].'</div>';
	    	} else if(isset($_GET['msg4'])) {
	    		echo '<div class="alert alert-success" role="alert">'.$t['forgot_pass_success_2'].'</div>';
	    	}
	    	?>
	      <?php
	      if(!empty($_GET['c'])) {
	      	echo '
	      	<form action="'.basename(__FILE__).'?c='.$_GET['c'].'" method="post" style="min-width:200px;width:50%">
						<label>'.$t['forgot_pass_form_pass_h'].' :</label>
						<input type="password" name="pass" class="form-control" data-validation="length" data-validation-length="6-20" data-validation-error-msg="'.$t['register_form_error_password'].'" data-validation-error-msg-container="#password-error-dialog" placeholder="'.$t['forgot_pass_form_pass_h'].'">
						<div id="password-error-dialog"></div>
						<label>'.$t['forgot_pass_form_cpass_p'].' :</label>
						<input type="password" name="cpass" class="form-control" data-validation="length" data-validation-length="6-20" data-validation-error-msg="'.$t['register_form_error_password'].'" data-validation-error-msg-container="#cpassword-error-dialog" placeholder="'.$t['forgot_pass_form_cpass_h'].'">
						<div id="cpassword-error-dialog"></div>
						<center><button type="submit" class="btn btn-success" style="margin-top:10px">'.$t['forgot_pass_form_pass_submit'].'</button></center>
					</form>
	      	';
	      } else {
	      	echo '
	      	<form action="'.basename(__FILE__).'" method="post" style="min-width:200px;width:50%">
						<label>'.$t['forgot_pass_form_mail_h'].' :</label>
						<div class="input-group">
					    <input type="text" name="email" class="form-control" placeholder="'.$t['forgot_pass_form_mail_p'].'" data-validation="email" data-validation-error-msg="'.$t['register_form_error_email'].'" data-validation-error-msg-container="#email-error-dialog">
					    <span class="input-group-btn">
					      <button class="btn btn-primary" type="submit">'.$t['forgot_pass_form_mail_submit'].'</button>
					    </span>
					  </div>
					  <div id="email-error-dialog"></div>
					</form>
	      	';
	      }
	      ?>
      </div>
    </div>
    <script>$.validate();</script>
  </body>
  <?php require($r.'/source/php/footer.php'); ?>
</html>