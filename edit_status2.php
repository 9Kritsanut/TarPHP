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
    

    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $status = $_POST['rb_status'];

        $sql = $db->prepare("UPDATE logrobux SET status = :rb_status WHERE id = :id");
        $sql->bindParam(":id", $id);
        $sql->bindParam(":rb_status", $status);
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
                            <a class="btn btn-primary active" aria-current="page" href="admin.php"><i class="fa-solid fa-house-chimney"></i> Home</a>
                        </li>
                        <li class="nav-item pt-3">
                            <a class="nav-link" href="#"><i class="fa-sharp fa-solid fa-coins"></i> จัดการ Points</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <div class="container" style="padding-top: 4%;">
        <h1>รายการลูกค้า</h1>
        <hr>
        <form action="edit_status.php" method="post" enctype="multipart/form-data">
            <?php
                if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $stmt = $db->query("SELECT * FROM logrobux WHERE id = $id");
                        $stmt->execute();
                        $row = $stmt->fetch();
                }
            ?>
                <div class="mb-3">
                    <label for="id" class="col-form-label">USER:</label>
                    <input type="text" readonly value="<?php echo $row['user']; ?>" required class="form-control" name="id" >
                    <label for="rb_name" class="col-form-label">ชื่อสินค้า:</label>
                    <input type="text" value="<?php echo $row['rb_name']; ?>" required class="form-control" name="rb_name" >
                </div>
                <div class="mb-3">
                    <label for="rb_user" class="col-form-label">IDPASS:</label>
                    <input type="text" value="<?php echo $row['rb_user']; ?>" required class="form-control" name="rb_user">
                </div>
                <hr>
                <a href="status.php" class="btn btn-danger mb-5">ย้อนกลับ</a>
                <button type="submit" name="update" class="btn btn-success mb-5">อัพเดท</button>
            </form>
    </div>



    <!--JS-->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>
</html>