<?php require_once("includes/db.php") ?>
<?php require_once("includes/functions.php") ?>
<?php require_once("includes/sessions.php") ?>
<?php
$_SESSION["trackingURL"]=$_SERVER["PHP_SELF"];
 login_confirm();
?>

<?php
if(isset($_POST["submit"])){
  $username=$_POST["username"];
  $name=$_POST["name"];
  $password=$_POST["password"];
  $confirmPassword=$_POST["confirmPassword"];
  $admin=$_SESSION["UserName"];
  date_default_timezone_set("Asia/Calcutta");
  $currTime=time();
  $dateTime=strftime("%B-%d-%Y %H:%M:%S",$currTime);

  if(empty($username) || empty($password) || empty($confirmPassword)){
    $_SESSION["ErrorMessage"] = "All fields must be filled.";
    redirect_to("admins.php");
  }elseif (strlen($password)<5) {
    $_SESSION["ErrorMessage"] = "Password should be greater than 4 characters.";
    redirect_to("admins.php");
  }elseif (strlen($password!==$confirmPassword)) {
    $_SESSION["ErrorMessage"] = "Passwords do not match.";
    redirect_to("admins.php");
  }elseif (userNameExistanceCheck($username)) {
    $_SESSION["ErrorMessage"] = "Username Exists.";
    redirect_to("admins.php");
  }else {
    //entering data into database
    $sql="INSERT INTO admins(datetime,username,password,aname,addedby)";
    $sql.=" VALUES (:dateTime, :username, :password,:aname,:adminName) ";
    $stmt=$connectingDB->prepare($sql);
    $stmt->bindValue(':dateTime',$dateTime);
    $stmt->bindValue(':username',$username);
    $stmt->bindValue(':password',$password);
    $stmt->bindValue(':aname',$name);
    $stmt->bindValue(':adminName',$admin);
    $execute=$stmt->execute();

    if($execute){
      $_SESSION["SuccessMessage"]="New Admin Added successfully.";
      redirect_to("admins.php");
    }
    else{
      $_SESSION["ErrorMessage"]="Something went wrong! Try Again.";
      redirect_to("admins.php");
    }
  }
}
 ?>

<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Admin Page</title>
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
        <h1><i class="fas fa-user" style="color: #27aae1;"></i> Manage Admins</h1>
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
      <form class="" action="admins.php" method="post">
        <div class="card bg-secondary text-light">
          <div class="card-header">
            <h1>Add New Admin</h1>
          </div>
          <div class="card-body bg-dark">
            <div class="form-group">
              <label for="username"> <span class="fieldInfo">Username: </span></label>
              <input type="text" class="form-control" name="username" id="username" value="">
            </div>
            <div class="form-group">
              <label for="name"> <span class="fieldInfo">Name: </span></label>
              <input type="text" class="form-control" name="name" id="name" value="">
              <small class="text-muted">Optional</small>
            </div>
            <div class="form-group">
              <label for="password"> <span class="fieldInfo">Password: </span></label>
              <input type="password" class="form-control" name="password" id="password" value="">
            </div>
            <div class="form-group">
              <label for="confirmPassword"> <span class="fieldInfo">Confirm Password: </span></label>
              <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" value="">
            </div>
            <div class="row">
              <div class="col-lg-6 mb-2">
                <a href="dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
              </div>
              <div class="col-lg-6 mb-2">
                <button type="submit" name="submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Submit</button>
              </div>
            </div>
          </div>
        </div>
      </form>

      <h2 class="mt-2">Existing Admins</h2>
      <table class="table  table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th>No. </th>
            <th>Date & Time</th>
            <th>Admin Username</th>
            <th>Admin Name</th>
            <th>Added By</th>
            <th>Action</th>
          </tr>
        </thead>

        <?php
          global $connectingDB;
          $sql="SELECT * FROM admins ORDER BY id desc";
          $execute=$connectingDB->query($sql);
          $sr_no=0;
          while($dataRows=$execute->fetch()){
            $adminId=$dataRows['id'];
            $dateTime=$dataRows['datetime'];
            $adminUsername=$dataRows['username'];
            $adminName=$dataRows['aname'];
            $addedBy=$dataRows['addedby'];
            $sr_no++;

         ?>

        <tbody class="tbody-light">
          <tr>
            <td><?php echo htmlentities($sr_no); ?></td>
            <td><?php echo htmlentities($dateTime); ?></td>
            <td><?php echo htmlentities($adminUsername); ?></td>
            <td><?php echo htmlentities($adminName); ?></td>
            <td><?php echo htmlentities($addedBy); ?></td>
            <td><a href="deleteAdmin.php?id=<?php echo $adminId ?>" class="btn btn-danger">Delete</a></td>
          </tr>
        </tbody>
      <?php  } ?>
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
