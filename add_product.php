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


if (isset($_POST['submit'])) {
    $rb_name = $_POST['rb_name'];
    $rb_price = $_POST['rb_price'];
    $rb_img = $_FILES['rb_img'];

    $allow = array('jpg', 'jpeg', 'png');
    $extension = explode('.', $rb_img['name']);
    $fileActExt = strtolower(end($extension));
    $fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
    $filePath = 'imgupload/' . $fileNew;

    if (in_array($fileActExt, $allow)) {
        if ($rb_img['size'] > 0 && $rb_img['error'] == 0) {
            if (move_uploaded_file($rb_img['tmp_name'], $filePath)) {
                $sql = $db->prepare("INSERT INTO category(rb_price, rb_name, rb_img) VALUES(:rb_price, :rb_name, :rb_img)");
                $sql->bindParam(":rb_name", $rb_name);
                $sql->bindParam(":rb_price", $rb_price);
                $sql->bindParam(":rb_img", $fileNew);
                $sql->execute();

                if ($sql) {
                    $_SESSION['success'] = "Data has been inserted successfully";
                    header("location: product.php");
                } else {
                    $_SESSION['error'] = "Data has not been inserted successfully";
                    header("location: product.php");
                }
            }
        }
    }
}


?>