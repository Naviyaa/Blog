<?php require_once("includes/db.php") ?>
<?php require_once("includes/functions.php") ?>
<?php require_once("includes/sessions.php") ?>

<?php
if(isset($_GET['id'])){
  $searchQueryParameter=$_GET['id'];
  global $connectingDB;
  //$admin=$_SESSION['AdminName'];
  $sql= "DELETE FROM comments WHERE id='$searchQueryParameter' ";
  $execute=$connectingDB->query($sql);
  if($execute){
    $_SESSION["SuccessMessage"]= "Comment deleted successfully.";
    redirect_to("comments.php");
  }else{
    $_SESSION["ErrorMessage"]= "Something went wrong! Try again.";
    redirect_to("comments.php");
  }
}
 ?>
