<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 require_once '../connection.php';
 try {
    $categorys = array();
    foreach($db->query('SELECT * FROM category') as $row) {
        $category = array(
            'id' => $row['id'],
            'rb_name' => $row['rb_name'],
            'rb_price' => $row['rb_price'],
            'rb_img' => $row['rb_img'],
        );
        array_push($categorys, $category);
    }
    echo json_encode($categorys);
    $db = null;
 } catch(PDOException $e) {
   print "ERROR!: " . $e->getMessage() . "<br/>";
   die();
 }

?>