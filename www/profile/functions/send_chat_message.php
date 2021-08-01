<?php
  require("../../r.php");
  require($r."/source/php/main.php");
// NOTE: this is not good security, but not the worst, especially in such a simple use case
// replace this string before starting
$securecode = "yN[CEx(GQ.\zST3&{VF8";

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

if(!empty($_POST) && !empty($_POST['chatmessage'])) {
  $new_message = $_POST['chatmessage'];
  $new_message = encrypt($new_message,$securecode);
  mysql_query("INSERT INTO chat_messages(from_user, message, date_time, chat_id) VALUES ('".$_SESSION['u']['id']."','".$new_message."','".date("G:i:s") . " | " . date("d.m.Y")."','".$_POST['chatid']."')");
  // NOTE: guess i started on integrating groups and broke the chat notifications
  $q=mysql_query("SELECT * FROM group_user WHERE group_id='".$_POST['chatid']."'") or die(mysql_error());
  while($e=mysql_fetch_assoc($q)) {
    mysql_query("UPDATE group_user SET message+=1 WHERE user='".$e['user']."'");
  }
}
?>