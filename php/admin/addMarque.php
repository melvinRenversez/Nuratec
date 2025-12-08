<?php 

session_start();

include("./verifyUser.php");
include("../database.php");


$name = $_POST['name'];
$type = $_POST['type'];

$query = "insert into marque_appareil(libelle, type_id) values(?, ?)";
$stmt = $db->prepare($query);
$stmt->execute([$name, $type]);



$_SESSION["popup"] = true;
if ($stmt->rowCount() > 0) {
   header("Location: ../../admin/marque_appareil.php?popup=successAdd");
}else {
   header("Location: ../../admin/marque_appareil.php?popup=errorAdd");
}