<?php
//Setup Imports
require("../r.php");
require($r."/source/php/main.php");

if(empty($_SESSION['u'])) {
  header("Location: login.php");
}

error_reporting(0);

$changed = 0;

$row = mysql_fetch_assoc(mysql_query("SELECT email,status FROM users WHERE id='".$_SESSION['u']['id']."'"));
$u_mail = $row['email'];
$u_status = $row['status'];

if(!empty($_POST)) {
  $query = "UPDATE users SET";
  if(!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && $_POST['email'] != $_SESSION['u']['email']) {
    $s_mail = $_POST['email'];
    $row = mysql_num_rows(mysql_query("SELECT email FROM users WHERE email='$s_mail'"));
    if($row != 0) {
      header("Location: ".$l['settings']."?msg=2");
      die("REDIRECT");
    }
    $query .= " `email`='".$_POST['email']."'";
    $_SESSION['u']['email'] = $_POST['email'];
    $changed .= 1;
  } else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header("Location: ".$l['settings']."?msg=3");
    die("REDIRECT");
  }
  if(!empty($_POST['pass']) && !empty($_POST['cpass']) && $_POST['pass'] == $_POST['cpass'] && strlen($_POST['pass']) >= 5) {
    $s_pass = $_POST['pass'];
    $options = [
      'cost' => 11,
      'salt' => mcrypt_create_iv(30, MCRYPT_DEV_URANDOM),
    ];
    $crypt_pass = password_hash($s_pass, PASSWORD_BCRYPT, $options);
    $query .= ",`password`='".$crypt_pass."'";
  } else if(strlen($_POST['pass']) >= 5) {
    header("Location: ".$l['settings']."?msg=4");
    die("REDIRECT");
  } else if(!empty($_POST['pass']) && empty($_POST['cpass']) || empty($_POST['pass']) && !empty($_POST['cpass'])) {
    header("Location: ".$l['settings']."?msg=5");
    die("REDIRECT");
  }
  $s_status = $_POST['status'];
  if($changed != 0) {$query .= ",";} else {$query .= " ";}
  //Convert status
  $s_status = strip_tags($s_status);
  $s_status = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s_status);
  $query .= "`status`='".$s_status."'";
  $_SESSION['u']['status'] = $s_status;
  $query .= " WHERE id='".$_SESSION['u']['id']."'";
  mysql_query($query);
  header("Location: ".$l['settings']."?msg=1");
  die("REDIRECT");
}
?>
<html lang="<?php echo $lang;?>">
  <head>
    <title><?php echo $t['title_settings']; ?></title>
    <?php require($r.'/source/php/head.php'); ?>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.43/jquery.form-validator.min.js"></script>
    <script src="//<?php echo $_SERVER['SERVER_NAME'];?>/source/js/simpleUpload.min.js"></script>
  </head>
  <body>
    <?php require($r.'/source/php/navbar.php'); ?>
    <div class="container">
      <div class="well">
          <h2><b><?php echo $t['profile_settings_heading'];?></b> :</h2>
          <?php if(isset($_GET['msg'])) {
            if($_GET['msg'] == 1) {
              echo '<div class="alert alert-success" role="alert">'.$t['profile_settings_msg_1'].'</div>';
            } else if($_GET['msg'] == 2) {
              echo '<div class="alert alert-danger" role="alert">'.$t['profile_settings_msg_2'].'</div>';
            } else if($_GET['msg'] == 3) {
              echo '<div class="alert alert-danger" role="alert">'.$t['profile_settings_msg_3'].'</div>';
            } else if($_GET['msg'] == 4) {
              echo '<div class="alert alert-danger" role="alert">'.$t['profile_settings_msg_4'].'</div>';
            } else if($_GET['msg'] == 5) {
              echo '<div class="alert alert-danger" role="alert">'.$t['profile_settings_msg_5'].'</div>';
            } else if($_GET['msg'] == 6) {
              echo '<div class="alert alert-success" role="alert">'.$t['profile_settings_msg_6'].'</div>';
            }
            } ?>
          <div class="row" style="margin-top:20px">
            <div class="col-md-6">
              <form method="post" action="<?php $l['f_settings'];?>">
                <label class="control-label"><?php echo $t['profile_settings_email']; ?> :</label>
                <input maxlength="200" type="text" required="required" class="form-control" placeholder="<?php echo $t['profile_settings_email']; ?>" name="email" value="<?php echo $u_mail; ?>" data-validation="email" data-validation-error-msg="<?php echo $t['register_form_error_email']; ?>" data-validation-error-msg-container="#email-error-dialog" />
                <div id="email-error-dialog"></div>
                <hr>
                <label class="control-label"><?php echo $t['profile_settings_status']; ?> :</label>
                <textarea maxlength="200" rows="2" class="form-control" placeholder="<?php echo $t['profile_settings_status']; ?>" name="status" style="resize:vertical;max-height:250px;"><?php echo $u_status; ?></textarea>
                <hr>
                <label class="control-label"><?php echo $t['profile_settings_pass']; ?> :</label>
                <input type="password" class="form-control" placeholder="<?php echo $t['profile_settings_pass']; ?>" name="pass" data-validation="length" data-validation-length="6-20" data-validation-error-msg="<?php echo $t['register_form_error_password']; ?>" data-validation-error-msg-container="#password-error-dialog" data-validation-optional="true" />
                <div id="password-error-dialog"></div>
                <label class="control-label"><?php echo $t['profile_settings_cpass']; ?> :</label>
                <input type="password" class="form-control" placeholder="<?php echo $t['profile_settings_cpass']; ?>" name="cpass" data-validation="length" data-validation-length="6-20" data-validation-error-msg="<?php echo $t['register_form_error_password']; ?>" data-validation-error-msg-container="#cpassword-error-dialog" data-validation-optional="true" />
                <div id="cpassword-error-dialog"></div>
                <hr>
                <a href="<?php echo $l['profile']; ?>" class="btn btn-lg btn-danger"><?php echo $t['profile_settings_abort']; ?></a>
                <button name="Submit" class="btn btn-lg btn-success pull-right" type="submit"><?php echo $t['profile_settings_submit']; ?></button>
              </form>
              <h2><b><?php echo $t['profile_settings_pics_heading'];?></b> :</h2>
              <label><?php echo $t['profile_settings_upload'] ?> :</label>
              <input type="file" id="uploadImage" class="form-control">
              <a id="deletePP" class="btn btn-danger pull-right" style="margin-top:5px;"><?php echo $t['profile_settings_upload1_delete']; ?></a><br><br>
              <label><?php echo $t['profile_settings_upload2'] ?> :</label>
              <input type="file" id="uploadImageB" class="form-control">
              <a id="deleteBP" class="btn btn-danger pull-right" style="margin-top:5px;"><?php echo $t['profile_settings_upload2_delete']; ?></a><br><br>
            </div>
            
            <div class="col-md-6">
              <div class="panel panel-primary" style="margin-top:20px">
                <div class="panel-heading">
                  <h3 class="panel-title"><?php echo $t['profile_settings_infobox_title']; ?> :</h3>
                </div>
                <div class="panel-body">
                  <p><?php echo $t['profile_settings_infobox']; ?><center><h3><a href="<?php echo $l['contact'];?>"><?php echo $t['profile_settings_infobox_contact']; ?></a></h3></center></p>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    <script>$.validate(),$(document).ready(function(){$("input[type=file]#uploadImage").change(function(){$(this).simpleUpload("pic.php",{allowedTypes:["image/pjpeg","image/jpeg","image/png","image/x-png","image/gif","image/x-gif"],maxFileSize:5e6,start:function(e){console.log("upload started"),alert("Start")},progress:function(e){console.log("upload progress: "+Math.round(e)+"%")},success:function(e){console.log("upload successful!"),console.log(e),window.location.href="<?php echo $l['settings']; ?>?msg=6"},error:function(e){console.log("upload error: "+e.name+": "+e.message),alert("upload error: "+e.name+": "+e.message)}})}),$("input[type=file]#uploadImageB").change(function(){$(this).simpleUpload("background.php",{allowedTypes:["image/pjpeg","image/jpeg","image/png","image/x-png","image/gif","image/x-gif"],maxFileSize:5e6,start:function(e){console.log("upload started"),alert("Start")},progress:function(e){console.log("upload progress: "+Math.round(e)+"%")},success:function(e){console.log("upload successful!"),console.log(e),window.location.href="<?php echo $l['settings']; ?>?msg=6"},error:function(e){console.log("upload error: "+e.name+": "+e.message),alert("upload error: "+e.name+": "+e.message)}})}),$("#deleteBP").on("click",function(){$.ajax({url:"background.php",type:"POST",data:"delete=yes",success:function(){alert("Finish"),window.location.href="<?php echo $l['settings']; ?>?msg=1"},error:function(){alert("ERROR")}})}),$("#deletePP").on("click",function(){$.ajax({url:"pic.php",type:"POST",data:"delete=yes",success:function(){alert("Finish"),window.location.href="<?php echo $l['settings']; ?>?msg=1"},error:function(){alert("ERROR")}})})});</script>
  </body>
  <?php require($r.'/source/php/footer.php'); ?>
</html>