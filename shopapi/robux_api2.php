<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 require_once '../connection.php';
 try {
  $stmt = $db->prepare("SELECT * FROM category WHERE id=:id");
  $stmt->bindParam(':id', $_GET['id']);
  $stmt->execute();

  foreach ($stmt as $row) {
    $category = array(
      'id' => $row['id'],
      'rb_name' => $row['rb_name'],
      'rb_price' => $row['rb_price'],
      'rb_img' => $row['rb_img'],
  );
  echo json_encode($category);
  }

    $db = null;
 } catch(PDOException $e) {
   print "ERROR!: " . $e->getMessage() . "<br/>";
   die();
 }

?>