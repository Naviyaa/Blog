<?php require_once("includes/db.php") ?>
<?php require_once("includes/functions.php") ?>
<?php require_once("includes/sessions.php") ?>

<?php
  if(isset($_SESSION["UserID"])){
    redirect_to("dashboard.php");
  }

  if(isset($_POST["submit"])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    if(empty($username)|| empty($password)){
      $_SESSION["ErrorMessage"]="All the fields must be filled.";
      redirect_to("login.php");
    }else{
      $found_account = login_attempt($username,$password);
      if($found_account){
        $_SESSION["UserID"]=$found_account['id'] ;
        $_SESSION["UserName"]=$found_account['username'] ;
        $_SESSION["AdminName"]=$found_account['aname'] ;
        $_SESSION["SuccessMessage"]="Welcome Back ".$_SESSION["UserName"];
        if(isset($_SESSION["trackingURL"])){
          redirect_to($_SESSION["trackingURL"]);
        }else{
        redirect_to("dashboard.php");
        }
      }else{
        $_SESSION["ErrorMessage"]="Incorrect username/password.";
        redirect_to("login.php");
      }
    }
  }
 ?>

<!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Login Page - Admins</title>
    <link rel="stylesheet" href="css/style1.css">
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
        <h1></h1>
        </div>
      </div>
    </div>
</header>

<!-- Header End -->

<!-- Main Area -->

<br><br><br>
<section class="container py-3 mb-4">
  <div class="row">
    <div class="offset-sm-3 col-sm-6" style="min-height: 400px;">
      <?php
        echo error_message();
        echo success_message();
       ?>
      <div class="card bg-secondary text-light">
        <div class="card-header">
          <h4>Login Here</h4>
        </div>
        <div class="card-body bg-dark">
          <form class="" action="login.php" method="post">
            <div class="form-group">
              <label for="username" class="text-warning">Username: </label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" name="username" id="username" value="">
              </div>
              <label for="password" class="text-warning">Password: </label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" class="form-control" name="password" id="password" value="">
              </div>
              <input type="submit" name="submit" value="Login" class="btn btn-info btn-block  mt-2">
            </div>
          </form>
        </div>
      </div>
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
