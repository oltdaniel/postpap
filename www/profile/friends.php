<?php
//Setup Imports
require("../r.php");
require($r."/source/php/main.php");

if(empty($_SESSION['u'])) {
	header("Location: login.php");
}
if(!empty($_SESSION['error']) || !empty($_SESSION['success'])) {
	unset($_SESSION['error']);
	unset($_SESSION['success']);

}
?>
<html lang="<?php echo $lang;?>">
  <head>
    <title><?php echo $t['title_friends']; ?></title>
    <?php require($r.'/source/php/head.php'); ?>
  </head>
  <body>
  	<?php require($r.'/source/php/navbar.php'); ?>
    <div class="container">
      <div class="well">
      <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#blockedUser" href="#blockedUser"><?php echo $t['profile_friends_modal_open']; ?></button>
      <div class="modal fade" id="blockedUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel"><?php echo $t['profile_friends_modal_title']; ?></h4>
            </div>
            <div class="modal-body">
              <?php
                $logged_user = $_SESSION['u']['id'];
                $query = $pdo->prepare("SELECT * FROM friends WHERE user1='$logged_user' AND status='3'");
                $query->execute();
                if(!$query->rowCount() == 0) {
                  while($results = $query->fetch()) {
                    if($results['user1'] != $logged_user) {$friend_id = $results['user1'];}else{$friend_id = $results['user2'];}
                    $friend_info = mysql_fetch_assoc(mysql_query("SELECT id,name,code FROM users WHERE id='$friend_id' LIMIT 1"));
                    echo '
                    <hr>
                    <div class="row">
                      <div class="col-md-4"><center><img src="'.$l['userbase'].$friend_info['code'].'/profile.jpg" height="64" width="64" class="img-circle"></center></div>
                      <div class="col-md-4"><center><h3>'.$friend_info['name'].'</h3></center></div>
                      <div class="col-md-4" style="margin-top:20px;"><center><a class="btn btn-default" href="'.$l['index'].$friend_info['code'].'"><div class="glyphicon glyphicon-user"></div></a>&nbsp;&nbsp;<a class="btn btn-danger" href="'.$l['profile_friend'].'?remove='.$friend_info['id'].'"><div class="glyphicon glyphicon-remove"></div></a></center></div>
                    </div>';
                  }
                  echo "<hr>";
                } else {
                  echo "<center><h2>".$t['profile_friends_modal_empty']."</h2></center>";
                }
              ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $t['profile_friends_modal_close']; ?></button>
            </div>
          </div>
        </div>
      </div>
        <h3><b><?php echo $t['profile_friends_heading']; ?> :</b></h3>
        <div class="container">
        <?php
          $logged_user = $_SESSION['u']['id'];
          $query = $pdo->prepare("SELECT * FROM friends WHERE user1='$logged_user' AND status='2' OR user2='$logged_user' AND status='2'");
          $query->execute();
          if(!$query->rowCount() == 0) {
            while($results = $query->fetch()) {
              if($results['user1'] != $logged_user) {$friend_id = $results['user1'];}else{$friend_id = $results['user2'];}
              $friend_info = mysql_fetch_assoc(mysql_query("SELECT id,name,code FROM users WHERE id='$friend_id' LIMIT 1"));
              echo '
              <hr>
              <div class="row">
                <div class="col-md-4"><center><img src="'.$l['userbase'].$friend_info['code'].'/profile.jpg" height="64" width="64" class="img-circle"></center></div>
                <div class="col-md-4"><center><h3>'.$friend_info['name'].'</h3></center></div>
                <div class="col-md-4" style="margin-top:20px;"><center><a class="btn btn-default" href="'.$l['index'].$friend_info['code'].'"><div class="glyphicon glyphicon-user"></div></a>&nbsp;&nbsp;<a class="btn btn-default" href="'.$l['profile_chat'].'?with='.$friend_info['id'].'"><div class="glyphicon glyphicon-comment"></div></a></center></div>
              </div>';
            }
            echo "<hr>";
          } else {
            echo "<center><h2>".$t['profile_friends_empty']."</h2></center>";
          }
        ?>
        </div>
      </div>
    </div>
  </body>
  <?php require($r.'/source/php/footer.php'); ?>
</html>