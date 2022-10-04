<?php
session_start();
require_once 'connection.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ';
    header('location: login.php');
}
if (isset($_SESSION['user_login'])) {
    header('location: user.php');
}


if (isset($_SESSION['admin_login'])) {
    $admin_id = $_SESSION['admin_login'];
    $statement = $db->query("SELECT * FROM users WHERE user_id = $admin_id");
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/logo.ico">
    <title>Karamail Menu</title>
    <!-- CSS only -->
    <!-- JavaScript Bundle with Popper -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
</head>

<body style="font-family: Kanit, sans-serif;">

    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Menu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">ผู้ใช้: <?php echo $row['username'] ?></h5>
                    <li class="nav-item" style="margin-left: 70px;">
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </li>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-success" type="submit">Search</button>
                        </form>
                        <li class="nav-item  pt-3">
                            <a class="btn btn-primary active" aria-current="page" href="admin.php"><i class="fa-solid fa-house-chimney"></i> หน้าแรก</a>
                        </li>
                        <li class="nav-item pt-3">
                            <a class="nav-link" href="crud.php"><i class="fa-sharp fa-solid fa-list"></i> จัดการ Points</a>
                        </li>
                        <li class="nav-item pt-3">
                            <a class="nav-link" href="product.php"><i class="fa-sharp fa-solid fa-list"></i> จัดการ รายการสินค้า</a>
                        </li>
                        <li class="nav-item pt-3">
                            <a class="nav-link" href="status.php"><i class="fa-sharp fa-solid fa-list"></i> จัดการ สถานะสั่งซื้อ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <!--<div class="col-12 col-lg-4 mt-2">
        <div class="card-body">
            <h5 class="card-title"><i class="fa-sharp fa-solid fa-coins"></i> ตัวจัดการ Points</h5>
            <p class="card-text">เป็นตัวจัดการและดูแลเกี่ยวกับ Points ของ Users ทั้งหมด.</p>
            <a href="crud.php" class="btn btn-warning">Manage Points</a>
        </div>-->
    <div class="container-card">
        <div class="row" style="width: 100%; padding: 1%;">
            <div class="col-lg-2 mt-5" style="margin-left: 60px; padding-top: 10px;">
                <div class="card2">
                    <div class="card-body2" style="margin-left: 20%;">
                        <h5 class="card-title2 mt-3" style="display: flex; margin-left: 5px;"><i class="fa-sharp fa-solid fa-coins"></i> ตัวจัดการ Points</h5>
                        <p class="bg-light" style="border-radius: 10px; display: flex; color: green;  margin-left: 0px; width: 15rem;"> เป็นตัวจัดการและดูแลเกี่ยวกับ Points ของ Users ทั้งหมด.</p>
                        <a href="crud.php" class="btn mt-2 btn-warning">Manage Point</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mt-5" style="margin-left: 60px; padding-top: 10px;">
                <div class="card2">
                    <div class="card-body2" style="margin-left: 20%;">
                        <h5 class="card-title2 mt-3" style="display: flex; margin-left: 5px;"><i class="fa-sharp fa-solid fa-cash-register"></i> ตัวจัดการ รายการสินค้า</h5>
                        <p class="bg-light" style="border-radius: 10px; display: flex; color: green;  margin-left: 0px; width: 15rem;"> เป็นตัวจัดการและดูแลเกี่ยวกับ รายการสินค้า ของ Users ทั้งหมด.</p>
                        <a href="product.php" class="btn mt-2 btn-warning">Manage Store</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mt-5" style="margin-left: 60px; padding-top: 10px;">
                <div class="card2">
                    <div class="card-body2" style="margin-left: 20%;">
                        <h5 class="card-title2 mt-3" style="display: flex; margin-left: 5px;"><i class="fa-sharp fa-solid fa-clipboard"></i></i> ตัวจัดการ สถานะสั่งซื้อ</h5>
                        <p class="bg-light" style="border-radius: 10px; display: flex; color: green;  margin-left: 0px; width: 15rem;"> เป็นตัวจัดการและดูแลเกี่ยวกับ รายการสินค้า ของ Users ทั้งหมด.</p>
                        <a href="status.php" class="btn mt-2 btn-warning">Manage Status</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <!--<div class="card-body">
            <h5 class="card-title"><i class="fa-sharp fa-solid fa-cash-register"></i> ตัวจัดการ รายการสินค้า</h5>
            <p class="card-text">เป็นตัวจัดการและดูแลเกี่ยวกับ รายการสินค้า ของ Users ทั้งหมด.</p>
            <a href="product.php" class="btn btn-warning">Manage Store</a>
        </div>-->

</body>

</html>