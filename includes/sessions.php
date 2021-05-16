<?php

session_start();

function error_message(){
  if(isset($_SESSION["ErrorMessage"])){
    $output="<div class=\"alert alert-danger\">";
    $output.=htmlentities($_SESSION["ErrorMessage"]);
    $output.="</div>";
    $_SESSION["ErrorMessage"]=null;
    return $output;
  }
}

function success_message(){
  if(isset($_SESSION['SuccessMessage'])){
    $output="<div class=\"alert alert-success\">".htmlentities($_SESSION["SuccessMessage"])."</div>";
    $_SESSION["SuccessMessage"]=null;
    return $output;
  }
}

 ?>
