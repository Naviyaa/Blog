<?php require_once("includes/db.php") ?>
<?php require_once("includes/functions.php") ?>
<?php require_once("includes/sessions.php") ?>
<?php
  $_SESSION["trackingURL"]=$_SERVER["PHP_SELF"];
  //echo $_SESSION["trackingURL"]
   login_confirm();
?>

<?php
if(isset($_POST["submit"])){
  $postTitle=$_POST["postTitle"];
  $category=$_POST["category"];
  $image=$_FILES["image"]["name"];  //storing the image name in table and the actual image in uploads folder
  $target="uploads/".basename($_FILES["image"]["name"]);
  $postText=$_POST["postDescription"];
  $admin=$_SESSION["UserName"];
  date_default_timezone_set("Asia/Calcutta");
  $currTime=time();
  $dateTime=strftime("%B-%d-%Y %H:%M:%S",$currTime);

  if(empty($postTitle)){
    $_SESSION["ErrorMessage"] = "All the fields must be filled.";
    redirect_to("addNewPost.php");
  }elseif (strlen($postTitle)<3) {
    $_SESSION["ErrorMessage"] = "Title should be greater than 4 characters.";
    redirect_to("addNewPost.php");
  }elseif (strlen($postText)>9999) {
    $_SESSION["ErrorMessage"] = "Description should be less than 10000 characters.";
    redirect_to("addNewPost.php");
  }else {
    //entering data into database
    global $connectingDB;
    $sql="INSERT INTO posts(datetime,title,category,author,image,post)";
    $sql.=" VALUES (:dateTime,:postTitle,:categoryName, :adminName,:imageName,:postDescription) ";
    $stmt=$connectingDB->prepare($sql);
    $stmt->bindValue(':dateTime',$dateTime);
    $stmt->bindValue(':postTitle',$postTitle);
    $stmt->bindValue(':categoryName',$category);
    $stmt->bindValue(':adminName',$admin);
    $stmt->bindValue(':imageName',$image);
    $stmt->bindValue(':postDescription',$postText);
    $execute=$stmt->execute();

    move_uploaded_file($_FILES["image"]["tmp_name"],$target);

    if($execute){
      $_SESSION["SuccessMessage"]="Post Added successfully.";
      redirect_to("addNewPost.php");
    }
    else{
      $_SESSION["ErrorMessage"]="Something went wrong! Try Again.";
      redirect_to("addNewPost.php");
    }
  }
}
 ?>

<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <title>adding New Posts</title>
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/bb2e1a2580.js" crossorigin="anonymous"></script>
  </head>

  <body>

    <!-- Navbar -->
    <div style="height: 10px; background: #27aae1;"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a href="#" class="navbar-brand">Discussion Forum</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navcollapse">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcollapse">
          <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a href="myProfile.php" class="nav-link"><i class="fas fa-user text-success"></i> My Profile</a>
          </li>
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">Dashboard</a>
          </li>
          <li class="nav-item">
            <a href="posts.php" class="nav-link">Posts</a>
          </li>
          <li class="nav-item">
            <a href="categories.php" class="nav-link">Categories</a>
          </li>
          <li class="nav-item">
            <a href="admins.php" class="nav-link">Manage Admins</a>
          </li>
          <li class="nav-item">
            <a href="comments.php" class="nav-link">Comments</a>
          </li>
          <li class="nav-item">
            <a href="blog.php?page=1" class="nav-link" target="_blank">Live Blog</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto"  style="text-decoration: none;">
          <li class="nav-item">
            <a href="logout.php" class="nav-link text-danger"><i class="fas fa-user-times text-fail"></i> Logout</a>
          </li>
        </ul>
          </div>
      </div>
    </nav>
    <div style="height: 10px; background: #27aae1;"></div>

    <!-- Navbar End -->


<!-- Header -->

<header class="bg-dark text-white py-3 mb-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        <h1><i class="fas fa-edit"></i> Manage Posts</h1>
        </div>
      </div>
    </div>
</header>

<!-- Header End -->


<!-- Main Area -->

<section class="container mb-4 py-2">
  <div class="row">
    <div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
      <?php
        echo error_message();
        echo success_message();
       ?>
      <form class="" action="addNewPost.php" method="post" enctype="multipart/form-data"> <!-- enctype to handle images while sending to table -->
        <div class="card bg-secondary text-light">
          <div class="card-body bg-dark">
            <div class="form-group">
              <label for="postTitle"> <span class="fieldInfo">Post Title: </span></label>
              <input type="text" class="form-control" name="postTitle" id="postTitle" value="" placeholder="Post Title here...">
            </div>
            <div class="form-group">
              <label for="catTitle"> <span class="fieldInfo">Choose Category: </span></label>
              <select class="form-control" name="category" id="catTitle">
                <?php
                  global $connectingDB;
                  $sql="SELECT * FROM category";
                  $stmt=$connectingDB->query($sql);
                  while($dateRows=$stmt->fetch()){
                    $id=$dateRows["id"];
                    $categoryName=$dateRows["title"];
                   ?>
                   <option> <?php echo $categoryName; ?> </option>
                 <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <div class="custom-file">
                <input class="custom-file-input"  type="file" name="image" id="imageSelect">
                <label for="imageSelect" class="custom-file-label">Select Image</label>
              </div>
            </div>
            <div class="form-group">
              <label for="post"> <span class="fieldInfo">Post: </span></label>
              <textarea class="form-control" name="postDescription" id="post" rows="8" cols="80"></textarea>
            </div>
            <div class="row">
              <div class="col-lg-6 mb-2">
                <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
              </div>
              <div class="col-lg-6 mb-2">
                <button type="submit" name="submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Publish</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- Main Area End -->


<!-- Footer -->

<footer class="bg-dark text-white">
  <div class="container">
    <div class="row">
      <div class="col">
      <p class=" lead text-center">Discussion forum project | &copy; 2020</p>
      </div>
    </div>
  </div>
</footer>
<div style="height: 10px; background: #27aae1;"></div>

<!-- Footer End -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>

  </html>
