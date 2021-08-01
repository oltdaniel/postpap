<?php
if(!empty($_SESSION['u'])) {
  $user_id = $_SESSION['u']['id'];
  $new_message = mysql_num_rows(mysql_query("SELECT id FROM friends WHERE user2='$user_id' AND status=1"));
  $new_message += mysql_num_rows(mysql_query("SELECT id FROM inbox WHERE to_user='$user_id' AND status=0"));
  $new_message += mysql_num_rows(mysql_query("SELECT message1 FROM chats WHERE user1='$user_id' AND message1<>0"));
  $new_message += mysql_num_rows(mysql_query("SELECT message2 FROM chats WHERE user2='$user_id' AND message2<>0"));
  $chat_message = mysql_num_rows(mysql_query("SELECT message1 FROM chats WHERE user1='$user_id' AND message1<>0"));
  $chat_message += mysql_num_rows(mysql_query("SELECT message2 FROM chats WHERE user2='$user_id' AND message2<>0"));
  $in_message = mysql_num_rows(mysql_query("SELECT id FROM friends WHERE user2='$user_id' AND status=1"));
  $in_message += mysql_num_rows(mysql_query("SELECT id FROM inbox WHERE to_user='$user_id' AND status=0"));
  if($new_message != 0) {
    $new_message = '<span class="label label-success" style="margin-left:5px;margin-top:-10px;">'.$new_message.'</span>';
  } else {
    $new_message = "";
  }
  if($chat_message != 0) {
    $chat_message = '<span class="label label-success" style="margin-left:5px;margin-top:-10px;">'.$chat_message.'</span>';
  } else {
    $chat_message = "";
  }
  if($in_message != 0) {
    $in_message = '<span class="label label-success" style="margin-left:5px;margin-top:-10px;">'.$in_message.'</span>';
  } else {
    $in_message = "";
  }
}
?>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" class="visible-xs visible-sm">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="" class="navbar-brand"><img alt="Brand" src="//<?php echo $_SERVER['SERVER_NAME'];?>/source/img/favicon.ico" height="40" style="margin-top: -0.4em;"></a>
      <ul class="nav navbar-nav row">
        <?php
        if(!empty($_SESSION['u'])) {
        list($u_first,$u_last) = explode(" ", $_SESSION['u']['name']);
          echo '
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="margin-top:-10px;margin-bottom:-10px"><div class="pull-right navbar-text"><img src="'.$l['userbase'].$_SESSION['u']['code'].'/profile.jpg" class="img-circle" style="margin-right:10px;">'.$u_first.'   '.$new_message.' <span class="caret"></span></div></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="'.$l['profile'].'">'.$t['nav_profile'].'</a></li>
            <li><a href="'.$l['friends'].'">'.$t['nav_friends'].'</a></li>
            <li><a href="'.$l['inbox'].'">'.$t['nav_inbox'].' '.$in_message.'</a></li>
            <li><a href="'.$l['chat'].'">'.$t['nav_chat'].' '.$chat_message.'</a></li>
            <li class="divider"></li>
            <li><a href="'.$l['settings'].'">'.$t['nav_settings'].'</a></li>
            <li class="divider"></li>
            <li><a href="'.$l['logout'].'">'.$t['nav_logout'].'</a></li>
          </ul>
        </li>';
      } else {
        echo '<li><a href="'.$l['index'].'">'.$t['nav_login'].'</a></li>
          <li><a href="'.$l['register'].'">'.$t['nav_register'].'</a></li>';
        }?>
      </ul>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="overflow:hidden">
      <ul class="nav navbar-nav navbar-right">
	      <form class="navbar-form navbar-left" role="search" method="get" action="<?php echo $l['f_search']; ?>" style="margin-left:1px;margin-right:1px;">
	        <div class="input-group">
	          <input type="text" class="form-control" name="search" placeholder="<?php echo $t['nav_search_placeholder']; ?>">
	          <div class="input-group-btn">
	        	<button type="submit" class="btn btn-info" style="height:38px"><div class="glyphicon glyphicon-search"></div></button>
	          </div>
	        </div>
	      </form>
      </ul>
    </div>
  </div>
</nav>