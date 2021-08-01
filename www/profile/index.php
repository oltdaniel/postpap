<?php
//Setup Imports
require("../r.php");
require($r."/source/php/main.php");

if(empty($_SESSION['u'])) {
	header("Location: ".$l['index']);
}
if(!empty($_SESSION['error']) || !empty($_SESSION['success'])) {
	unset($_SESSION['error']);
	unset($_SESSION['success']);

}

$profile=$_SESSION['u']['id'];
?>
<html lang="<?php echo $lang;?>">
  <head>
    <title><?php echo $t['title_profile']; ?></title>
    <style type="text/css">.profile-body:before {background: url(//<?php echo $l['userbase'].$_SESSION['u']['code']."/background.jpg"; ?>);}</style>
    <?php require($r.'/source/php/head.php'); ?>
    <style type="text/css">.userimg{max-width:250px;}.inline{display:inline;}p.glyphicon{margin-left:5px;margin-right:5px;}</style>
  </head>
  <body class="profile-body">
    <?php require($r.'/source/php/navbar.php'); ?>
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="well">
            <center><img src="<?php echo $l['userbase'].$_SESSION['u']['code']; ?>/profile.jpg" class="img-circle userimg" height="100px">
            <h2><?php echo $_SESSION['u']['name']; ?></h2></center>
            <hr>
            <div style="margin-left:15px">
              <p><div class="row"><div class="glyphicon glyphicon-envelope" style="margin-right:10px"></div><?php echo $_SESSION['u']['email']; ?></div></p>
              <p><div class="row"><div class="glyphicon glyphicon-info-sign" style="margin-right:10px"></div><?php echo $_SESSION['u']['status']; ?></div></p>
            </div>
          </div>
        </div>
        <div class="col-md-9">
        <div class="well" style="padding-bottom:40px">
          <form method="post" action="<?php echo $l['f_post']; ?>">
            <textarea maxlength="10000" rows="5" class="form-control" placeholder="<?php echo $t['profile_form_placeholder']; ?>" name="str" style="resize:vertical;"></textarea>
            <button style="margin-top:10px;" type="submit" class="btn btn-success pull-right"><?php echo $t['profile_form_submit']; ?></button>
          </form>
        </div>
        <?php
          echo get_posts($_SESSION['u']['id'],$pdo,$t['profile_posts_from'],$t['profile_posts_at'],$t['profile_posts_comments'],$t['profile_posts_empty'],true);
        ?>
      </div>
    </div>
    <script type="text/javascript">$(document).ready(function(){$(".btn-delete").click(function(){var t=$(this).attr("id"),e=$(this);return e.html("Loading ..."),e.addClass("liked"),$.ajax({type:"POST",url:"<?php echo $l['f_post']; ?>",data:"item_id="+t,cache:!1,success:function(e){$("div#post_"+t).remove()},error:function(t){alert("error")}}),!1})});</script>
    <script type="text/javascript">$(document).ready(function(){$(".btn-like").click(function(){var t=$(this).attr("id"),e=$(this);return e.html("Loading ..."),e.addClass("liked"),$.ajax({type:"POST",url:"<?php echo $l['f_post_like']; ?>",data:"item_id="+t,cache:!1,success:function(t){e.html(t),e.addClass("liked")},error:function(t){alert("error")}}),!1})});</script>
  </body>
  <?php require($r.'/source/php/footer.php'); ?>
</html>