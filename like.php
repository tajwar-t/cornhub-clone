<?php
include 'db.php';

$id = $_POST['id'] ?? 0;
$id = (int)$id;

if($id > 0){
    $conn->query("UPDATE videos SET likes = likes + 1 WHERE id = $id");
    $res = $conn->query("SELECT likes FROM videos WHERE id = $id");
    $likes = $res->fetch_assoc()['likes'];
    echo json_encode(['success'=>true,'likes'=>$likes]);
}else{
    echo json_encode(['success'=>false]);
}
?>
