<?php require_once("includes/db.php") ?>
<?php require_once("includes/functions.php") ?>
<?php require_once("includes/sessions.php") ?>

<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/bb2e1a2580.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style1.css">
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
            <a href="blog.php?page=1" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">About Us</a>
          </li>
          <li class="nav-item">
            <a href="blog.php" class="nav-link">Info</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Contact Us</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">Features</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto"  style="text-decoration: none;">
          <form class="form-inline d-none d-sm-block" action="blog.php">
            <div class="form-group">
              <input class="form-control mr-2" type="text" name="search" placeholder="Search here...">
              <button type="submit" name="searchButton" class="btn btn-primary">Go</button>
            </div>
          </form>
        </ul>
          </div>
      </div>
    </nav>
    <div style="height: 10px; background: #27aae1;"></div>

    <!-- Navbar End -->


<!-- CONTENT -->

<div class="container">
  <div class="row mt-4 mb-3">
    <!-- MAIN AREA -->
    <div class="col-sm-8">
      <h1>Posts On This Site</h1>
      <h1 class="lead ">Display of all the posts on this site, and navigation to the entire post for discussion.</h1>
      <?php
        echo error_message();
        echo success_message();
       ?>
      <?php
        global $connectingDB;
        if(isset($_GET["searchButton"])){
          $search = $_GET["search"];
          $sql="SELECT * FROM posts WHERE datetime LIKE :search OR
          title LIKE :search OR
          category LIKE :search OR
          post LIKE :search
          ";
          $stmt = $connectingDB->prepare($sql);
          $stmt->bindValue(':search','%'.$search.'%');
          $stmt->execute();
        }
        elseif (isset($_GET['page'])) {
          $page=$_GET['page'];
          if($page==0 || $page<1){
            $postsFrom=0;
          }else{
          $postsFrom=($page*4)-4;
          }
          $sql="SELECT * FROM posts ORDER BY id desc LIMIT $postsFrom,4";
          $stmt=$connectingDB->query($sql);
        }
        elseif (isset($_GET['category'])) {
          $categoryFromURL=$_GET['category'];
          $sql="SELECT * FROM posts WHERE category='$categoryFromURL' ORDER BY id desc";
          $stmt=$connectingDB->query($sql);
        }
        else{
        $sql="SELECT * FROM posts ORDER BY id DESC LIMIT 0,3";
        $stmt = $connectingDB->query($sql);
        }
        while ($dataRows = $stmt->fetch()) {
          $postId=$dataRows["id"];
          $dateTime=$dataRows["datetime"];
          $postTitle=$dataRows["title"];
          $category=$dataRows["category"];
          $admin=$dataRows["author"];
          $image=$dataRows["image"];
          $postDescription=$dataRows["post"];

       ?>
       <div class="card mb-2">
         <img src="uploads/<?php echo htmlentities($image); ?>" class="img-fluid card-img-top" style="max-height: 450px;"/>
         <div class="card-body">
           <h4 class="card-title"><?php echo htmlentities($postTitle); ?></h4>
           <small class="text-muted">Category: <span class="text-dark"><?php echo htmlentities($category); ?></span>; Written by: <span class="text-dark"><?php echo htmlentities($admin); ?></span>; On: <span class="text-dark"><?php echo htmlentities($dateTime); ?></span>;</small>
           <span class="badge badge-dark text-light" style="float: right;">Comments: <?php total_approved_comments($postId); ?></span>
           <hr>
           <p class="card-text">
             <?php
             if(strlen($postDescription)>70){
               $postDescription=substr($postDescription,0,70)."...";
             }
            echo htmlentities($postDescription); ?>
          </p>
           <a href="fullPost.php?id=<?php echo $postId; ?>" style="float: right;">
             <span class="btn btn-info">Read More &gt;&gt; </span>
           </a>
         </div>
       </div>
     <?php } ?>
     <br>
     <!--Pagination-->
     <nav>
       <ul class="pagination pagination-lg">

         <!-- Backward Button -->
         <?php  if(isset($page) ){
           if($page>1){
           ?>
         <li class="page-item">
          <a href="blog.php?page=<?php echo $page-1; ?>" class="page-link">&laquo;</a>
        </li>
      <?php }} ?>

      <!-- Page buttons -->
         <?php
          global $connectingDB;
          $sql = "SELECT COUNT(*) FROM posts";
          $stmt=$connectingDB->query($sql);
          $rowPage=$stmt->fetch();
          $totalPosts=array_shift($rowPage);
          //echo $totalPosts."<br>";
          $postPage=$totalPosts/4;
          $postPage=ceil($postPage);
          //echo $postPage;
          for($i=1;$i<=$postPage;$i++){
            if(isset($page)){
              if($i==$page){
          ?>
          <li class="page-item active">
           <a href="blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
         </li>
       <?php } else{    ?>
          <li class="page-item">
           <a href="blog.php?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
         </li>
       <?php }}} ?>

       <!-- Forward Button-->

       <?php  if(isset($page) && !empty($page)){
         if(($page+1)<=$postPage){
         ?>
       <li class="page-item">
        <a href="blog.php?page=<?php echo $page+1; ?>" class="page-link">&raquo;</a>
      </li>
    <?php }} ?>



       </ul>
     </nav>
    </div>

    <!--MAIN AREA END -->

    <!-- SIDE AREA -->
    <div class="col-sm-4" style="background-color: #27aae1; in-height: 40px;">
      <div class="card mt-4">
        <div class="card-body">
          <img src="images/bm.jpg" alt="ad1" class="d-block img-fluid mb-3">
          <div class="text-center">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam pretium metus orci, id pretium velit sollicitudin a.
             Cras luctus pharetra mollis. Fusce turpis dolor, hendrerit non quam a, imperdiet vestibulum tellus.
             Aenean in est quis urna tincidunt vulputate. Aliquam quis magna euismod, condimentum enim id, hendrerit neque.
          </div>
        </div>
      </div>
      <br>
      <div class="card">
        <div class="card-header bg-dark text-light">
          <h2 class="lead">Sign Up!</h2>
        </div>
        <div class="card-body">
          <button type="button" name="button" class="btn btn-success btn-block text-white text-center">Join the Forum.</button>
          <button type="button" name="button" class="btn btn-warning btn-block text-white text-center">Login.</button>
          <div class="input-group my-3">
            <input type="email" name="" value="" class="form-control" placeholder="Enter your mail here...">
            <div class="input-group-append">
              <button type="button" name="button" class="btn btn-primary text-white text-center btn-sm">Subscribe</button>
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="card">
        <div class="card-header bg-dark text-light">
          <h2 class="lead">Categories</h2>
        </div>
        <div class="card-body">
          <?php
            global $connectingDB;
            $sql="SELECT * FROM category ORDER BY id desc";
            $stmt=$connectingDB->query($sql);
            while($dataRows=$stmt->fetch()){
              $catId=$dataRows['id'];
              $cat=$dataRows['title'];

           ?>
           <a href="blog.php?category=<?php echo $cat; ?>"><span class="heading"><?php echo $cat; ?></span></a><br />
         <?php } ?>
        </div>
      </div>
      <br>
      <div class="card">
        <div class="card-header bg-dark text-white">
          <h2 class="lead">Recent Posts</h2>
        </div>
        <div class="card-body">
          <?php
            global $connectingDB;
            $sql="SELECT *  FROM posts ORDER BY id desc LIMIT 0,3";
            $stmt=$connectingDB->query($sql);
            while($dataRows=$stmt->fetch()){
              $pId=$dataRows['id'];
              $pTitle=$dataRows['title'];
              $pDatetime=$dataRows['datetime'];
              $pImage=$dataRows['image'];

           ?>
           <div class="media">
             <img src="uploads/<?php echo htmlentities($pImage); ?>" alt="" class="d-block img-fluid align-self-start mb-2" width="90" height="90"/>
             <div class="media-body ml-2">
              <a href="fullPost.php?id=<?php echo htmlentities($pId); ?>" target="_blank"><h6 class="lead"><?php  echo htmlentities($pTitle); ?></h6></a>
               <p class="small"><?php echo htmlentities($pDatetime); ?></p>
             </div>
           </div>
           <hr />
         <?php } ?>
        </div>
      </div>
    </div>
    <!-- SIDE AREA END -->
  </div>
</div>

<!-- CONTENT End -->


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
