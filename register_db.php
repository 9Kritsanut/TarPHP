<?php
    session_start();
    require_once 'connection.php';

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $role = 'user';

    if (empty($username)) {
        $_SESSION['error'] = 'กรุณาใส่ Username';
        header("location: register.php");
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'กรุณาใส่อีเมลหรือรูปแบบอีเมลไม่ถูกต้อง';
        header("location: register.php");
    }
    else if (empty($password)) {
        $_SESSION['error'] = 'กรุณาใส่รหัสผ่าน';
        header("location: register.php");
    }
    else if (strlen($_POST['password']) >20 || strlen($_POST['password']) <5) {
        $_SESSION['error'] = 'รหัสผ่านต้องมีความยาว 5 ถึง 20 ตัวอักษร';
        header("location: register.php");
    }
    else if (empty($c_password)) {
        $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
        header("location: register.php");
    }
    else if ($password != $c_password) {
        $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
        header("location: register.php");
    } else {
        try {

            $check_user = $db->prepare("SELECT username FROM users WHERE username = :username");
            $check_user->bindParam(":username", $username);
            $check_user->execute();
            $row = $check_user->fetch(PDO::FETCH_ASSOC);

            if ($row['username'] == $username ){
                $_SESSION['warning'] = "มีผู้ใช้นี้อยู่ในระบบแล้ว <a href='login.php'>คลิกที่นี่</a> เพื่อเข้าสู่ระบบ";
                header("location: register.php");
                
            }
            else if (!isset($_SESSION['error'])) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $statement = $db->prepare("INSERT INTO users( username, email, password, role) 
                                            VALUES(:username, :email, :password, :role)");
                $statement->bindParam(":username", $username);
                $statement->bindParam(":email", $email);
                $statement->bindParam(":password", $passwordHash);
                $statement->bindParam(":role", $role);
                $statement->execute();
                $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='login.php' class ='alert_link'>คลิกที่นี่</a> เพื่อเข้าสู่ระบบ";
                header("location: register.php");
            }
            else {
                $_SESSION['error'] = 'มีบางอย่างผิดพลาด';
                header("location: register.php");
            }


        } catch(PDOException $e){
            echo $e->getMessage();
        }
    }
}


?>