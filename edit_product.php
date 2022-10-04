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

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $rb_name = $_POST['rb_name'];
        $rb_price = $_POST['rb_price'];
        $rb_img = $_FILES['rb_img'];

        $rb_img2 = $_POST['rb_img2'];
        $upload = $_FILES['rb_img']['name'];

        if ($upload != '') {
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $rb_img['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
            $filePath = 'imgupload/'.$fileNew;

            if (in_array($fileActExt, $allow)) {
                if ($rb_img['size'] > 0 && $rb_img['error'] == 0) {
                   move_uploaded_file($rb_img['tmp_name'], $filePath);
                }
            }

        } else {
            $fileNew = $rb_img2;
        }

        $sql = $db->prepare("UPDATE category SET rb_name = :rb_name, rb_price = :rb_price, rb_img = :rb_img WHERE id = :id");
        $sql->bindParam(":id", $id);
        $sql->bindParam(":rb_name", $rb_name);
        $sql->bindParam(":rb_price", $rb_price);
        $sql->bindParam(":rb_img", $fileNew);
        $sql->execute();

        if ($sql) {
            $_SESSION['success'] = "อัพเดทข้อมูลเรียบร้อยแล้ว";
            header("location: product.php");
        } else {
            $_SESSION['error'] = "ไม่สามารถอัพเดทข้อมูลได้";
            header("location: product.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/logo.ico">
    <title>Karamail Shop</title>
    <!-- CSS only -->
    <!-- JavaScript Bundle with Popper -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>
<body  style="font-family: Kanit, sans-serif;">


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


    <div class="container" style="padding-top: 4%;">
        <h1>แก้ไขข้อมูลสินค้า</h1>
        <hr>
        <form action="edit_product.php" method="post" enctype="multipart/form-data">
            <?php
                if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $stmt = $db->query("SELECT * FROM category WHERE id = $id");
                        $stmt->execute();
                        $data = $stmt->fetch();
                }
            ?>
                <div class="mb-3">
                    <label for="id" class="col-form-label">ID:</label>
                    <input type="text" readonly value="<?php echo $data['id']; ?>" required class="form-control" name="id" >
                    <label for="rb_name" class="col-form-label">ชื่อสินค้า:</label>
                    <input type="text" value="<?php echo $data['rb_name']; ?>" required class="form-control" name="rb_name" >
                    <input type="hidden" value="<?php echo $data['rb_img']; ?>" required class="form-control" name="rb_img2" >
                </div>
                <div class="mb-3">
                    <label for="rb_price" class="col-form-label">ราคาสินค้า:</label>
                    <input type="text" value="<?php echo $data['rb_price']; ?>" required class="form-control" name="rb_price">
                </div>
                <div class="mb-3">
                    <label for="rb_img" class="col-form-label">รูปสินค้า:</label>
                    <input type="file" class="form-control" id="imgInput" name="rb_img">
                    <img width="50%" src="imgupload/<?php echo $data['rb_img']; ?>" id="previewImg" alt="">
                </div>
                <hr>
                <a href="product.php" class="btn btn-danger mb-5">ย้อนกลับ</a>
                <button type="submit" name="update" class="btn btn-success mb-5">อัพเดท</button>
            </form>
    </div>

    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
                if (file) {
                    previewImg.src = URL.createObjectURL(file)
            }
        }

    </script>

    <!--JS-->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>