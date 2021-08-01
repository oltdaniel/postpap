<?php
//Base Functions
function getLastPathSegment($url) {
  $path = parse_url($url, PHP_URL_PATH);
  $pathTrimmed = trim($path, '/');
  $pathTokens = explode('/', $pathTrimmed);
  if (substr($path, -1) !== '/') {
    array_pop($pathTokens);
  }
  return end($pathTokens);
}
function rand_str($length = 10) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}
function xcopy($source, $dest, $permissions = 0775)
{
  if (is_link($source)) {
    return symlink(readlink($source), $dest);
  }
  if (is_file($source)) {
    return copy($source, $dest);
  }
  if (!is_dir($dest)) {
    mkdir($dest, $permissions);
  }
  $dir = dir($source);
  while (false !== $entry = $dir->read()) {
    if ($entry == '.' || $entry == '..') {
      continue;
    }
    xcopy("$source/$entry", "$dest/$entry", $permissions);
  }
  $dir->close();
  return true;
}
function getUserIP()
{
  $client  = @$_SERVER['HTTP_CLIENT_IP'];
  $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
  $remote  = $_SERVER['REMOTE_ADDR'];
  if(filter_var($client, FILTER_VALIDATE_IP))
  {
    $ip = $client;
  }
  elseif(filter_var($forward, FILTER_VALIDATE_IP))
  {
    $ip = $forward;
  }
  else
  {
    $ip = $remote;
  }
  return $ip;
}
//Profile Functions
function get_posts($u_id,$pdo,$t_from,$t_at,$t_comments,$t_empty,$set_delete) {
  $string = "";
  $query = $pdo->prepare("SELECT * FROM posts WHERE user='".$u_id."' ORDER BY id DESC");
  $query->execute();
  if(!$query->rowCount() == 0) {
    while($results = $query->fetch()) {
      $query2 = $pdo->prepare("SELECT name FROM users WHERE id='".$results['user']."'");
      $query2->execute();
      $results2 = $query2->fetch();
      $string .= '
      <div class="well" id="post_'.$results['id'].'">
        <div class="panel panel-default">
          <div class="panel-heading">'.$t_from.' '.$results2['name'].' | 
          <span class="glyphicon glyphicon-calendar" style="margin-left:10px;margin-right:5px;"></span> '.$results['t_date']." ".$t_at." ".$results['t_time'];
          if($set_delete == true) {
            $string .= '<a class="glyphicon glyphicon-trash pull-right btn btn-sm btn-danger btn-delete" id="'.$results['id'].'" style="margin-top:-5px;"></a>';
          }
          $string .=  '</div>
          <div class="panel-body">
            <p>'.$results['content'].'</p>
          </div>
          <div class="panel-footer">';
          if(!empty($u_id)) {
            $query2 = $pdo->prepare("SELECT * FROM posts_likes WHERE user='".$u_id."' AND post_id='".$results['id']."'");
            $query2->execute();
            if($query2->rowCount() == 0) {
              $string .= '<a class="glyphicon glyphicon-thumbs-up btn btn-sm btn-success btn-like" id="'.$results['id'].'" style="margin-right:5px;"> '.$results['likes'].'</a>';
            } else {
              $string .= '<a class="glyphicon glyphicon-thumbs-up btn btn-sm btn-success liked" style="margin-right:5px;"> '.$results['likes'].'</a>';
            }
          }
          //$string .= ' | <span class="glyphicon glyphicon-comment" style="margin-left:10px;margin-right:5px;"></span><a>'.$t_comments.'</a>';'
          $string .= '</div>
        </div>
      </div>
      ';
    }
  } else {
    $string .= '<div class="well"><center><h2>'.$t_empty.'</h2></center></div>';
  }
  return $string;
}
function clean_html($string,$a_tags) {
  foreach($a_tags as $tag) {
    $open = substr_count($string, $tag);
    $close = substr_count($string, substr_replace($tag, "/", 2));
    if($open > $close) {
      $n_tag = substr_replace($tag, "/", 2);
      $string .= $n_tag;
    }
    if($open < $close) {
      $string = rtrim($string,$tag);
    }
  }
  return $string;
} 
//Friend functions
function friendStatus($u_id,$f_id,$pdo) {
  if($u_id == $f_id) {
    return '4';
  } else {
    $query = $pdo->prepare("SELECT * FROM friends WHERE user1='".$u_id."' AND user2='".$f_id."' OR user1='".$f_id."' AND user2='".$u_id."'");
    $query->execute();
    if(!$query->rowCount() == 0) {
      $results = $query->fetch();
      if($results['user1'] == $u_id && $results['status'] == '3') {
        return '5';
      } else if($results['user1'] == $u_id && $results['status'] == '1') {
        return '6';
      } else {
        return $results['status'];
      }
    } else {
      return '0';
    }
  }
}
function friendButton($f_id,$u_id,$f_status,$p_friend,$t_add,$t_accept,$t_remove,$t_sended,$t_block) {
  if($f_status == '2') {
    return '<a class="btn btn-danger" href="'.$p_friend.'?remove='.$f_id.'"><div class="glyphicon glyphicon-remove"></div> '.$t_remove.'</a>
    <a class="btn btn-default" href="'.$p_friend.'?block='.$f_id.'"><div class="glyphicon glyphicon-ban-circle"></div> '.$t_block.'</a>';
  } else if($f_status == '1') {
    return '<a class="btn btn-success" href="'.$p_friend.'?accept='.$f_id.'"><div class="glyphicon glyphicon-ok"></div> '.$t_accept.'</a>
    <a class="btn btn-default" href="'.$p_friend.'?block='.$f_id.'"><div class="glyphicon glyphicon-ban-circle"></div> '.$t_block.'</a>';
  } else if($f_status == '0') {
    return '<a class="btn btn-success"  href="'.$p_friend.'?add='.$f_id.'"><div class="glyphicon glyphicon-plus"></div> '.$t_add.'</a>
    <a class="btn btn-default" href="'.$p_friend.'?block='.$f_id.'"><div class="glyphicon glyphicon-ban-circle"></div> '.$t_block.'</a>';
  } else if($f_status == '5') {
    return '<a class="btn btn-danger" href="'.$p_friend.'?remove='.$f_id.'"><div class="glyphicon glyphicon-remove"></div> '.$t_remove.'</a>';
  } else if($f_status == '6') {
    return '<a class="btn btn-success liked"><div class="glyphicon glyphicon-ok"></div> '.$t_sended.'</a>
    <a class="btn btn-danger" href="'.$p_friend.'?remove='.$f_id.'"><div class="glyphicon glyphicon-remove"></div> '.$t_remove.'</a>
    <a class="btn btn-default" href="'.$p_friend.'?block='.$f_id.'"><div class="glyphicon glyphicon-ban-circle"></div> '.$t_block.'</a>';
  }
}
?>