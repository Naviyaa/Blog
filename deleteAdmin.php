<?php require_once("includes/db.php") ?>
<?php require_once("includes/functions.php") ?>
<?php require_once("includes/sessions.php") ?>

<?php
if(isset($_GET['id'])){
  $searchQueryParameter=$_GET['id'];
  global $connectingDB;
  //$admin=$_SESSION['AdminName'];
  $sql= "DELETE FROM admins WHERE id='$searchQueryParameter' ";
  $execute=$connectingDB->query($sql);
  if($execute){
    $_SESSION["SuccessMessage"]= "Admin deleted successfully.";
    redirect_to("admins.php");
  }else{
    $_SESSION["ErrorMessage"]= "Something went wrong! Try again.";
    redirect_to("admins.php");
  }
}
 ?>
