<?php
//Setup Imports
require("../r.php");
require($r."/source/php/main.php");

if(empty($_SESSION['u'])) {
	header("Location: login.php");
}
mysql_query("UPDATE inbox SET status=1 WHERE to_user='".$_SESSION['u']['id']."'");
?>
<html lang="<?php echo $lang;?>">
  <head>
    <title><?php echo $t['title_inbox']; ?></title>
    <?php require($r.'/source/php/head.php'); ?>
  </head>
  <body>
  	<?php require($r.'/source/php/navbar.php'); ?>
    <div class="container">
      <div class="well">
        <?php
          $logged_user = $_SESSION['u']['id'];
          $query = $pdo->prepare("SELECT * FROM friends WHERE user1=$logged_user AND status=1 OR user2=$logged_user AND status=1 ORDER BY id ASC");
          $query->execute();
          if(!$query->rowCount() == 0) {
            echo "<h2>".$t['profile_inbox_friend_heading']." :</h2>";
            while($results = $query->fetch()) {
              if($results['user1'] == $logged_user) {$friend_id = $results['user2'];} else {$friend_id = $results['user1'];}
              $friend_info = mysql_fetch_assoc(mysql_query("SELECT id,code,name FROM users WHERE id='".$friend_id."' LIMIT 1")) or die(mysql_errno());
              echo '
              <hr>
              <div class="row" style="width:90%">
                <p style="margin-left:15px">'.$t['profile_inbox_friend_from'].' <a href="'.$l['index'].$friend_info['code'].'">'.$friend_info['name'].'</a><a class="btn btn-success glyphicon glyphicon-ok pull-right" style="margin-right:15px" href="'.$l['profile_friend'].'?accept='.$friend_info['id'].'"></a><a class="btn btn-danger glyphicon glyphicon-trash pull-right" style="margin-right:15px" href="'.$l['profile_friend'].'?remove='.$friend_info['id'].'"></a></p>
              </div>';
            }
            echo "<hr>";
          }
        ?>
        <?php
          $query = $pdo->prepare("SELECT * FROM inbox WHERE to_user=$logged_user");
          $query->execute();
          if(!$query->rowCount() == 0) {
            while($results = $query->fetch()) {
              $friend_info = mysql_fetch_assoc(mysql_query("SELECT id,code,name FROM users WHERE id='".$results['from_user']."' LIMIT 1"));
              echo '
              
              <div class="container" style="width:90%" id="inbox_'.$results['id'].'">
                <hr>
                <p><b>'.$t['profile_inbox_from'].' <a href="'.$l['index'].$friend_info['code'].'">'.$friend_info['name'].'</a> :</b> <a class="btn-delete btn btn-sm btn-danger glyphicon glyphicon-trash pull-right" id="'.$results['id'].'"></a></p><br>
                <p>'.$results['content'].'</p>';
                if(!empty($results['link'])) {
                  echo '
                <a href="'.$results['link'].'" class="btn btn-primary">'.$t['profile_inbox_open'].'</a>';
                }
                echo '
              </div>';
            }
            echo "<hr>";
          } else {
            echo "<center><h2>".$t['profile_inbox_empty']."</h2></center>";
          }
        ?>
      </div>
    </div>
    <script type="text/javascript">$(document).ready(function(){$(".btn-delete").click(function(){var t=$(this).attr("id"),e=$(this);return e.html("Loading ..."),e.addClass("liked"),$.ajax({type:"POST",url:"<?php echo $l['f_inbox']; ?>",data:"item_id="+t,cache:!1,success:function(e){$("div#inbox_"+t).remove()},error:function(t){alert("error")}}),!1})});</script>
  </body>
  <?php require($r.'/source/php/footer.php'); ?>
</html>