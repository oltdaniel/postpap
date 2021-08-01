<?php
//Setup Imports
require("r.php");
require($r."/source/php/main.php");
require($r."/source/php/mailing/mailing.php");

if(!empty($_SESSION['u'])) {
  header("Location: index.php");
}

//Check for POST
if(!empty($_POST)) {
  //Check if email already exists
  $rows = mysql_num_rows(mysql_query("SELECT email FROM users WHERE email='".$_POST['email']."'"));
  if($rows == 0) {
    //GET submitted Variables
    $s_first = $_POST['firstname'];
    $s_last = $_POST['lastname'];
    $s_mail = strtolower($_POST['email']);
    $s_pass = $_POST['password'];

    $id = mysql_num_rows(mysql_query("SELECT id FROM users"))+1;
    $activation_str = rand_str(40-(count($id))).$id;
    $options = [
      'cost' => 11,
      'salt' => mcrypt_create_iv(30, MCRYPT_DEV_URANDOM),
    ];
    $crypt_pass = password_hash($s_pass, PASSWORD_BCRYPT, $options);
    
    $user_rand = rand_str(20-(count($id))).$id;
    $query = $pdo->prepare("INSERT INTO users(name,email,password,code,register_day,activation_str,activated) VALUES('$s_first $s_last','$s_mail','$crypt_pass','$user_rand',CURRENT_TIMESTAMP,'$activation_str','0')");
    $query->execute() or die('ERROR at insert User');
    mkdir($r."/users/".$user_rand);
    xcopy($r."/users/sample",$r."/users/".$user_rand);
    $_SESSION['success'] = "<div class='alert alert-success' role='alert'><center><b>".$t['register_success']."</b></center></div>";
    unset($_SESSION['error']);
    $m_button = "<br><center><a href='http:".$l['profile_activation']."?c=".$activation_str."'>http:".$l['profile_activation']."?c=".$activation_str."</a></center>";
    send_mail($t['register_mail_subject'],$t['register_mail_content_heading'],$t['register_mail_content_text'].$m_button,$t['register_mail_send_from'],$s_mail,$s_first);
    header("Location: index.php");
  } else {
    //ERROR
    header("Location: ".basename(__FILE__)."?msg1");
  }
}
?>
<html lang="<?php echo $lang;?>">
  <head>
    <title><?php echo $t['title_register']; ?></title>
    <?php require($r.'/source/php/head.php'); ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>
    <style type="text/css">.has-error {border: 1px solid #f44336 !important;-webkit-box-shadow: none !important;-ms-box-shadow: none !important;box-shadow: none !important;}</style>
  </head>
  <body>
  	<?php require($r.'/source/php/navbar.php'); ?>
    <div class="container">
      <div class="well">
        <?php
        if(isset($_GET['msg1'])) {
          echo '<div class="alert alert-danger" role="alert">'.$t['register_error_1'].'</div>';
        }
        ?>
        <form action="<?php echo $l['register']; ?>" method="post" id="register_form">
          <div class="row">
            <div class="col-md-6">
              <label><?php echo $t['register_form_firstname_h']; ?></label>
              <input type="text" data-validation="custom" data-validation-regexp="^([a-zA-Z ]+){2,}$" class="form-control" placeholder="<?php echo $t['register_form_firstname_p']; ?>" name="firstname" data-validation-error-msg="<?php echo $t['register_form_error_name']; ?>" data-validation-error-msg-container="#firstname-error-dialog">
              <div id="firstname-error-dialog"></div>
            </div>
            <div class="col-md-6">
              <label><?php echo $t['register_form_lastname_h']; ?></label>
              <input type="text" data-validation="custom" data-validation-regexp="^([a-zA-Z ]+){2,}$" class="form-control" placeholder="<?php echo $t['register_form_lastname_p']; ?>" name="lastname" data-validation-error-msg="<?php echo $t['register_form_error_name']; ?>" data-validation-error-msg-container="#lastname-error-dialog">
              <div id="lastname-error-dialog"></div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-6">
              <label><?php echo $t['register_form_password_h']; ?></label>
              <input class="form-control" type="password" name="password" data-validation="length" data-validation-length="6-20" data-validation-error-msg="<?php echo $t['register_form_error_password']; ?>" data-validation-error-msg-container="#password-error-dialog" placeholder="<?php echo $t['register_form_password_p']; ?>">
              <div id="password-error-dialog"></div>
            </div>
            <div class="col-md-6">
              <label><?php echo $t['register_form_email_h']; ?></label>
              <input class="form-control" type="email" name="email" data-validation="email" data-validation-error-msg="<?php echo $t['register_form_error_email']; ?>" data-validation-error-msg-container="#email-error-dialog" placeholder="<?php echo $t['register_form_email_p']; ?>">
              <div id="email-error-dialog"></div>
            </div>
          </div>
          <hr>
          <p><center><b><?php echo $t['register_form_conditions']; ?></b><a href="<?php echo $l['conditions']; ?>"> <?php echo $t['register_form_conditions_more']; ?></a></center></p>
          <center><button type="submit" class="btn btn-lg btn-success"><?php echo $t['register_form_submit']; ?></button></center>
        </form>
      </div>
    </div>
    <script>$.validate();</script>
  </body>
  <?php require($r.'/source/php/footer.php'); ?>
</html>