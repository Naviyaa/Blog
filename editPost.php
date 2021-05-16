<?php require_once("includes/db.php") ?>
<?php require_once("includes/functions.php") ?>
<?php require_once("includes/sessions.php") ?>
<?php login_confirm(); ?>
<?php
$searchQueryParameter=$_GET["id"];
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
    redirect_to("posts.php");
  }elseif (strlen($postTitle)<3) {
    $_SESSION["ErrorMessage"] = "Title should be greater than 4 characters.";
    redirect_to("posts.php");
  }elseif (strlen($postText)>9999) {
    $_SESSION["ErrorMessage"] = "Description should be less than 10000 characters.";
    redirect_to("posts.php");
  }else {
    //updating the data
    global $connectingDB;
    if(!empty($image)){
      $sql="UPDATE posts SET title='$postTitle', category='$category', image='$image', post='$postText' WHERE id='$searchQueryParameter' ";
    }else{
      $sql="UPDATE posts SET title='$postTitle', category='$category', post='$postText' WHERE id='$searchQueryParameter' ";
    }

    $execute=$connectingDB->query($sql);
    move_uploaded_file($_FILES["image"]["tmp_name"],$target);

    if($execute){
      $_SESSION["SuccessMessage"]="Post Updated successfully.";
      redirect_to("posts.php");
    }
    else{
      $_SESSION["ErrorMessage"]="Something went wrong! Try Again.";
      redirect_to("posts.php");
    }
  }
}
 ?>

<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Edit Post</title>
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
        <h1><i class="fas fa-edit"></i> Edit Post</h1>
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
       <?php
          //getting all the previous data according to the id
          global $connectingDB;
          $sql="SELECT * FROM posts WHERE id='$searchQueryParameter' ";
          $stmt = $connectingDB->query($sql);
          while ($dataRows=$stmt->fetch()) {
            $titleToBeUpdated = $dataRows["title"];
            $categoryToBeUpdated=$dataRows["category"];
            $imageToBeUpdated=$dataRows["image"];
            $postToBeUpdated= $dataRows["post"];
          }
        ?>
      <form class="" action="editPost.php?id=<?php echo $searchQueryParameter; ?> " method="post" enctype="multipart/form-data"> <!-- enctype to handle images while sending to table -->
        <div class="card bg-secondary text-light">
          <div class="card-body bg-dark">
            <div class="form-group">
              <label for="postTitle"> <span class="fieldInfo">Post Title: </span></label>
              <input type="text" class="form-control" name="postTitle" id="postTitle" value="<?php echo $titleToBeUpdated; ?>" placeholder="Post Title here...">
            </div>
            <div class="form-group">
              <span class="fieldInfo">Existing Category: </span>
              <?php echo $categoryToBeUpdated; ?><br />
              <label for="catTitle"> <span class="fieldInfo">Choose New Category: </span></label>
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
            <div class="form-group mb-1">
              <span class="fieldInfo">Existing Image: </span>
              <img src="uploads/<?php echo $imageToBeUpdated; ?>" width="150" height="70" class="mb-1"/>
              <div class="custom-file">
                <input class="custom-file-input"  type="file" name="image" id="imageSelect">
                <label for="imageSelect" class="custom-file-label">Select Image</label>
              </div>
            </div>
            <div class="form-group">
              <label for="post"> <span class="fieldInfo">Post: </span></label>
              <textarea class="form-control" name="postDescription" id="post" rows="8" cols="80">
                <?php echo $postToBeUpdated; ?>
              </textarea>
            </div>
            <div class="row">
              <div class="col-lg-6 mb-2">
                <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
              </div>
              <div class="col-lg-6 mb-2">
                <button type="submit" name="submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Update</button>
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
