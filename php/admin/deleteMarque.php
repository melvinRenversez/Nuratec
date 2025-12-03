<?php 

session_start();
include("./verifyUser.php");
include("../database.php");


$id = $_GET['id'];


$query = "delete from marque_appareil where id = :id";

$stmt = $db->prepare($query);
$stmt->bindValue(':id', $id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
   header("Location: ../../admin/marque_appareil.php?popup=successDelete");
}else {
   header("Location: ../../admin/marque_appareil.php?popup=errorDelete");
}
