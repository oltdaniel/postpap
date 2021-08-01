<?php
//Setup Imports
require("../r.php");
require($r."/source/php/main.php");

if(empty($_SESSION['u'])) {
	header("Location: login.php");
}
	function encrypt($string, $key) {
	  $result = '';
	  for($i=0; $i<strlen ($string); $i++) {
	    $char = substr($string, $i, 1);
	    $keychar = substr($key, ($i % strlen($key))-1, 1);
	    $char = chr(ord($char)+ord($keychar));
	    $result.=$char;
	  }

	  return base64_encode($result);
	}

	function decrypt($string, $key) {
	  $result = '';
	  $string = base64_decode($string);

	  for($i=0; $i<strlen($string); $i++) {
	    $char = substr($string, $i, 1);
	    $keychar = substr($key, ($i % strlen($key))-1, 1);
	    $char = chr(ord($char)-ord($keychar));
	    $result.=$char;
	  }

	  return $result;
	}

  $chatwith = '';
  $chatid = '';

	if(!empty($_GET['with'])) {
		setcookie('chatwith',$_GET['with'], time()+3600);
		$chatwith = $_COOKIE['chatwith'];
    mysql_query("UPDATE chats SET message1='0' WHERE user1='".$_SESSION['u']['id']."' AND user2='".$chatwith."'") or die("ERROR2" . mysql_error());
    mysql_query("UPDATE chats SET message2='0' WHERE user2='".$_SESSION['u']['id']."'  AND user1='".$chatwith."'") or die("ERROR2" . mysql_error());
    echo "<script type='text/javascript'> document.location = 'chat.php'; </script>";
	} elseif (!empty($_COOKIE['chatwith'])) {
		$chatwith = $_COOKIE['chatwith'];
    $q=mysql_query("SELECT * FROM users WHERE id='$chatwith'") or die(mysql_error());
    while($e=mysql_fetch_assoc($q)) {
      $chatwith_code = $e['code'];
    }
    mysql_query("UPDATE chats SET message1='0' WHERE user1='".$_SESSION['u']['id']."' AND user2='".$chatwith."'") or die("ERROR2" . mysql_error());
    mysql_query("UPDATE chats SET message2='0' WHERE user2='".$_SESSION['u']['id']."' AND user1='".$chatwith."'") or die("ERROR2" . mysql_error());
	} elseif(empty($_COOKIE['chatwith']) && empty($_GET['with'])) {
		header("Location: friends.php");
	}
  $email = $_SESSION['u']['id'];
  $query = $pdo->prepare("SELECT * FROM chats WHERE user1 = '$email' AND user2 = '$chatwith' OR user1 = '$chatwith' AND user2 = '$email'");
  $query->execute() or die("ERROR");
  // Display search result
  if (!$query->rowCount() == 0) {
   	$results = $query->fetch();
    $chatid = $results['id'];
  } elseif($chatwith != $_SESSION['u']['id']) {
    mysql_query("INSERT INTO chats(user1,user2) VALUES ('".$_SESSION['u']['id']."','".$chatwith."')");
  }

  if(isset($_GET['clear'])) {
    mysql_query("DELETE FROM chat_messages WHERE chat_id='".$chatid."'");
    mysql_query("UPDATE chats SET message1='0' , message2='0' WHERE user1='".$chatwith."' AND user2='".$_SESSION['u']['id']."' OR user1='".$_SESSION['u']['id']."' AND user2='".$chatwith."'") or die("ERROR2" . mysql_error());
  }
?>
<html lang="<?php echo $lang;?>">
	<head>
		<title><?php echo $t['title_chat']; ?></title>
		<?php require($r.'/source/php/head.php'); ?>
	</head>
	<body>
		<?php require($r.'/source/php/navbar.php'); ?>
		<div class="container">
		<div class="well well-sm">
			<div class="row">
          <div class="col-md-11"><center><h3 style="margin-top: 0px;"><img src="//<?php echo $_SERVER['SERVER_NAME'];?>/users/<?php echo $chatwith_code; ?>/profile.jpg" class="img-circle" width="40" height="40" style="margin-top: -5px;margin-right: 100px;"><?php $q=mysql_query("SELECT * FROM users WHERE id='".$chatwith."'") or die(mysql_error());while($e=mysql_fetch_assoc($q)) {echo $e['name']; }?></h3></center></div>
          <div class="col-md-1"><a class="btn btn-danger inline pull-right" href="chat.php?clear"  style="margin-bottom: 10px;"><div class="glyphicon glyphicon-trash"></div></a></div>
      </div>
      <div name="chat" id="chat" class="chat-history">
      </div>
      <script>
      function getMessages() {
      	$.post("functions/get_chat_messages.php", {chatid: <?php echo $chatid; ?>,chatwith: '<?php echo $chatwith; ?>'}, function(result){
          $("#chat").html(result);
        });
      }
      window.setInterval(function(){
        $.post("functions/get_chat_messages.php", {chatid: <?php echo $chatid; ?>,chatwith: '<?php echo $chatwith; ?>'}, function(result){
          $("#chat").html(result);
        });
      }, 1500);

      getMessages();

      function send_message() {
        $.post("functions/send_chat_message.php", {chatid: <?php echo $chatid; ?>,chatmessage: $('#message').val(),chatwith: '<?php echo $chatwith; ?>'});
        $("#message").val("");
      }
      </script> 
      <div class="input-group" style="margin-top:5px">
        <input type="text" class="form-control" name="message" id="message" placeholder="<?php echo $t['chat_input_placeholder'];?>" autofocus>
        <span class="input-group-btn">
          <button class="btn btn-info" type="submit" id="send_message" name="send_message" onclick="send_message()"><?php echo $t['chat_input_submit'];?></button>
        </span>
      </div>
      </div>
	</body>
	<?php require($r.'/source/php/footer.php'); ?>
</html>