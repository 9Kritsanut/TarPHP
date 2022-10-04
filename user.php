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
  <!--
  <nav class="navbar navbar-expand-lg navbar-static-top py-md-2 aos-init aos-animate" data-aos="">
    <div class="container">
      <div class="nav-top-user">
        <a class="nav-top-user-profile" href="index.php">
          <img src="img/logo.png" alt="KaramailShop.com" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      </div>
      <div class="nav-top-contact" id="navbarsMain">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item mx-1 dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="login.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
              หมวดหมู่สินค้า <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-item">
                <a href="shop.php">เติมโรบัค <i class="mx-2 p-1 fas fa-angle-double-right"></i></a>
              </li>
              <li class="dropdown-item">
                <a href="gamepass.php">กดผลและเกมพาส
                  <i class="mx-2 p-1 fas fa-angle-double-right"></i></a>
              </li>
            </ul>
          </li>
          <li class="nav-item mx-1">
            <a class="nav-link" href="#"><i class="fa-sharp fa-solid fa-coins"></i> เติมเงิน</a>
          </li>
          <li class="nav-register dropdown">
            <a class="nav-link dropdown-toggle text-light" data-toggle="dropdown" href="shop.html"><i class="fa-sharp fa-solid fa-user" aria-hidden="true"></i>
               echo $row['username'] ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-item">
                <a href="user-info.php">ข้อมูลส่วนตัว</a>
              </li>
              <li class="dropdown-item">
                <a href="#" class="mx-auto">คงเหลือ  echo $row['user_point'] ?><i class="mx-2 my-1 fa-sharp fa-solid fa-coins"></i></a>
              </li>
              <li class="dropdown-item">
                <a href="logout.php" class="btn btn-danger">Logout <i class="mx-2 p-1 fas fa-angle-double-right"></i></a>
              </li>
            </ul>
          </li>
          <li class="toggle"><a href=""><i class="fa-solid fa-bars-sort"></i></a></li>
        </ul>
        <ul class="navbar-nav ml-auto navbar-member"></ul>
      </div>
    </div>
  </nav>
-->

<div class="header container">
    <div class="row">
    <div class="karamailimg text-center d-none d-sm-block" style="margin-left: 15rem;">
        <img src="https://media.discordapp.net/attachments/775979889525784587/1024579330728284210/0E99D9D9-C096-4836-8C37-57EA229F1CD4_2.png?width=422&height=676" alt="">
      </div>
      <div class="home-text-main text-align-center pt-2 col-xl-12 col-6">
        <h2 class="xbox aos-init aos-animate" data-aos="fade" data-char="KARAMAIL SHOP">
          KARAMAIL SHOP
        </h2>
        <h1 class="topup-text-st aos-init aos-animate" data-aos="fade">TOPUP ROBUX & GAMEPASS </h1>
        <h6 class="topup-text-rd text-light aos-init aos-animate" data-aos="fade">ยืนหนึ่ง! เราให้บริการเติมโรบัคและเกมพาสแมพต่างๆภายในเกมโรบล็อก</h6>
      </div>
    </div>
  </div>
  <!--
    <div id="carouselExampleDark" class="carousel carousel-dark" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="10000">
          <img src="img/karamailbg.png" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>First slide label</h5>
            <p>Some representative placeholder content for the first slide.</p>
          </div>
        </div>
        <div class="carousel-item" data-bs-interval="2000">
          <img src="img/karamailbg.png" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Second slide label</h5>
            <p>Some representative placeholder content for the second slide.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="img/karamailbg.png" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <h5>Third slide label</h5>
            <p>Some representative placeholder content for the third slide.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>-->


  <section class="home-recommend mt-xl-5 mt-4">
    <div class="container">
      <div class="recommend-category">
        <div class="row mb-4 mb-md-2">
          <div class="col-12 col-md-8">
            <h1 class="page-text-title-index aos-init aos-animate" data-aos="fade">
              <i class="fa-solid fa-crown"></i> T O P D E A L S
            </h1>
            <h5 class="page-text-color aos-init aos-animate" data-aos="fade" data-aos-delay="100">
              สินค้าแนะนำ
            </h5>
          </div>
          <div class="text-right col-2 mt-4"><a href="#" class="button-19">ดูเพิ่มเติม</a></div>
        </div>
        <div class="row">
          <div class="category-all col-12 col-lg-6 mb-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="0">
            <a href="#" class="category-panel">
              <div class="category-image">
                <img src="img/karamailbg.png" class="img-fluid" />
              </div>
            </a>
          </div>
          <div class=" col-12 col-lg-6 mb-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="50">
            <a href="#" class="category-panel">
              <div class="category-image">
                <img src="img/karamailbg.png" class="img-fluid" />
              </div>
            </a>
          </div>
          <div class="col-12 col-lg-6 mb-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            <a href="#" class="category-panel">
              <div class="category-image">
                <img src="img/karamailbg.png" class="img-fluid" />
              </div>
            </a>
          </div>
          <div class="col-12 col-lg-6 mb-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            <a href="#" class="category-panel">
              <div class="category-image">
                <img src="img/karamailbg.png" class="img-fluid" />
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="home-recommend mt-xl-5 mt-4">
      <div class="container">
        <div class="recommend-category">
          <div class="row mb-4 mb-md-2">
            <div class="col-12 col-md-8">
              <h1 class="page-text-title-index aos-init aos-animate" data-aos="fade">
                TOPUP ROBUX
              </h1>
              <h5 class="page-text-color aos-init aos-animate" data-aos="fade" data-aos-delay="100">
                เติมโรบัค
              </h5>
            </div>
            <div class="text-right col-2"><a href="#" class="button-19">ดูเพิ่มเติม</a></div>
          </div>
          <div class="row" id="cards">
            <div class="category-all col-12 col-lg-3 mb-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="0">
              <a href="#" class="category-panel">
                <div class="category-image">
                  <img src="img/karamailbg.png" class="img-fluid" />
                </div>
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>


  <div class="spacer" style="background-image: url('svg/layer1.svg');">
    <section>
      <footer class="mt-5">
        <div class="container">
          <div class="row">
            <div class="d-md-none d-xl-block col-md-4 col-xl-3 col-12">
              <h5 class="text-dark"><img src="img/logo.png" alt="Karamail Shop เว็บเติมโรบัคที่ดีที่สุด ราคาสุดคุ้ม มีผู้ใช้บริการมากกว่า 10,000 ครั้ง และมีความน่าเชื่อถือมากที่สุด
                โดยเปิดให้บริการมาแล้วนานกว่า 3 ปี บริการดี บริการไว ปลอดภัย 100%" style="height: 50px;"></h5>
              <p class="text-dark mt-4" style="font-size: 12px;">
                Karamail Shop เว็บเติมโรบัคที่ดีที่สุด ราคาสุดคุ้ม มีผู้ใช้บริการมากกว่า 10,000 ครั้ง และมีความน่าเชื่อถือมากที่สุด
                โดยเปิดให้บริการมาแล้วนานกว่า 3 ปี สโลแกนของร้าน
                บริการดี บริการไว ปลอดภัย 100%
              </p>
            </div>
            <div class="col-md-4 col-xl-3 col-6">
              <h5 class="text-dark">ช่วยเหลือ</h5>
              <div class="custom-line"></div>
              <div class="mt-3"><a href="login.php" class="">เข้าสู่ระบบ</a><br>
                <a href="register.php" class="">สมัครสมาชิก</a> <br> <a href="shop.php" class="">ซื้อโรบัค</a> <br>
                <a href="https://www.facebook.com/kKaramailSHOP" class="">ติดต่อแอดมิน</a> <br>
              </div>
            </div>
            <div class="col-md-4 col-xl-3 col-6">
              <h5 class="text-dark">ติดต่อ</h5>
              <div class="custom-line"></div>
              <div class="mt-3"><a href="https://www.facebook.com/kKaramailSHOP" target="_blank">
                  <span class="text-dark"><i class="fa-brands fa-facebook"></i> แฟนเพจ</span>
                </a><br class="mx-4"> <a href="#"><span class="text-dark"><i class="fa-brands fa-discord"></i> ดิสคอร์ด</span></a><br class="mx-4">
                <span class="text-dark"></span><br class="mx-4">
              </div>
            </div>
            <div class="col-xl-3 col-6">
              <h5 class="text-dark">แฟนเพจ</h5>
              <div class="custom-line mb-4"></div> <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FkKaramailSHOP&tabs=timeline&width=340&height=331&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=367733674521096" width="340" height="331" style="border:none;overflow:hidden;border-radius: 20px;" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
            </div>
          </div>
        </div>
      </footer>
    </section>
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
        const card = `<div class="category-all col-12 col-lg-3 mb-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="0">
            <a href="#" class="category-panel">
              <div class="category-image" style="width: 305px; height: 115px; border-style: solid;">
                <img src=` + category.rb_img + ` class="img-fluid" />
              </div>`;
        cards.insertAdjacentHTML('beforeend', card);
      }

    })
    .catch(error => console.log('error', error))
</script>