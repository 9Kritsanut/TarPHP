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
?>


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
      <!--Jquery-->
      <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <!--Datatable-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
</head>

<body>
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
        
        </div>
    </div>
    </div>
    
    <div class="container mt-5 bg-light" style="border-radius: 10px;">
        <div class="row">
            <div class="col-md-6 mt-5">
                <h1>รายการสินค้าของฉัน</h1>
            </div>
        </div>
        <hr>

        <table class="table" id="carttable">
            <thead>
                <tr>
                    <th scope="col">รายการที่</th>
                    <th scope="col">ชื่อสินค้า</th>
                    <th scope="col">เวลาที่สั่งซื้อ</th>
                    <th scope="col">Actions</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                    $stmt = $db->query("SELECT * FROM logrobux WHERE rb_uid = $users_id");
                    $stmt->execute();
                    $logrobux = $stmt->fetchAll();

                    if (!$logrobux) {
                        echo "<p><td colspan='6' class='text-center'>ยังไม่มีข้อมูลสินค้า</td></p>";
                    } else {
                    foreach($logrobux as $logrobux)  {  
                ?>
                    <tr>
                        <th scope="row"><?php echo $logrobux['id']; ?></th>
                        <td><?php echo $logrobux['rb_name']; ?></td>
                        <td><?php echo $logrobux['date']; ?></td>
                        <td><?php if($logrobux['status'] == 0){
                            echo "<p class='bg-warning pl-2' style='width: 118px; border-radius: 5px; color: white;'>กำลังดำเนินการ</p>";

                        }
                        else if ($logrobux['status'] == 1 ) {
                            echo "<p class='bg-success pl-1' style='width: 115px; border-radius: 5px; color: white;'>ดำเนินการสำเร็จ</p>";
                        } 
                        else if ($logrobux['status'] == 2) {
                          echo "<a href='https://www.facebook.com/kKaramailSHOP' target='_blank' class='bg-danger pl-1' style='width: 115px; border-radius: 5px; color: white;'>ผิดพลาด！กดเพื่อติดต่อแอดมิน</a>";
                      }
                        ?></td>
                    </tr>
                <?php }  } ?>
            </tbody>
            </table>
    </div>
  <!--Datatable-->
  <script>
    $(document).ready(function() {
        $('#carttable').DataTable();
    });
</script>

    <!--JS-->
  
    <div class="footer fixed-buttom">
    <p></i>Copyright © 2022 Karamail Shop - All Right Reserved.</p>
  </div>
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




