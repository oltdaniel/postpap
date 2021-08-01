<?php
echo "<footer>
      <hr>
			<div class='container well well-sm'>
      <center>
      <ul class='nav nav-pills'>
          <li><a href='//".$_SERVER['SERVER_NAME']."/terms.php' class='text-muted'>".$t['footer_terms']."</a></li>
          <li><a href='//".$_SERVER['SERVER_NAME']."/privacy.php' class='text-muted'>".$t['footer_privacy']."</a></li>
          <li><a href='' class='text-muted'>© ".date('Y')." ".$t['footer_copyright_by']."</a></li>
          <li><a href='//".$_SERVER['SERVER_NAME']."/cookies.php' class='text-muted'>".$t['footer_cookies']."</a></li>
          <li><a href='//".$_SERVER['SERVER_NAME']."/contact.php' class='text-muted'>".$t['footer_contact']."</a></li>
      </ul>
      </center>
      </div>
      </footer>";
?>
<?php
//Close MYSQL Connections
mysql_close();
$pdo = null;
?>