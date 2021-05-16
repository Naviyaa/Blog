<?php require_once("includes/db.php") ?>
<?php require_once("includes/functions.php") ?>
<?php require_once("includes/sessions.php") ?>
<?php
  $_SESSION["trackingURL"]=$_SERVER["PHP_SELF"];
  //echo $_SESSION["trackingURL"]
   login_confirm();
?>

<?php

  $adminId=$_SESSION["UserID"];
  global $connectingDB;
  $sql = "SELECT * FROM admins WHERE id='$adminId' ";
  $stmt=$connectingDB->query($sql);
  while ($dataRows=$stmt->fetch()) {
    $existingName=$dataRows['aname'];
    $existingUsername=$dataRows['username'];
    $existingBio=$dataRows['abio'];
    $existingImage=$dataRows['aimage'];
    $existingHeadline=$dataRows['aheadline'];
  }

if(isset($_POST["submit"])){
  $aName=$_POST["name"];
  $aHeadline=$_POST["headline"];
  $aBio=$_POST["bio"];
  $image=$_FILES["image"]["name"];  //storing the image name in table and the actual image in uploads folder
  $target="uploads/".basename($_FILES["image"]["name"]);

  if(strlen($aHeadline)>12){
    $_SESSION["ErrorMessage"] = "Headline should be less than 12 characters.";
    redirect_to("myProfile.php");
  }elseif (strlen($aBio)>499) {
    $_SESSION["ErrorMessage"] = "Bio description should be less than 500 characters.";
    redirect_to("myProfile.php");
  }else {
    //entering data into database
    global $connectingDB;
    if(!empty($image)){
      $sql="UPDATE admins SET aname='$aName', aheadline='$aHeadline', aimage='$image', abio='$aBio' WHERE id='$adminId' ";
    }else{
      $sql="UPDATE admins SET aname='$aName', aheadline='$aHeadline', abio='$aBio' WHERE id='$adminId' ";
    }
    $execute=$connectingDB->query($sql);
    move_uploaded_file($_FILES["image"]["tmp_name"],$target);

    if($execute){
      $_SESSION["SuccessMessage"]="Profile updated successfully.";
      redirect_to("myProfile.php");
    }
    else{
      $_SESSION["ErrorMessage"]="Something went wrong! Try Again.";
      redirect_to("myProfile.php");
    }
  }
}
 ?>

<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Profile</title>
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
        <h1><i class="fas fa-user" style="color: #27aee1;"></i> @ <?php echo htmlentities($existingUsername); ?></h1>
        <small><?php echo htmlentities($existingHeadline); ?></small>
        </div>
      </div>
    </div>
</header>

<!-- Header End -->


<!-- Main Area -->

<section class="container mb-4 py-2">
  <div class="row">
    <!-- Left Area -->
    <div class="col-md-3">
      <div class="card">
        <div class="card-header bg-dark text-light">
          <h3 class="ml-1 mt-1"><?php echo htmlentities($existingName); ?></h3>
        </div>
        <div class="card-body">
          <img src="uploads/<?php echo htmlentities($existingImage); ?>" alt="" class="block img-fluid mb-3" height="100" width="220">
          <div class="">
            <?php echo htmlentities($existingBio); ?>
            <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque vel lorem velit.
            Donec posuere risus neque, consequat lobortis velit dictum at.
            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
            Nunc ut interdum enim, non faucibus lacus. Orci varius natoque penatibus et magnis dis parturient montes,
             nascetur ridiculus mus. Suspendisse vulputate orci varius, maximus neque vitae, accumsan risus.
             Pellentesque nec iaculis dolor. Maecenas nec dolor id enim rhoncus commodo ut et ligula. -->
          </div>
        </div>
      </div>
    </div>

    <!--Right Area-->
    <div class="col-md-9" style="min-height: 400px;">
      <?php
        echo error_message();
        echo success_message();
       ?>
      <form class="" action="myProfile.php" method="post" enctype="multipart/form-data"> <!-- enctype to handle images while sending to table -->
        <div class="card bg-dark text-light">
          <div class="card-header bg-secondary text-light">
            <h4 class="mt-1">Edit Profile</h4>
          </div>
          <div class="card-body">
            <div class="form-group">
              <input type="text" class="form-control" name="name" id="name" value="" placeholder="Your Name">
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="headline" id="headline" value="" placeholder="Headline">
              <small class="text-muted">Add a professional headline like 'Engineer' at 'XYZ' or 'Architect'. </small>
              <span class="text-danger">Not more than 12 characters.</span>
            </div>
            <div class="form-group">
              <textarea class="form-control" name="bio" id="post" rows="8" cols="80" placeholder="About you....your bio"></textarea>
            </div>
            <div class="form-group">
              <div class="custom-file">
                <input class="custom-file-input"  type="file" name="image" id="imageSelect">
                <label for="imageSelect" class="custom-file-label">Select Image</label>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 mb-2">
                <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
              </div>
              <div class="col-lg-6 mb-2">
                <button type="submit" name="submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Save</button>
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
