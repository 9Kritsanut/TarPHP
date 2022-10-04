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

if (isset($_SESSION['user_login'])) {
    $users_id = $_SESSION['user_login'];
    $statement = $db->query("SELECT * FROM users WHERE user_id = $users_id");
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
}



if (isset($_REQUEST['btn_update'])) {
    if (isset($_SESSION['user_login'])) {
        $ids = $_SESSION['user_login'];
        $statement = $db->query("SELECT * FROM users WHERE user_id = $ids");
        $statement->execute();
        $rows = $statement->fetch(PDO::FETCH_ASSOC);
    }
    $user = $_REQUEST['user'];
    $rb_user = $_REQUEST['rb_user'];
    $rb_uid = $_REQUEST['rb_uid'];
    $rb_pass = $_REQUEST['rb_pass'];
    $rb_name = $_REQUEST['rb_name'];
    $user_point = $_REQUEST['user_point'];
    $rb_price = $_REQUEST['rb_price'];

    if (empty($rb_user)) {
        $errorMsg = "กรุณาใส่ ID ROBLOX";
    } else if (empty($rb_pass)) {
        $errorMsg = "กรุณาใส่ PASSWORD ROBLOX";
    } else if ($user_point < $rb_price) {
        $errorMsg = "Point ไม่เพียงพอ กรุณาเติม Point เพิ่ม";
    } else {
        try {
            if (!isset($errorMsg)) {

                $usepoint = ($user_point - $rb_price);

                $update_point = $db->prepare("UPDATE users SET user_point = :usepoint WHERE user_id = :user_id");
                $update_point->bindParam(':usepoint', $usepoint);
                $update_point->bindParam(':user_id', $ids);

                if ($update_point->execute()) {
                    $updateMsg2 = "หัก Point เรียบร้อย";
                }

                $update_stmt = $db->prepare("INSERT INTO logrobux (user,rb_uid, rb_user, rb_pass, rb_name) VALUES (:user,:rb_uid ,:rb_user, :rb_pass, :rb_name)");
                $update_stmt->bindParam(':user', $user);
                $update_stmt->bindParam(':rb_uid', $rb_uid);
                $update_stmt->bindParam(':rb_user', $rb_user);
                $update_stmt->bindParam(':rb_pass', $rb_pass);
                $update_stmt->bindParam(':rb_name', $rb_name);

                if ($update_stmt->execute()) {
                    $updateMsg = "ทำรายการสำเร็จ...";
                    header("refresh:2;user-info.php");
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}




//if (isset($_POST['buy'])) {
//    $user = $_POST['user'];
//  $rb_user = $_POST['rb_user'];
//  $rb_pass = $_POST['rb_pass'];

//   if (empty($rb_user)) {
//      $errorMsg = "Please Enter Roblox Username";
//  } else if (empty($rb_pass)) {
//      $errorMsg = "Please Enter Roblox Password";
//  } else {
//      try {
//         if (!isset($errorMsg)) {
//             $buy_stmt = $db->prepare("INSERT INTO tbl_member (user, rb_user, rb_pass) VALUES (:username, :rb_user, :rb_pass)");
//             $buy_stmt->bindParam(':username', $user);
//             $buy_stmt->bindParam(':rb_user', $rb_user);
//            $buy_stmt->bindParam(':rb_pass', $rb_pass);
//             $buy_stmt->bindParam(':id', $id);
//
//            if ($buy_stmt->execute()) {
//                $updateMsg = "สั่งซื้อสินค้าเรียบร้อย...";
//                header("refresh:2;user_info.php");
//             }
//         }
//     } catch (PDOException $e) {
//          echo $e->getMessage();
//      }
//  }
//} 

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

    <div class="container-shop text-center">
        <h1 id="rb_name" hidden style="color: red;">...</h1>
        <p id="rb_price" hidden style="color: red;">...</p>

    </div>

    <div class="container text-light" style="padding-top: 4%;">
        <h1 class="text-light">ยืนยันการสั่งซื้อ</h1>
        <hr>

        <?php
        if (isset($errorMsg)) {
        ?>
            <div class="alert alert-danger">
                <strong>ผิดพลาด ! <?php echo $errorMsg; ?></strong>
            </div>
        <?php } ?>


        <?php
        if (isset($updateMsg)) {
        ?>
            <div class="alert alert-success">
                <strong>สำเร็จ ! <?php echo $updateMsg; ?></strong>
            </div>
        <?php } ?>


        <?php
        if (isset($updateMsg2)) {
        ?>
            <div class="alert alert-success">
                <strong>สำเร็จ ! <?php echo $updateMsg2; ?></strong>
            </div>
        <?php } ?>

        <form method="post" class="form-horizontal text-dark align-center" style="margin-left: 25%;">
            <div class="form-group text-center mt-5" style="margin-left: 20%;">

                <div class="row">
                    <label for="user" class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                        <input type="text" style="width: 50%;" name="user" class="form-control" value="<?php echo $row['username'] ?>" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-9">
                        <input type="text" style="width: 50%;" name="rb_uid" class="form-control" value="<?php echo $row['user_id'] ?>" hidden>
                    </div>
                </div>
            </div>
            <div class="form-group text-center" style="margin-left: 20%;">
                <div class="row mt-3">
                    <label for="rb_user" class="col-sm-3 control-label">ROBLOX ID</label>
                    <div class="col-sm-9">
                        <input type="text" min="0" style="width: 50%;" name="rb_user" class="form-control" placeholder="ใส่ Roblox ID">
                    </div>
                </div>
            </div>
            <div class="form-group text-center" style="margin-left: 20%;">
                <div class="row mt-3">
                    <label for="rb_price" class="col-sm-3 control-label">ROBLOX PASSWORD</label>
                    <div class="col-sm-9">
                        <input type="text" min="0" style="width: 50%;" name="rb_pass" class="form-control" placeholder="ใส่ Roblox Password">
                    </div>
                </div>
            </div>
            <div class="form-group text-center" style="margin-left: 20%;">
                <div class="row mt-3">
                    <label for="rb_name" class="col-sm-3 control-label" hidden>จำนวนพ้อยต์ที่มี</label>
                    <div class="col-sm-9">
                        <input type="text" min="0" style="width: 50%;" name="user_point" class="form-control" value="<?php echo $row['user_point'] ?>" hidden>
                    </div>
                </div>
            </div>
            <div class="form-group text-center" style="margin-left: 20%;">
                <div class="row mt-3">
                    <label for="rb_name" class="col-sm-3 control-label">ชื่อสินค้า</label>
                    <div class="col-sm-9">
                        <?php
                        if (isset($_REQUEST['id'])) {
                            try {
                                $id = $_REQUEST['id'];
                                $select_stmt = $db->prepare("SELECT * FROM category WHERE id = :id");
                                $select_stmt->bindParam(':id', $id);
                                $select_stmt->execute();
                                $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
                                extract($row);
                            } catch (PDOException $e) {
                                $e->getMessage();
                            }
                        } ?>
                        <input type="text" min="0" style="width: 50%;" name="rb_name" class="form-control" value="<?php echo $row['rb_name'] ?>" readonly>
                        <input type="text" min="0" style="width: 50%;" name="rb_price" class="form-control" value="<?php echo $row['rb_price'] ?>" hidden>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="สั่งซื้อสินค้า">
                    <a href="shop.php" class="btn btn-danger">ยกเลิก</a>
                </div>
            </div>
    </div>
    </form>


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
    const url_params = new URLSearchParams(window.location.search);
    const id = url_params.get('id');

    var requestOptions = {
        method: 'GET',
        redirect: 'follow'
    };

    fetch("http://localhost/karamailshop/shopapi/robux_api2.php?id=" + id, requestOptions)
        .then(response => response.text())
        .then(result => {
            var jsonOBJ = JSON.parse(result);
            document.getElementById('rb_name').innerText = jsonOBJ.rb_name;
            document.getElementById('rb_price').innerText = jsonOBJ.rb_price;

        })
        .catch(error => console.log('error', error))
</script>