<?php
    session_start();
    require_once 'connection.php';

if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if (empty($username)) {
        $_SESSION['error'] = 'กรุณาใส่ Username';
        header("location: login.php");
    }
    else if (empty($password)) {
        $_SESSION['error'] = 'กรุณาใส่รหัสผ่าน';
        header("location: login.php");
    }
    else if (strlen($_POST['password']) >20 || strlen($_POST['password']) <5) {
        $_SESSION['error'] = 'รหัสผ่านต้องมีความยาว 5 ถึง 20 ตัวอักษร';
        header("location: login.php");
    } 
    else {
        try {

            $check_data = $db->prepare("SELECT * FROM users WHERE username = :username");
            $check_data->bindParam(":username", $username);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);

            if ($check_data->rowCount() > 0) {
                if ($username == $row['username']) {
                    if(password_verify($password, $row['password'])) {
                        if ($row['role'] == 'admin') {
                            $_SESSION['admin_login'] = $row['user_id'];
                            header("location: admin.php");
                    } else {
                        $_SESSION['user_login'] = $row['user_id'];
                        header("location: user.php");
                    } 
                }  else {
                    $_SESSION['error'] = 'รหัสผ่านไม่ถูกต้อง';
                    header("location: login.php");
                } 
                } else {
                    $_SESSION['error'] = 'Username ไม่ถูกต้อง';
                    header("location: login.php");

                }
            }
            else {
                $_SESSION['error'] = 'ไม่มีข้อมูลในระบบ';
                header("location: login.php");
            }


        } catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}


?>