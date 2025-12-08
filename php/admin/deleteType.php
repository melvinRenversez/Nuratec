<?php 

session_start();
include("./verifyUser.php");
include("../database.php");


$id = $_GET['id'];


$query = "delete from type_appareil where id = :id";

$stmt = $db->prepare($query);
$stmt->bindValue(':id', $id);
$stmt->execute();

$_SESSION["popup"] = true;
if ($stmt->rowCount() > 0) {
   header("Location: ../../admin/type_appareil.php?popup=successDelete");
}else {
   header("Location: ../../admin/type_appareil.php?popup=errorDelete");
}
