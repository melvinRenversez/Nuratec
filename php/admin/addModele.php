<?php 

session_start();

include("./verifyUser.php");
include("../database.php");


$name = $_POST['name'];
$marque = $_POST['marque'];

$query = "insert into modele_appareil(libelle, marque_id) values(?, ?)";
$stmt = $db->prepare($query);
$stmt->execute([$name, $marque]);


$_SESSION["popup"] = true;
if ($stmt->rowCount() > 0) {
   header("Location: ../../admin/modele_appareil.php?popup=successAdd");
}else {
   header("Location: ../../admin/modele_appareil.php?popup=errorAdd");
}