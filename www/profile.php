<?php
//Setup Imports
require("r.php");
require($r."/source/php/main.php");

$code = $_GET['code'];
$row = mysql_num_rows(mysql_query("SELECT * FROM users WHERE code='".$code."'"));
if($row == 0) {
	header("Location: ".$l['error_404']);
	die("404");
}

$profile_code = $_GET['code'];

$q=mysql_query("SELECT id,name,email,code,status FROM users WHERE code='".$profile_code."'") or die(mysql_error());
$e=mysql_fetch_assoc($q);
?>
<html lang="<?php echo $lang;?>">
  <head>
    <title><?php echo $e['name'].$t['title_user']; ?></title>
    <style type="text/css">.profile-body:before {background: url(//<?php echo $l['userbase'].$e['code']."/background.jpg"; ?>);}</style>
    <?php require($r.'/source/php/head.php'); ?>
    <style type="text/css">.userimg{max-width:250px;}.inline{display:inline;}p.glyphicon{margin-left:5px;margin-right:5px;}</style>
  </head>
  <body class="profile-body">
    <?php require($r.'/source/php/navbar.php'); ?>
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="well">
            <center><img src="<?php echo $l['userbase'].$e['code']; ?>/profile.jpg" class="img-circle userimg" height="100px">
            <h2><?php echo $e['name']; ?></h2></center>
            <hr>
            <div style="margin-left:15px">
              <?php
              if(!empty($_SESSION['u'])) {
                if($_SESSION['u']['id'] != $e['id']) {
                  $friendStatus = friendStatus($_SESSION['u']['id'],$e['id'],$pdo);
                  if($friendStatus == 2) {
                    echo '
                    <p><div class="row"><div class="glyphicon glyphicon-envelope" style="margin-right:10px"></div>'.$e['email'].'</div></p>
                    <p><div class="row"><div class="glyphicon glyphicon-info-sign" style="margin-right:10px"></div>'.$e['status'].'</div></p>
                    ';
                  } else if($friendStatus == 3) {
                    echo "<script>alert('You are blocked by this user')</script>";
                    header("Location: ".$l['index']);
                  }
                  echo friendButton($e['id'],$_SESSION['u']['id'],$friendStatus,$l['profile_friend'],$t['profile_btn_friend_add'],$t['profile_btn_friend_accept'],$t['profile_btn_friend_remove'],$t['profile_btn_friend_sended'],$t['profile_btn_friend_block']);
                } else {
                  echo '
                    <p><div class="row"><div class="glyphicon glyphicon-envelope" style="margin-right:10px"></div>'.$e['email'].'</div></p>
                    <p><div class="row"><div class="glyphicon glyphicon-info-sign" style="margin-right:10px"></div>'.$e['status'].'</div></p>
                    ';
                }
              }
              ?>
            </div>
          </div>
        </div>
        <div class="col-md-9">
        <?php
          echo get_posts($e['id'],$pdo,$t['profile_posts_from'],$t['profile_posts_at'],$t['profile_posts_comments'],$t['profile_posts_empty'],false);
        ?>
      </div>
    </div>
    <script type="text/javascript">$(document).ready(function(){$(".btn-like").click(function(){var t=$(this).attr("id"),e=$(this);return e.html("Loading ..."),e.addClass("liked"),$.ajax({type:"POST",url:"<?php echo $l['f_post_like']; ?>",data:"item_id="+t,cache:!1,success:function(t){e.html(t),e.addClass("liked")},error:function(t){alert("error")}}),!1})});</script>
  </body>
  <?php require($r.'/source/php/footer.php'); ?>
</html>