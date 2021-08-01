<!DOCTYPE html>
<html lang="<?php echo $lang;?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $t['login_groups_title'];?></title>
        <link rel="icon" type="image/ico" href="//<?php echo $_SERVER['SERVER_NAME'];?>/Asset/img/favicon.ico">
        <link rel="stylesheet" href="//<?php echo $_SERVER['SERVER_NAME'];?>/Asset/css/bootstrap.min.css">
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="//<?php echo $_SERVER['SERVER_NAME'];?>/Asset/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php require("../navbar.php"); ?>
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="<?php echo basename('mailing.php'); ?>" method="post">
                        <input type="text" maxlength="25" placeholder="Subject" id="e_subject" name="e_subject" class="form-control" /><br>
                        <input type="text" maxlength="25" placeholder="Content Title" id="c_title" name="c_title" class="form-control" /><br>
                        <textarea class="form-control" name="c_content" style="resize:vertical;height:150px;" id="c_content" placeholder="Content"></textarea><br>
                        <input type="text" maxlength="40" placeholder="Button Text" id="c_button" name="c_button" class="form-control" /><br>
                        <input type="text" placeholder="Button Link" id="c_button_link" name="c_button_link" class="form-control" /><br>
                        <input type="text" placeholder="Only to user" id="only_to_user" name="only_to_user" class="form-control" /><br>
                        <select class="form-control" name="type" id="type">
                            <option value="all">All</option>
                            <option value="only_to">Only to User</option>
                        </select>

                        <button type="submit" name="Submit" class="btn btn-primary" style="margin-top:5px;">Send E-Mails</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
  <footer>
    <?php require("../footer.php"); ?>
  </footer>
</html>