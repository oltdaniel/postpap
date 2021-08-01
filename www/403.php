<?php
//Setup Imports
require("r.php");
require($r."/source/php/main.php");
?>
<html lang="<?php echo $lang;?>">
  <head>
    <title><?php echo $t['title_error_403']; ?></title>
    <?php require($r.'/source/php/head.php'); ?>
    <style type="text/css">.userimg{max-width:250px;}.inline{display:inline;}p.glyphicon{margin-left:5px;margin-right:5px;}</style>
  </head>
  <body>
    <?php require($r.'/source/php/navbar.php'); ?>
    <style type="text/css">body{background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAaCAYAAACpSkzOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMC8yOS8xMiKqq3kAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAABHklEQVRIib2Vyw6EIAxFW5idr///Qx9sfG3pLEyJ3tAwi5EmBqRo7vHawiEEERHS6x7MTMxMVv6+z3tPMUYSkfTM/R0fEaG2bbMv+Gc4nZzn+dN4HAcREa3r+hi3bcuu68jLskhVIlW073tWaYlQ9+F9IpqmSfq+fwskhdO/AwmUTJXrOuaRQNeRkOd5lq7rXmS5InmERKoER/QMvUAPlZDHcZRhGN4CSeGY+aHMqgcks5RrHv/eeh455x5KrMq2yHQdibDO6ncG/KZWL7M8xDyS1/MIO0NJqdULLS81X6/X6aR0nqBSJcPeZnlZrzN477NKURn2Nus8sjzmEII0TfMiyxUuxphVWjpJkbx0btUnshRihVv70Bv8ItXq6Asoi/ZiCbU6YgAAAABJRU5ErkJggg==);}.error-template{padding:40px 15px;text-align:center;}.error-actions{margin-top:15px;margin-bottom:15px;}.error-actions .btn{margin-right:10px;}</style>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="error-template">
            <h1><?php echo $t['403_h1']; ?></h1>
            <h2><?php echo $t['403_h2']; ?></h2>
            <div class="error-details">
              <?php echo $t['403_content']; ?><b>!</b>
            </div>
            <div class="error-actions">
              <a href="<?php echo $l['index']; ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span> <?php echo $t['error_home']; ?></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  <?php require($r.'/source/php/footer.php'); ?>
</html>