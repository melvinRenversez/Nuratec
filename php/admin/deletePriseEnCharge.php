<?php 

session_start();
include("./verifyUser.php");
include("../database.php");


$id = $_GET['id'];


$query = "delete from prise_en_charge where id = :id";

$stmt = $db->prepare($query);
$stmt->bindValue(':id', $id);
$stmt->execute();

$_SESSION["popup"] = true;
if ($stmt->rowCount() > 0) {
   header("Location: ../../admin/prise_en_charge.php?popup=successDelete");
}else {
   header("Location: ../../admin/prise_en_charge.php?popup=errorDelete");
}
