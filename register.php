<?php
    session_start();
    require_once 'connection.php';
    if(isset($_SESSION['user_login'])){
        header('location: user.php');


    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="img/logo.ico">
    <title>Karamail Shop</title>
   <!-- CSS -->
   <link rel="stylesheet" href="css/style.css" />
    <!-- CSS only -->
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="js/bootstrap.min.js"></script>
    <!-- FontAwesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!--CDN AOS-->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- FontAwesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body>
<nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light">
    <div class="container">

      <img src="img/logo.png" width="30" height="30" alt="">
      <a class="navbar-brand p-2" href="#">KARAMAILSHOP</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse d-lg-block" id="navbarNavDropdown">
        <ul class="navbar-nav bg-light" style="border-radius: 15px;">
          <li class="nav-item  mx-3 active">
            <a class="nav-link" href="index.php">หน้าแรก <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item  mx-3">
            <a class="nav-link" href="#">เติมเงิน</a>
          </li>
          <li class="nav-item  mx-3">
            <a class="nav-link" href="shop.php">ร้านค้า</a>
          </li>
          <li class="nav-item  mx-3">
            <a class="nav-link" href="login.php">เข้าสู่ระบบ</a>
          </li>
          <li class="nav-register  nav-item mx-3 dropdown">
          <a class="nav-link" href="register.php">สมัครสมาชิก</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

    <!--Register Zone-->

    <div class="container text-light">
        <h3 class="mt-4">สมัครสมาชิก</h3>
        <hr>
        <form action="register_db.php" method="post">
            <?php 
                if(isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        ?>
                    </div>
              <?php }?>
              <?php 
                if(isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        ?>
                    </div>
              <?php }?>
              <?php 
                if(isset($_SESSION['warning'])) { ?>
                    <div class="alert alert-warning" role="alert">
                        <?php 
                            echo $_SESSION['warning'];
                            unset($_SESSION['warning']);
                        ?>
                    </div>
              <?php }?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" aria-describedby="username">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" aria-describedby="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="mb-3">
                <label for="confirm password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="c_password">
            </div>
            <button type="submit" name="signup" class="btn btn-primary">สมัครสมาชิก</button>
        </form>
        <hr>
        <p>เป็นสมาชิกแล้ว? คลิ๊กที่นี่<a href="login.php">เข้าสู่ระบบ</a></p>
    </div> <!--.container -->

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
<form>