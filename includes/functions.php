<?php require_once("includes/db.php") ?>

<?php

function redirect_to($new_location){
  header("Location:".$new_location);
  exit;
}

function userNameExistanceCheck($username){
  global $connectingDB;
  $sql="SELECT username FROM admins WHERE username='$username' ";
  $stmt=$connectingDB->prepare($sql);
  $stmt->bindValue(':username',$username);
  $stmt->execute();
  $result = $stmt->rowcount();
  if($result==1){
    return true;
  } else{
    return false;
  }
}

function login_attempt($username,$password){
  global $connectingDB;
  $sql="SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
  $stmt=$connectingDB->prepare($sql);
  $stmt->bindValue(':userName',$username);
  $stmt->bindValue(':passWord',$password);
  $stmt->execute();
  $result=$stmt->rowcount();
  if($result==1){
    $fetch_account = $stmt->fetch();
    return $fetch_account;
  }else{
    return null;
  }
}

function login_confirm(){
  if(isset($_SESSION['UserID'])){
    return true;
  }else{
    $_SESSION["ErrorMessage"]= "Login Required";
    redirect_to("login.php");
  }
}

function total_admins(){
    global $connectingDB;
    $sql="SELECT COUNT(*) FROM admins";
    $stmt=$connectingDB->query($sql);
    $totalRows=$stmt->fetch();
    $total=array_shift($totalRows);
    echo $total;
}

//dashboard
function total_posts(){
  global $connectingDB;
  $sql="SELECT COUNT(*) FROM posts";
  $stmt=$connectingDB->query($sql);
  $totalRows=$stmt->fetch();
  $total=array_shift($totalRows);
  echo $total;
}

function total_categories(){
    global $connectingDB;
    $sql="SELECT COUNT(*) FROM category";
    $stmt=$connectingDB->query($sql);
    $totalRows=$stmt->fetch();
    $total=array_shift($totalRows);
    echo $total;
}

function total_comments(){
    global $connectingDB;
    $sql="SELECT COUNT(*) FROM comments";
    $stmt=$connectingDB->query($sql);
    $totalRows=$stmt->fetch();
    $total=array_shift($totalRows);
    echo $total;
}

function total_approved_comments($postId){
  global $connectingDB;
  $sqlApprove="SELECT COUNT(*) FROM comments WHERE post_id='$postId' AND status='ON' ";
  $stmtApprove=$connectingDB->query($sqlApprove);
  $totalApproveRows=$stmtApprove->fetch();
  $totalApprove=array_shift($totalApproveRows);
  echo $totalApprove;
}
function total_disapproved_comments($postId){
  global $connectingDB;
  $sqlDisapprove="SELECT COUNT(*) FROM comments WHERE post_id='$postId' AND status='OFF' ";
  $stmtDisapprove=$connectingDB->query($sqlDisapprove);
  $totalDisapproveRows=$stmtDisapprove->fetch();
  $totalDisapprove=array_shift($totalDisapproveRows);
  echo $totalDisapprove;
}

 ?>
