<?php 

session_start();

include("./verifyUser.php");
include("../database.php");


$name = $_POST['name'];

$query = "insert into prise_en_charge(libelle) values(?)";
$stmt = $db->prepare($query);
$stmt->execute([$name]);

$_SESSION["popup"] = true;
if ($stmt->rowCount() > 0) {
   header("Location: ../../admin/prise_en_charge.php?popup=successAdd");
}else {
   header("Location: ../../admin/prise_en_charge.php?popup=errorAdd");
}