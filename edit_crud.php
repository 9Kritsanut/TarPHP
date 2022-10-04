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


if (isset($_REQUEST['update_id'])) {
    try {
        $id = $_REQUEST['update_id'];
        $select_stmt = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $select_stmt->bindParam(':user_id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        
    } catch(PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_REQUEST['btn_update'])) {
    $point_up = $_REQUEST['txt_lastname'];

    if (empty($point_up)) {
        $errorMsg = "Please Enter Point";
    } else {
        try {
            if (!isset($errorMsg)) {
                $update_stmt = $db->prepare("UPDATE users SET user_point = :point_up WHERE user_id = :user_id");
                $update_stmt->bindParam(':point_up', $point_up);
                $update_stmt->bindParam(':user_id', $id);

                if ($update_stmt->execute()) {
                    $updateMsg = "Record update successfully...";
                    echo "<script>
                    $(document).ready(function(){
                        Swal.fire({
                            title: 'success',
                            text: 'บันทึกข้อมูลสำเร็จ',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    });
                    
                    </script>";
                    header("refresh:2;crud.php");
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
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



    <div class="container">
    <div class="display-3 text-center mt-5">Edit Page</div>

    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>

    <form method="post" class="form-horizontal" style="margin-left: 25%;">
            
            <div class="form-group text-center mt-5">
                <div class="row">
                    <label for="firstname" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" style="width: 30%;" name="txt_firstname" class="form-control" value="<?php echo $username; ?>" disabled>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="row mt-3">
                    <label for="lastname" class="col-sm-3 control-label">Point</label>
                    <div class="col-sm-9">
                        <input type="number" min="0"   style="width: 30%;" name="txt_lastname" class="form-control" value="<?php echo $user_point; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="crud.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>

    </form>
    </div>
</body> 

</html>