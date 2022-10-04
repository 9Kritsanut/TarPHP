<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
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


if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $deletestmt = $db->query("DELETE FROM category WHERE id = $delete_id");
    $deletestmt->execute();

    if ($deletestmt) {
        echo "<script>alert('Data has been deleted successfully');</script>";
        $_SESSION['success'] = "Data has been deleted succesfully";
        header("refresh:1; url=product.php");
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
    <title>Karamail Menu</title>
    <!-- CSS only -->
    <!-- JavaScript Bundle with Popper -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
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
                            <a class="nav-link" href="status.php"><i class="fa-sharp fa-solid fa-list"></i> จัดการ สถานะสั่งซื้อ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>


    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">เพิ่มสินค้า</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="add_product.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="rb_name" class="col-form-label">ชื่อสินค้า:</label>
                    <input type="text" required class="form-control" name="rb_name">
                </div>
                <div class="mb-3">
                    <label for="rb_price" class="col-form-label">ราคาสินค้า:</label>
                    <input type="text" required class="form-control" name="rb_price">
                </div>
                <div class="mb-3">
                    <label for="rb_img" class="col-form-label">รูปสินค้า:</label>
                    <input type="file" required class="form-control" id="imgInput" name="rb_img">
                    <img loading="lazy" width="100%" id="previewImg" alt="">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" name="submit" class="btn btn-success">เพิ่มสินค้า</button>
                </div>
            </form>
        </div>
        
        </div>
    </div>
    </div>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mt-5">
                <h1>รายการสินค้า</h1>
            </div>
            <div class="col-md-6 d-flex mt-5 justify-content-end">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#userModal" data-bs-whatever="@mdo">+ เพิ่มสินค้า</button>
            </div>
        </div>
        <hr>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']); 
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']); 
                ?>
            </div>
        <?php } ?>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">ชื่อสินค้า</th>
                    <th scope="col">ราคาสินค้า</th>
                    <th scope="col">รูปสินค้า</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $stmt = $db->query("SELECT * FROM category");
                    $stmt->execute();
                    $category = $stmt->fetchAll();

                    if (!$category) {
                        echo "<p><td colspan='6' class='text-center'>ยังไม่มีข้อมูลสินค้า</td></p>";
                    } else {
                    foreach($category as $category)  {  
                ?>
                    <tr>
                        <th scope="row"><?php echo $category['id']; ?></th>
                        <td><?php echo $category['rb_name']; ?></td>
                        <td><?php echo $category['rb_price']; ?></td>
                        <td width="80px"><img class="rounded" width="100%" src="imgupload/<?php echo $category['rb_img']; ?>" alt=""></td>
                        <td>
                            <a href="edit_product.php?id=<?php echo $category['id']; ?>" class="btn btn-warning">Edit</a>
                            <a onclick="return confirm('Are you sure you want to delete?');" href="?delete=<?php echo $category['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php }  } ?>
            </tbody>
            </table>
    </div>


 <!--JS-->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>