<?php require_once("includes/db.php") ?>
<?php require_once("includes/functions.php") ?>
<?php require_once("includes/sessions.php") ?>

<?php
if(isset($_GET['id'])){
  $searchQueryParameter=$_GET['id'];
  global $connectingDB;
  $admin=$_SESSION['AdminName'];
  $sql= "UPDATE comments SET status='OFF', approvedby='$admin' WHERE id='$searchQueryParameter' ";
  $execute=$connectingDB->query($sql);
  if($execute){
    $_SESSION["SuccessMessage"]= "Comment dis-approved successfully.";
    redirect_to("comments.php");
  }else{
    $_SESSION["ErrorMessage"]= "Something went wrong! Try again.";
    redirect_to("comments.php");
  }
}
 ?>
