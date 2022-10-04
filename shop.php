<?php
session_start();
require_once 'connection.php';
if (!isset($_SESSION['user_login'])) {
  $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
  header('location: login.php');
}
if (isset($_SESSION['admin_login'])) {
  header('location: admin.php');
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
</head>

<body class="bg-image">

<nav class="navbar navbar-expand-lg sticky-top navbar-light bg-light">
    <div class="container">

      <img src="img/logo.png" width="30" height="30" alt="">
      <a class="navbar-brand p-2" href="#">KARAMAILSHOP</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse d-lg-block" id="navbarNavDropdown">
        <?php
        if (isset($_SESSION['user_login'])) {
          $users_id = $_SESSION['user_login'];
          $statement = $db->query("SELECT * FROM users WHERE user_id = $users_id");
          $statement->execute();
          $row = $statement->fetch(PDO::FETCH_ASSOC);
        }
        ?>
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
          <li class="nav-register  nav-item mx-3 dropdown">
            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa-sharp fa-solid fa-user" aria-hidden="true"></i>
              <?php echo $row['username'] ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="user-info.php">ข้อมูลส่วนตัว</a>
              <a class="dropdown-item" href="#">คงเหลือ <?php echo $row['user_point'] ?><i class="mx-2 my-1 fa-sharp fa-solid fa-coins"></i></a>
              <a class="dropdown-item text-danger" href="logout.php">ออกจากระบบ</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5 bg-light" style="border-radius: 10px;">
    <div id="cards" class="row">
      <div class="mt-2">
        <div class="card" style="width: 18rem;">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="footer">
    <p></i>Copyright © 2022 Karamail Shop - All Right Reserved.</p>
  </div>
  <!-- Js-->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="script.js"></script>
  <script>
    AOS.init();
  </script>

</body>

</html>

<script>
  var cards = document.getElementById('cards');
  cards.innerHTML = "Loading...";
  var requestOptions = {
    method: 'GET',
    redirect: 'follow'
  };

  fetch("http://localhost/karamailshop/shopapi/robux_api.php", requestOptions)
    .then(response => response.text())
    .then(result => {
      cards.innerHTML = '';
      var jsonOBJ = JSON.parse(result);
      for (let category of jsonOBJ) {
        const card = `<div class="d-flex justify-content-center text-center col-xs-3 col-sm-6 col-lg-3 col-md-4  mb-4 my-5" style="padding: 10px;">
        <div class="card">
          <div class="card-body">
            <img src=` + category.rb_img + ` class="card-img-top bg-white" style="border-radius: 10px;" alt=` + category.rb_name + `>
            <h5 class="card-title mt-3 text-dark"> จำนวน ` + category.rb_name + `</h5>
            <button class="btn btn-light" disabled style="color: red;  margin-left: 0px;"> ราคา ` + category.rb_price + ` POINT</button>
            <a href="rb_shop.php?id=` + category.id + `" class="btn mt-2 btn-danger" style=";margin-left: 5px;">สั่งซื้อสินค้า</a>
          </div>
        </div>
      </div>`;
        cards.insertAdjacentHTML('beforeend', card);
      }

    })
    .catch(error => console.log('error', error))
</script>