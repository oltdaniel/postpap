<?php
  require("../../r.php");
  require($r."/source/php/main.php");
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
  if(!empty($_SESSION['u']['id'])) {       
    $dechathistory = '';
    $email = $_SESSION['u']['id'];
    $chatwith = $_POST['chatwith'];
    $chatid = $_POST['chatid'];
    $query = $pdo->prepare("SELECT * FROM chat_messages WHERE from_user = '".$email."' AND chat_id=".$chatid." OR from_user = '".$chatwith."' AND chat_id=".$chatid." ORDER BY id ASC");
    $query->execute() or die("ERROR");
    if (!$query->rowCount() == 0) {
      while($results = $query->fetch()) {
        //$chathistory = array_pop($chathistory);
        $message_decrypt = decrypt($results['message'],$securecode);
        if($results['from_user'] == $_SESSION['u']['id']) {
          $dechathistory .= "<div class='well well-sm' style='background-color:#3A9CDE;margin-bottom:-15px;'><p>".$message_decrypt."</p><p class='message-date'>".$results['date_time']."</p></div><br>\n";
        } else {
          $dechathistory .= "<div class='well well-sm' style='background-color:#78E378;margin-bottom:-15px;'><p>".$message_decrypt."</p><p class='message-date'>".$results['date_time']."</p></div><br>\n";
        }
      }
      $dechathistory .= "<div name='chat-end' id=name='chat-end'></div>";
      echo $dechathistory;
    } else {
      echo "<center><h2>Dieser Chat ist momentan leer.</h2></center>";
    }
  } else {
    header("Location: login.php");
  }
?>