<?php
//Setup Imports
require("r.php");
require($r."/source/php/main.php");
?>
<html lang="<?php echo $lang;?>">
  <head>
    <title><?php echo $t['title_search']; ?></title>
    <?php require($r.'/source/php/head.php'); ?>
  </head>
  <body>
  	<?php require($r.'/source/php/navbar.php'); ?>
    <div class="container">
      <div class="well">
    	<form role="search" method="get" action="<?php echo $l['f_search']; ?>">
	    	<center>
		      <div class="input-group" style="max-width:400px">
		        <input type="text" class="form-control" name="search" placeholder="<?php echo $t['nav_search_placeholder']; ?>" value="<?php if(!empty($_GET['search'])) {echo $_GET['search'];} ?>">
		        <div class="input-group-btn">
		      	  <button type="submit" class="btn btn-info" style="height:38px"><div class="glyphicon glyphicon-search"></div></button>
		        </div>
		      </div>
		    </center>
	    </form>
      </div>
      <div class="well">
        <?php
        if(!empty($_GET['search'])) {
          $search = $_GET['search'];
          $query = $pdo->prepare("SELECT * FROM users WHERE (name LIKE '%$search%' OR email LIKE '%$search%' OR id LIKE '%$search%') AND activated='1'");
          $query->execute();
          if(!$query->rowCount() == 0) {
          	echo '<center><h2>'.$query->rowCount().' '.$t['search_results'].'</h2></center>';
          	while($results = $query->fetch()) {
          		echo '
          		<hr>
	            <div class="row">
	              <div class="col-md-4"><center><img src="'.$l['userbase'].$results['code'].'/profile.jpg" height="64" width="64" class="img-circle"></center></div>
	              <div class="col-md-4"><center><h3>'.$results['name'].'</h3></center></div>
	              <div class="col-md-4" style="margin-top:20px;"><center><a class="btn btn-default" href="'.$l['index'].$results['code'].'"><div class="glyphicon glyphicon-user"></div></a></center></div>
	            </div>
          		';
          	}
          } else {
          	echo '<center><h2>'.$t['search_results_empty'].'</h2></center>';
          }
        } else {
        	echo '<center><h2>'.$t['search_results_empty'].'</h2></center>';
        }
        ?>
      </div>
    </div>
  </body>
  <?php require($r.'/source/php/footer.php'); ?>
</html>