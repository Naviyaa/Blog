<?php require_once("includes/functions.php") ?>
<?php require_once("includes/sessions.php") ?>

<?php

  $_SESSION["UserID"]=null ;
  $_SESSION["UserName"]=null ;
  $_SESSION["AdminName"]=null ;
  session_destroy();
  redirect_to("login.php");

 ?>
