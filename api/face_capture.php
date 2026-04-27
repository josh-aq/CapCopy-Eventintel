<?php
require_once __DIR__ . '/../config/db.php';
header('Content-Type: application/json');
$data=json_decode(file_get_contents('php://input'),true);
$image=$data['image']??'';
if(!str_starts_with($image,'data:image')){echo json_encode(['ok'=>false]);exit;}
$image=preg_replace('#^data:image/\w+;base64,#i','',$image);
$name='faces/face_'.uniqid().'.png';
file_put_contents(__DIR__.'/../uploads/'.$name, base64_decode($image));
echo json_encode(['ok'=>true,'path'=>'uploads/'.$name]);
?>