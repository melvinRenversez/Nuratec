<?php 

session_start();

include("./verifyUser.php");
include("../database.php");


$name = $_POST['name'];

$query = "insert into type_appareil(libelle) values(?)";
$stmt = $db->prepare($query);
$stmt->execute([$name]);

$_SESSION["popup"] = true;
if ($stmt->rowCount() > 0) {
   header("Location: ../../admin/type_appareil.php?popup=successAdd");
}else {
   header("Location: ../../admin/type_appareil.php?popup=errorAdd");
}