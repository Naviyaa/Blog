<?php require_once("includes/db.php") ?>
<?php require_once("includes/functions.php") ?>
<?php require_once("includes/sessions.php") ?>

<?php
$_SESSION["trackingURL"]=$_SERVER["PHP_SELF"];
 login_confirm();
 ?>

<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <title>All Posts</title>
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
        <h1><i class="fas fa-blog" style="color: #27aae1;"></i> Blog Posts</h1>
        </div>
        <div class="col-lg-3">
          <a href="addNewPost.php" class="btn btn-primary btn-block mb-3">
            <i class="fas fa-edit"></i> Add New Post
          </a>
        </div>
        <div class="col-lg-3">
          <a href="categories.php" class="btn btn-info btn-block mb-3">
            <i class="fas fa-folder-plus"></i> Add New Category
          </a>
        </div>
        <div class="col-lg-3">
          <a href="admins.php" class="btn btn-warning btn-block mb-3">
            <i class="fas fa-user-plus"></i> Add New Admin
          </a>
        </div>
        <div class="col-lg-3">
          <a href="comments.php" class="btn btn-success btn-block mb-3">
            <i class="fas fa-check"></i> Approve Posts
          </a>
        </div>
      </div>
    </div>
</header>

<!-- Header End -->


<!-- Main Area -->

<section class="container py-2 mb-4">
  <div class="row">
    <div class="col-lg-12">
      <?php
        echo error_message();
        echo success_message();
       ?>
      <table class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
          <th>#</th>
          <th>Title</th>
          <th>Category</th>
          <th>Date & Time</th>
          <th>Author</th>
          <th>Banner</th>
          <th>Comments</th>
          <th>Action</th>
          <th>Live Preview</th>
        </tr>
      </thead>
        <?php
          global $connectingDB;
          $sql="SELECT * FROM posts";
          $sr=0;
          $stmt=$connectingDB->query($sql);
          while($dataRows=$stmt->fetch()){
            $id = $dataRows["id"];
            $postTitle = $dataRows["title"];
            $category = $dataRows["category"];
            $dateTime = $dataRows["datetime"];
            $admin = $dataRows["author"];
            $postText = $dataRows["post"];
            $image = $dataRows["image"];
            $sr++;
         ?>
         <tbody>
         <tr>
           <td><?php echo $sr ?></td>
           <td>
             <?php
             if(strlen($postTitle)>10){$postTitle=substr($postTitle,0,7)."...";}
             echo $postTitle; ?>
           </td>
           <td>
             <?php
               if(strlen($category)>7){$category=substr($category,0,6)."...";}
              echo $category; ?>
          </td>
           <td>
             <?php
             if(strlen($dateTime)>12){$dateTime=substr($dateTime,0,12)."...";}
             echo $dateTime; ?>
           </td>
           <td>
             <?php
             if(strlen($admin)>6){$admin=substr($admin,0,6)."...";}
             echo $admin; ?>
           </td>
           <td><img src="uploads/<?php  echo $image; ?>" width="150" height="60"></td>
           <td>
             <span class="badge badge-success mx-2">
               <?php total_approved_comments($id); ?>
             </span>
             <span class="badge badge-danger">
               <?php total_disapproved_comments($id);  ?>
             </span>
           </td>
           <td>
             <a href="editPost.php?id=<?php echo $id; ?>"><span class="btn btn-warning">Edit</span></a>
             <a href="deletePost.php?id=<?php echo $id; ?>"><span class="btn btn-danger">Delete</span></a>
           </td>
           <td>
             <a href="fullPost.php?id=<?php echo $id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>
           </td>
         </tr>
       </tbody>
       <?php } ?>
      </table>
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
