<?php
$d = "//".$_SERVER['SERVER_NAME'];
$root = dirname("../../index.php");
//Main
$l['index'] = $d."/";
$l['main'] = $d;
$l['contact'] = $d."/contact.php";
$l['register'] = $d."/register.php";
$l['userbase'] = $d."/users/";
$l['conditions'] = $d."/conditions.php";
$l['favicon'] = $d."/source/img/favcion.ico";

//Profile
$l['profile'] = $d."/profile";
$l['friends'] = $d."/profile/friends.php";
$l['chat'] = $d."/profile/chat.php";
$l['inbox'] = $d."/profile/inbox.php";
$l['settings'] = $d."/profile/settings.php";
$l['logout'] = $d."/profile/logout.php";
$l['profile_friend'] = $d."/source/php/profile/friend.php";
$l['profile_chat'] = $d."/profile/chat.php";
$l['profile_activation'] = $d."/activate.php";
$l['profile_img_alternate'] = $d."/source/img/alternate_profile.jpg";
$l['forgot_pass'] = $d."/forgot_pass.php";

//Forms
$l['f_search'] = $root."/search.php";
$l['f_login'] = $root."/profile/login.php";
$l['f_settings'] = $root."/profile/settings.php";
$l['f_post'] = $root."/source/php/profile/post.php";
$l['f_post_like'] = $root."/source/php/profile/like.php";
$l['f_profile_friend'] = $root."/source/php/profile/friend.php";
$l['f_inbox'] = $root."/source/php/profile/inbox.php";

//Error Pages
$l['error_404'] = $d."/404.php";
?>