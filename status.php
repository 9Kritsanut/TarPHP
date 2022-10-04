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
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <!--Jquery-->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <!--Datatable-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
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
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mt-5">
                <h1>รายการสั่งซื้อของลูกค้า</h1>
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

        <table class="table" id="tableall">
            <thead>
                <tr>
                    <th scope="col">ชื่อลูกค้า</th>
                    <th scope="col">ออเดอร์ที่</th>
                    <th scope="col">แพ็คที่สั่งซื้อ</th>
                    <th scope="col">เวลาที่สั่งซื้อ</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $db->query("SELECT * FROM logrobux ORDER BY ID DESC");
                $stmt->execute();
                $category = $stmt->fetchAll();

                if (!$category) {
                    echo "<p><td colspan='6' class='text-center'>ยังไม่มีข้อมูลสินค้า</td></p>";
                } else {
                    foreach ($category as $category) {
                ?>
                        <tr>
                            <th scope="row"><?php echo $category['user']; ?></th>
                            <td><?php echo $category['id']; ?></td>
                            <td><?php echo $category['rb_name']; ?></td>
                            <td><?php echo $category['date']; ?></td>
                            <td>
                                <?php if ($category['status'] == 0) {
                                    echo "<p class='bg-warning pl-2' style='width: 118px; border-radius: 5px; color: white;'>กำลังดำเนินการ</p>";
                                } else if ($category['status'] == 1) {
                                    echo "<p class='bg-success pl-1' style='width: 115px; border-radius: 5px; color: white;'>ดำเนินการสำเร็จ</p>";
                                } else if ($category['status'] == 2) {
                                    echo "<a href='https://www.facebook.com/kKaramailSHOP' class='bg-danger pl-1' style='width: 115px; border-radius: 5px; color: white;'>ผิดพลาด！กดเพื่อติดต่อแอดมิน</a>";
                                } ?>
                                <a href="edit_status.php?status_id=<?php echo $category["id"]; ?>" class="btn btn-warning">แสดงข้อมูล</a>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>


    <!--Datatable-->
    <script>
    $(document).ready(function() {
        $('#tableall').DataTable();
    });
</script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</body>

</html>
