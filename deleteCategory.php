<?php require_once("includes/db.php") ?>
<?php require_once("includes/functions.php") ?>
<?php require_once("includes/sessions.php") ?>

<?php
if(isset($_GET['id'])){
  $searchQueryParameter=$_GET['id'];
  global $connectingDB;
  //$admin=$_SESSION['AdminName'];
  $sql= "DELETE FROM category WHERE id='$searchQueryParameter' ";
  $execute=$connectingDB->query($sql);
  if($execute){
    $_SESSION["SuccessMessage"]= "Category deleted successfully.";
    redirect_to("categories.php");
  }else{
    $_SESSION["ErrorMessage"]= "Something went wrong! Try again.";
    redirect_to("categories.php");
  }
}
 ?>
